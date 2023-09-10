<?php

namespace App\Models\AsuransiMotor;

use App\Models\Model;
use Illuminate\Support\Carbon;
use App\Models\AsuransiMotor\PolisMotor;
use App\Models\Master\Geo\City;
use App\Models\Master\Geo\District;
use App\Models\Master\Geo\Province;
use App\Models\Master\Geo\Village;

class PolisMotorClient extends Model
{
    protected $table = 'trans_polis_motor_client';

    protected $fillable = [
        'polis_id',
        'nama',
        'phone',
        'email',
        'province_id',
        'city_id',
        'district_id',
        'village',
        'alamat',
        'warna',
        'keterangan',
        'no_chasis',
        'no_mesin',
    ];

    /*******************************
     ** MUTATOR
     *******************************/

    /*******************************
     ** ACCESSOR
     *******************************/

    /*******************************
     ** RELATION
     *******************************/
    public function polis()
    {
        return $this->belongsTo(PolisMotor::class, 'polis_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    /*******************************
     ** SCOPE
     *******************************/
    
    public function scopeGrid($query)
    {
        return $query->latest();
    }

    public function scopeFilters($query)
    {
        return $query->filterBy(['nama']);
    }

    /*******************************
     ** SAVING
     *******************************/

    public function handleDetailPolisStoreOrUpdate($request)
    {
        $this->beginTransaction();
        try {
            $this->fill($request->all());
            $this->save();
            $this->saveLogNotify();

            $redirect = route(request()->get('routes') . '.detail', $this->polis->id);
            return $this->commitSaved();
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleDetailPolisDestroy()
    {
        $this->beginTransaction();
        try {
            $this->saveLogNotify();
            $this->delete();

            return $this->commitDeleted();
        } catch (\Exception $e) {
            return $this->rollbackDeleted($e);
        }
    }

    public function saveLogNotify()
    {
        $data = $this->nama;
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

    public function checkAction($action, $perms, $summary = null)
    {
        $user = auth()->user();

        switch ($action) {
            case 'create':
                return $user->checkPerms($perms . '.view');
                break;

            case 'show':
            case 'history':
                return $user->checkPerms($perms . '.view');
                break;

            case 'edit':
                $checkStatus = in_array($this->status, ['new', 'draft', 'rejected']);
                return $checkStatus && $user->checkPerms($perms . '.edit');
                break;

            case 'delete':
                $checkStatus = in_array($this->status, ['new', 'draft', 'rejected']);
                return $checkStatus && $user->checkPerms($perms . '.delete');
                break;

            case 'approval':
                if ($this->checkApproval(request()->get('module'))) {
                    $checkStatus = in_array($this->status, ['waiting.approval']);
                    return $checkStatus && $user->checkPerms($perms . '.approve');
                }
                break;

            case 'tracking':
                $checkStatus = in_array($this->status, ['waiting.approval', 'completed']);
                return $checkStatus && $user->checkPerms($perms . '.view');
                break;

            case 'print':
                $checkStatus = in_array($this->status, ['waiting.approval', 'completed']);
                return $checkStatus && $user->checkPerms($perms . '.view');
                break;

            default:
                return false;
                break;
        }
    }

    public function canDeleted()
    {
        // if($this->moduleRelations()->exists()) return false;
        return true;
    }

    public function detailCreationDate()
    {
        $date = ($this->reg_updated_at ?: $this->updated_at) ?? $this->created_at;
        return Carbon::parse($date)->translatedFormat('d M Y, H:i');
    }
    public function detailCreatorName()
    {
        if ($this->update_by) {
            return $this->update_by->name;
        }
        return isset($this->update_by->name) ? $this->update_by->name : $this->creatorName();
    }
}
