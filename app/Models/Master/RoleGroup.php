<?php

namespace App\Models\Master;

use App\Imports\Master\ExampleImport;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Change\Change;
use App\Models\Change\ChangeHelpdesk;
use App\Models\Incident\Incident;
use App\Models\Incident\IncidentHelpdesk;
use App\Models\Model;
use App\Models\Problem\Problem;
use App\Models\Problem\ProblemHelpdesk;
use App\Models\Setting\Globals\TempFiles;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoleGroup extends Model
{
    const HELPDESK      = Role::HELPDESK;
    const TECHNICIAN    = Role::TECHNICIAN;

    protected $table = 'ref_role_groups';

    protected $fillable = [
        'role_id',
        'name',
    ];

    protected $dates = [];

    /*******************************
     ** MUTATOR
     *******************************/
    public function setRegistDateAttribute($value)
    {
        $this->attributes['regist_date'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    /*******************************
     ** ACCESSOR
     *******************************/

    /*******************************
     ** RELATION
     *******************************/
    public function changesHelpdesk(): HasMany
    {
        return $this->hasMany(ChangeHelpdesk::class, 'group_id');
    }
    public function incidentsHelpdesk(): HasMany
    {
        return $this->hasMany(IncidentHelpdesk::class, 'group_id');
    }
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            RoleGroupMember::class,
            'role_group_id',
            'user_id',
        );
    }
    public function problemsHelpdesk(): HasMany
    {
        return $this->hasMany(ProblemHelpdesk::class, 'group_id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function types()
    {
        return $this->belongsToMany(
            AssetType::class,
            RoleGroupAssetType::class,
            'role_group_id',
            'asset_type_id',
        );
    }

    /*******************************
     ** SCOPE
     *******************************/

    public function scopeFilters($query)
    {
        return $query->filterBy(['name']);
    }

    public function scopeIsHelpdesk($query)
    {
        return $query->where('role_id', Self::HELPDESK);
    }
    public function scopeIsTechnician($query)
    {
        return $query->where('role_id', Self::TECHNICIAN);
    }

    /*******************************
     ** SAVING
     *******************************/
    public function handleStoreOrUpdate($request)
    {
        $this->beginTransaction();
        try {
            $this->fill($request->only($this->fillable));
            $this->save();
            $this->members()->sync($request->member_ids ?? []);
            $this->types()->sync($request->asset_type_ids ?? []);
            $this->saveLogNotify();

            return $this->commitSaved();
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleDestroy()
    {
        $this->beginTransaction();
        try {
            $this->saveLogNotify();
            RoleGroupAssetType::where('role_group_id', $this->id)->delete();
            RoleGroupMember::where('role_group_id', $this->id)->delete();
            $this->delete();

            return $this->commitDeleted();
        } catch (\Exception $e) {
            return $this->rollbackDeleted($e);
        }
    }

    public function handleImport($request)
    {
        $this->beginTransaction();
        try {
            $file = TempFiles::find($request->uploads['temp_files_ids'][0]);
            if (!$file || !\Storage::disk('public')->exists($file->file_path)) {
                $this->rollback('File tidak tersedia!');
            }

            $filePath = \Storage::disk('public')->path($file->file_path);
            \Excel::import(new ExampleImport(), $filePath);

            $this->saveLogNotify();

            return $this->commitSaved();
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function saveLogNotify()
    {
        $data = $this->name;
        $routes = request()->get('routes');
        switch (request()->route()->getName()) {
            case $routes . '.store':
                $this->addLog('Membuat Data ' . $data);
                break;
            case $routes . '.update':
                $this->addLog('Mengubah Data ' . $data);
                break;
            case $routes . '.destroy':
                $this->addLog('Menghapus Data ' . $data);
                break;
        }
    }

    /*******************************
     ** OTHER FUNCTIONS
     *******************************/
    public function canDeleted()
    {
        if ($this->problemsHelpdesk()->exists()) return false;
        if ($this->incidentsHelpdesk()->exists()) return false;

        return true;
    }

    public function getMembersRaw()
    {
        $str = '<div class="d-flex align-items-center justify-content-center make-td-py-0">
                    <div class="symbol-group symbol-hover">';
        $overCount = 0;
        $overName = '';
        foreach ($this->members as $i => $member) {
            if ($i < 5) {
                $str .= '<div class="symbol symbol-30 symbol-circle symbol-light-success"
                            data-toggle="tooltip" title="' . $member->name . '">
                            <span class="symbol-label font-size-h5">' . $member->name[0] . '</span>
                        </div>';
            } else {
                $overCount++;
                $overName .= $member->name . ($i == $this->members->count() - 1 ? '' : ', ');
            }
        }
        if ($overCount > 2) {
            $str .= '<div class="symbol symbol-30 symbol-circle symbol-light-success"
                        data-toggle="tooltip" title="' . $overName . '"
                        data-html="true" data-placement="right">
                        <span class="symbol-label font-weight-bold">' . $overCount . '+</span>
                    </div>';
        }
        $str .= '
                        </div>
                    </div>';
        return $str;
    }

    public function checkMembership($user_id)
    {
        return $this->members()->where('id', $user_id)->count();
    }
}
