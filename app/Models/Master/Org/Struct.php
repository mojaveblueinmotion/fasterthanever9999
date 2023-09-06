<?php

namespace App\Models\Master\Org;

use App\Imports\Setting\StructImport;
use App\Models\Master\Geo\City;
use App\Models\Setting\Globals\TempFiles;
use App\Models\Model;

class Struct extends Model
{
    protected $table = 'sys_structs';

    protected $fillable = [
        'parent_id',
        'level', //root, bod, unit, division, branch, bagian, subbagian
        'type', //1:presdir, 2:direktur, 3: division, 4:it division
        'code',
        'name',
        'email',
        'website',
        'phone',
        'address',
        'city_id',
    ];

    /** MUTATOR **/

    /** ACCESSOR **/
    public function getShowLevelAttribute()
    {
        switch ($this->level) {
            case 'boc':
                return __('Pengawas');
                break;
            case 'bod':
                return __('Direksi');
                break;
            case 'division':
                return __('Divisi');
                break;
            case 'department':
                return __('Departemen');
                break;
            case 'unit-bisnis':
                return __('Unit Bisnis');
                break;

            default:
                return ucfirst($this->level);
                break;
        }
    }

    /** RELATION **/
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function parent()
    {
        return $this->belongsTo(Struct::class, 'parent_id');
    }

    public function childs()
    {
        return $this->hasMany(Struct::class, 'parent_id')->orderBy('level');
    }

    public function positions()
    {
        return $this->hasMany(Position::class, 'location_id');
    }

    /** SCOPE **/
    public function scopeFilters($query)
    {
        return $query->filterBy(['code', 'name', 'parent_id'])->defaultOrderBy();
    }

    public function scopeRoot($query)
    {
        return $query->where('level', 'root');
    }

    public function scopeBoc($query)
    {
        return $query->where('level', 'boc');
    }

    public function scopeBod($query)
    {
        return $query->where('level', 'bod');
    }

    public function scopeDivision($query)
    {
        return $query->where('level', 'division');
    }

    public function scopeDivisionIa($query)
    {
        return $query->division()->where('type', 'ia');
    }

    public function scopeDivisionIt($query)
    {
        return $query->division()->where('type', 'it');
    }

    public function scopeDepartment($query)
    {
        return $query->where('level', 'department');
    }

    public function scopeUnitBisnis($query)
    {
        return $query->where('level', 'unit-bisnis');
    }

    public function scopeInAudit($query)
    {
        return $query->where(
            function ($q) {
                $q->where(
                    function ($qq) {
                        $qq->divisionIa();
                    }
                )->orWhere(
                    function ($qq) {
                        $qq->departmentIa();
                    }
                );
            }
        );
    }

    /** SAVE DATA **/
    public function handleStoreOrUpdate($request, $level)
    {
        $this->beginTransaction();
        try {
            if (in_array($level, ['boc', 'bod', 'division', 'department', 'unit-bisnis', 'other'])) {
                if ($root = static::root()->first()) {
                    $this->phone = $root->phone;
                    $this->address = $root->address;
                }
            }
            $this->fill($request->only($this->fillable));
            $this->level = $level;
            $this->code = $this->code ?: $this->getNewCode($level);
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
            $this->saveLogNotify();
            $this->delete();

            return $this->commitDeleted();
        } catch (\Exception $e) {
            return $this->rollbackDeleted($e);
        }
    }

    public function handleImport($request, $level)
    {
        $this->beginTransaction();
        try {
            $file = TempFiles::find($request->uploads['temp_files_ids'][0]);
            if (!$file || !\Storage::disk('public')->exists($file->file_path)) {
                $this->rollback('File tidak tersedia!');
            }

            $filePath = \Storage::disk('public')->path($file->file_path);
            \Excel::import(new StructImport($level), $filePath);

            $this->saveLogNotify();

            return $this->commitSaved();
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    /** OTHER FUNCTIONS **/
    public function canDeleted()
    {
        if (in_array($this->level, ['root'])) return false;
        if ($this->childs()->exists()) return false;
        if ($this->positions()->exists()) return false;

        return true;
    }

    public function getNewCode($level)
    {
        switch ($level) {
            case 'root':
                $max = static::root()->max('code');
                return $max ? $max + 1 : 1001;
            case 'boc':
                $max = static::boc()->max('code');
                return $max ? $max + 1 : 1101;
            case 'bod':
                $max = static::bod()->max('code');
                return $max ? $max + 1 : 2001;
            case 'division':
                $max = static::division()->max('code');
                return $max ? $max + 1 : 3001;
            case 'department':
                $max = static::department()->max('code');
                return $max ? $max + 1 : 4001;
            case 'unit-bisnis':
                $max = static::unitBisnis()->max('code');
                return $max ? $max + 1 : 5001;
        }
        return null;
    }

    public function getIdsWithChild()
    {
        $ids = [$this->id];
        foreach ($this->child as $child) {
            $ids = array_merge($ids, $child->getIdsWithChild());
        }
        return $ids;
    }
}
