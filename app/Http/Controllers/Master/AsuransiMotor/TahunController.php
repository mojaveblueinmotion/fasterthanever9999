<?php

namespace App\Http\Controllers\Master\AsuransiMotor;

use Illuminate\Http\Request;
use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Models\Master\AsuransiMotor\Tahun;
use App\Http\Requests\Master\AsuransiMotor\TahunRequest;

class TahunController extends Controller
{
    protected $module   = 'master.asuransi-motor.tahun';
    protected $routes   = 'master.asuransi-motor.tahun';
    protected $views    = 'master.asuransi-motor.tahun';
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
                'title' => 'Tahun Motor',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Asuransi Motor' => route($this->routes . '.index'),
                    'Tahun Motor' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:merk_id|label:Merk|className:text-center'),
                        $this->makeColumn('name:seri_id|label:Seri|className:text-center'),
                        $this->makeColumn('name:tahun|label:Tahun|className:text-center'),
                        $this->makeColumn('name:harga|label:Harga|className:text-center'),
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
        $records = Tahun::grid()->filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($record) {
                    return request()->start;
                }
            )
            ->addColumn(
                'merk_id',
                function ($record) {
                    return "<span class='badge badge-info'>" . $record->seri->merk->name . "</span>";
                }
            )
            ->addColumn(
                'seri_id',
                function ($record) {
                    return "<span class='badge badge-danger'>" . $record->seri->code . "</span><br>
                    <span class='badge badge-primary'>" . $record->seri->model . "</span>";
                }
            )
            ->addColumn(
                'tahun',
                function ($record) {
                    return "<span class='badge badge-danger'>" . $record->tahun . "</span>";
                }
            )
            ->addColumn(
                'harga',
                function ($record) {
                    return "<span class='badge badge-primary'>Rp. " . $record->harga . "</span>";
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
                        $actions[] = [
                            'type' => 'delete',
                            'id' => $record->id,
                            'attrs' => 'data-confirm-text="' . __('Hapus') . ' ' . $record->name . '?"',
                        ];
                    }
                    return $this->makeButtonDropdown($actions);
                }
            )
            ->rawColumns(['action', 'updated_by', 'merk_id', 'tahun', 'harga', 'seri_id', 'description'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(TahunRequest $request)
    {
        $record = new Tahun;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Tahun $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(Tahun $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(TahunRequest $request, Tahun $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(Tahun $record)
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
        $record = new Tahun;
        return $record->handleImport($request);
    }
}
