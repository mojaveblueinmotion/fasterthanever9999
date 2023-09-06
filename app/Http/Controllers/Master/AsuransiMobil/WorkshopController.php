<?php

namespace App\Http\Controllers\Master\AsuransiMobil;

use Illuminate\Http\Request;
use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Models\Master\AsuransiMobil\Workshop;
use App\Http\Requests\Master\AsuransiMobil\WorkshopRequest;

class WorkshopController extends Controller
{
    protected $module   = 'master.asuransi-mobil-mobil.workshop';
    protected $routes   = 'master.asuransi-mobil.workshop';
    protected $views    = 'master.asuransi-mobil.workshop';
    protected $perms    = 'master';

    public function __construct()
    {
        $this->prepare(
            [
                'module' => $this->module,
                'routes' => $this->routes,
                'views' => $this->views,
                'perms' => $this->perms,
                'permission' => $this->perms . '.view',
                'title' => 'Workshop',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Asuransi Mobil' => route($this->routes . '.index'),
                    'Workshop' => route($this->routes . '.index'),
                ]
            ]
        );
    }

    public function index()
    {
        $this->prepare(
            [
                'tableStruct' => [
                    'datatable_1' => [
                        $this->makeColumn('name:num'),
                        $this->makeColumn('name:name|label:Nama Workshop|className:text-center'),
                        $this->makeColumn('name:province_id|label:Kota|className:text-center'),
                        $this->makeColumn('name:link_maps|label:Link Maps|className:text-center'),
                        $this->makeColumn('name:description|label:Deskripsi|className:text-center'),
                        $this->makeColumn('name:updated_by'),
                        $this->makeColumn('name:action'),
                    ],
                ],
            ]
        );
        return $this->render($this->views . '.index');
    }

    public function grid()
    {
        $user = auth()->user();
        $records = Workshop::grid()->filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($record) {
                    return request()->start;
                }
            )
            ->addColumn(
                'name',
                function ($record) {
                    return "<span class='badge badge-danger'>" . $record->name . "</span>";
                }
            )
            ->addColumn(
                'province_id',
                function ($record) {
                    return "<span class='badge badge-info'>" . $record->province->name . "</span><br><span class='badge badge-warning'>" . $record->city->name . "</span>";
                }
            )
            ->addColumn(
                'link_maps',
                function ($record) {
                    return "<span class='badge badge-info'>" . $record->link_maps . "</span>";
                }
            )
            ->addColumn('description', function ($record) {
                return  "<span class='badge badge-primary'>" . str_word_count($record->description) . " Words</span>";
            })
            ->addColumn(
                'updated_by',
                function ($record) {
                    return $record->createdByRaw();
                }
            )
            ->addColumn(
                'action',
                function ($record) use ($user) {
                    $actions = [
                        'type:show|id:' . $record->id,
                        'type:edit|id:' . $record->id,
                    ];
                    if ($record->canDeleted()) {
                        $actions[] = [
                            'type' => 'delete',
                            'id' => $record->id,
                            'attrs' => 'data-confirm-text="' . __('Hapus') . ' ' . $record->name . '?"',
                        ];
                    }
                    return $this->makeButtonDropdown($actions);
                }
            )
            ->rawColumns(['action', 'updated_by', 'name', 'description', 'province_id', 'link_maps'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(WorkshopRequest $request)
    {
        $record = new Workshop;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Workshop $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(Workshop $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(WorkshopRequest $request, Workshop $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(Workshop $record)
    {
        return $record->handleDestroy();
    }

    public function import()
    {
        if (request()->get('download') == 'template') {
            return $this->template();
        }
        return $this->render($this->views . '.import');
    }

    public function template()
    {
        $fileName = date('Y-m-d') . ' Template Import Data ' . $this->prepared('title') . '.xlsx';
        $view = $this->views . '.template';
        $data = [];
        return \Excel::download(new GenerateExport($view, $data), $fileName);
    }

    public function importSave(Request $request)
    {
        $record = new Workshop;
        return $record->handleImport($request);
    }
}
