<?php

namespace App\Models\Master\Org;

use App\Imports\Setiing\PositionImport;
use App\Models\Auth\User;
use App\Models\Setting\Globals\TempFiles;
use App\Models\Model;

class Position extends Model
{
    protected $table = 'sys_positions';

    protected $fillable = [
        'location_id',
        'name',
        'code',
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
    public function location()
    {
        return $this->belongsTo(Struct::class, 'location_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'position_id');
    }

    /*******************************
     ** SCOPE
     *******************************/

    public function scopeFilters($query)
    {
        return $query->filterBy(['location_id', 'name']);
    }

    /*******************************
     ** SAVING
     *******************************/
    public function handleStoreOrUpdate($request)
    {
        $this->beginTransaction();
        try {
            $this->fill($request->only($this->fillable));
            $this->code = $this->code ?: $this->getNewCode();
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
                throw new \Exception('#' . __('base.error.related'));
            }
            $this->saveLogNotify();
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
            \Excel::import(new PositionImport(), $filePath);

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
        if ($this->users()->exists()) return false;

        return true;
    }
    public function getNewCode()
    {
        $max = static::max('code');
        return $max ? $max + 1 : 1001;
    }

    public function inSameStruct($struct_id)
    {
        if ($this->location_id == $struct_id) {
            return true;
        }
        if ($this->location->level == 'department' && $this->location->parent_id == $struct_id) {
            return true;
        }
        return false;
    }
}
