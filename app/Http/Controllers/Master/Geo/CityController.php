<?php

namespace App\Http\Controllers\Master\Geo;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Geo\CityRequest;
use App\Models\Master\Geo\City;
use App\Models\Master\Geo\Province;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected $module   = 'master.geo.city';
    protected $routes   = 'master.geo.city';
    protected $views    = 'master.geo.city';
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
                'title' => 'Kota/Kabupaten',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Geografis' => route($this->routes . '.index'),
                    'Kota/Kabupaten' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:code|label:Kode|className:text-center|sortable:false'),
                        $this->makeColumn('name:name|label:Nama|className:text-left|sortable:false'),
                        $this->makeColumn('name:province.name|label:Provinsi|className:text-left|sortable:false'),
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
        $records = City::with('province')
            ->grid()
            ->filters()
            ->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($record) {
                    return request()->start;
                }
            )
            ->addColumn(
                'code',
                function ($record) {
                    return "<span class='badge badge-danger'>" . $record->code . "</span>";
                }
            )
            ->addColumn(
                'name',
                function ($record) {
                    return "<span class='badge' style='background-color:#0000ff; color:white;'>" . $record->name ?? '' . "</span>";
                }
            )
            ->addColumn(
                'province.name',
                function ($record) {
                    return "<span class='badge badge-success'>" . $record->province->name ?? null . "</span>";
                }
            )
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
                        // $actions[] = [
                        //     'type' => 'delete',
                        //     'id' => $record->id,
                        //     'attrs' => 'data-confirm-text="' . __('Hapus') . ' ' . $record->name . '?"',
                        // ];
                    }
                    return $this->makeButtonDropdown($actions);
                }
            )
            ->rawColumns(['action', 'updated_by', 'location', 'code', 'name', 'province.name'])
            ->make(true);
    }

    public function create()
    {
        $PROVINCES = Province::orderBy('name', 'ASC')->get();
        return $this->render(
            $this->views . '.create',
            compact('PROVINCES')
        );
    }

    public function store(CityRequest $request)
    {
        $record = new City;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(City $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(City $record)
    {
        $PROVINCES = Province::orderBy('name', 'ASC')->get();
        return $this->render(
            $this->views . '.edit',
            compact('record', 'PROVINCES')
        );
    }

    public function update(CityRequest $request, City $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(City $record)
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
        $request->validate([
            'uploads.uploaded' => 'required',
            'uploads.temp_files_ids.*' => 'required',
        ], [], [
            'uploads.uploaded' => 'File',
            'uploads.temp_files_ids.*' => 'File',
        ]);

        $record = new Example;
        return $record->handleImport($request);
    }
}
