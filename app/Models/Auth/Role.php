<?php

namespace App\Models\Auth;

use App\Imports\Setting\RoleImport;
use App\Models\Auth\User;
use App\Models\Setting\Globals\Approval;
use App\Models\Setting\Globals\MenuFlow;
use App\Models\Setting\Globals\TempFiles;
use App\Models\Traits\HasFiles;
use App\Models\Traits\RaidModel;
use App\Models\Traits\ResponseTrait;
use App\Models\Traits\Utilities;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use RaidModel, Utilities, ResponseTrait;
    use HasFiles;

    const ADMINISTRATOR = 1;
    const HELPDESK = 2;
    const TECHNICIAN = 3;
    const ANALISYS = 4;
    const UNIT = 5;
    const MANAGER = 6;
    const DIREKSI = 7;

    /** SCOPE **/

    public function scopeFilters($query)
    {
        return $query->filterBy('name');
    }

    /** RELATIONS **/
    public function menuFlows()
    {
        return $this->hasMany(MenuFlow::class, 'role_id');
    }

    /** SAVE DATA **/
    public function handleStoreOrUpdate($request)
    {
        $this->beginTransaction();
        try {
            $this->name = $request->name;
            $this->save();
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
            if (!$this->canDeleted()) {
                return $this->rollback(__('base.error.related'));
            }
            $this->saveLogNotify();
            $this->delete();

            return $this->commitDeleted();
        } catch (\Exception $e) {
            return $this->rollbackDeleted($e);
        }
    }

    public function handleGrant($request)
    {
        $this->beginTransaction();
        try {
            $this->syncPermissions($request->check ?? []);
            $this->touch();
            $this->saveLogNotify();
            app()->make(\Spatie\Permission\PermissionRegistrar::class)
                ->forgetCachedPermissions();

            return $this->commitSaved(['redirectTo' => route($request->routes . '.index')]);
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
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

            \Excel::import(new RoleImport, \Storage::disk('public')->path($file->file_path));

            $this->saveLogNotify();

            return $this->commitSaved();
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    /** OTHER FUNCTION **/
    public function canDeleted()
    {
        if (in_array($this->id, [1, 2, 3, 4, 5, 6])) return false;
        if ($this->users()->exists()) return false;
        if ($this->menuFlows()->exists()) return false;
        if (Approval::where('role_id', $this->id)->exists()) return false;

        return true;
    }
}
