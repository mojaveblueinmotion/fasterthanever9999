<?php

namespace App\Models\Master;

use App\Imports\Master\ExampleImport;
use App\Models\Change\Change;
use App\Models\Incident\Incident;
use App\Models\Model;
use App\Models\Problem\Problem;
use App\Models\Setting\Globals\TempFiles;
use Carbon\Carbon;

class Asset extends Model
{
    protected $table = 'ref_asset';

    protected $fillable = [
        'name',
        'asset_type_id',
        'serial_number',
        'merk',
        'regist_date',
        'incident_count',
        'problem_count',
        'change_count',
    ];

    protected $dates = [
        'regist_date',
    ];

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
    public function changes()
    {
        return $this->hasMany(Change::class, 'asset_id');
    }
    public function details()
    {
        return $this->hasMany(AssetDetail::class, 'asset_id');
    }
    public function incidents()
    {
        return $this->hasMany(Incident::class, 'asset_id');
    }
    public function problems()
    {
        return $this->hasMany(Problem::class, 'asset_id');
    }
    public function type()
    {
        return $this->belongsTo(AssetType::class, 'asset_type_id');
    }

    /*******************************
     ** SCOPE
     *******************************/

    public function scopeFilters($query)
    {
        return $query->filterBy(['name']);
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
            $this->saveLogNotify();

            return $this->commitSaved();
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleDetailStoreOrUpdate($request)
    {
        $this->beginTransaction();
        try {
            $detail = $this->details()->firstOrNew(['id' => $request->id]);
            $detail->fill($request->only($detail->getFillable()));
            $this->details()->save($detail);
            $detail->saveFilesByTemp($request->attachments, $request->module . '.detail', 'attachments');
            $this->touch();

            $this->saveLogNotify();

            $redirect = route(request()->get('routes') . '.detail', $this->id);
            return $this->commitSaved(['redirect' => $redirect]);
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

    public function handleDetailDestroy($detail)
    {
        $this->beginTransaction();
        try {
            $detail->delete();
            $this->saveLogNotify();

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
        if ($this->changes()->exists()) return false;
        if ($this->details()->exists()) return false;
        if ($this->incidents()->exists()) return false;
        if ($this->problems()->exists()) return false;

        return true;
    }
}
