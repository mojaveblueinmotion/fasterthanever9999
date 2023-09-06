<?php

namespace App\Models\Master;

use App\Imports\Master\ExampleImport;
use App\Models\Change\Change;
use App\Models\Change\ChangeAssetDetail;
use App\Models\Incident\Incident;
use App\Models\Incident\IncidentAssetDetail;
use App\Models\Knowledge\Knowledge;
use App\Models\Model;
use App\Models\Problem\Problem;
use App\Models\Problem\ProblemAssetDetail;
use App\Models\Setting\Globals\TempFiles;
use App\Models\Traits\HasFiles;
use Carbon\Carbon;

class AssetDetail extends Model
{
    use HasFiles;
    protected $table = 'ref_asset_detail';

    protected $fillable = [
        'id',
        'asset_id',
        'name',
        'description',
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
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function changes()
    {
        return $this->belongsToMany(
            Change::class,
            ChangeAssetDetail::class,
            'asset_detail_id',
            'change_id',
        );
    }
    public function incidents()
    {
        return $this->belongsToMany(
            Incident::class,
            IncidentAssetDetail::class,
            'asset_detail_id',
            'incident_id',
        );
    }
    // public function knowledges()
    // {
    //     return $this->belongsToMany(
    //         Knowledge::class,
    //         KnowledgeAssetDetail::class,
    //         'asset_detail_id',
    //         'knowledge_id',
    //     );
    // }
    public function problems()
    {
        return $this->belongsToMany(
            Problem::class,
            ProblemAssetDetail::class,
            'asset_detail_id',
            'problem_id',
        );
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
        if ($this->incidents()->exists()) return false;
        // if ($this->knowledges()->exists()) return false;
        if ($this->problems()->exists()) return false;

        return true;
    }
}
