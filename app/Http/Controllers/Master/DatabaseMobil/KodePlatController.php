<?php

namespace App\Http\Controllers\Master\DatabaseMobil;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Master\DatabaseMobil\KodePlat;
use App\Http\Requests\Master\DatabaseMobil\KodePlatRequest;

class KodePlatController extends Controller
{
    protected $module   = 'master.database-mobil.kode-plat';
    protected $routes   = 'master.database-mobil.kode-plat';
    protected $views    = 'master.database-mobil.kode-plat';
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
                'title' => 'Kode Plat',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Database Mobil' => route($this->routes . '.index'),
                    'Kode Plat' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:name|label:Kode|className:text-center'),
                        $this->makeColumn('name:daerah|label:Daerah|className:text-center'),
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
        $records = KodePlat::grid()->filters()->dtGet();

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
            ->addColumn('daerah', function ($record) {
                return  "<span class='badge badge-primary'>" . $record->daerah . "</span>";
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
            ->rawColumns(['action', 'updated_by', 'name', 'daerah'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(KodePlatRequest $request)
    {
        $record = new KodePlat;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(KodePlat $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(KodePlat $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(KodePlatRequest $request, KodePlat $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(KodePlat $record)
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
        $record = new KodePlat;
        return $record->handleImport($request);
    }
}
