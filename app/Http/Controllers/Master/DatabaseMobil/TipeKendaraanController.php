<?php

namespace App\Http\Controllers\Master\DatabaseMobil;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\DatabaseMobil\TipeKendaraanRequest;
use App\Models\Master\DatabaseMobil\TipeKendaraan;
use Illuminate\Http\Request;


class TipeKendaraanController extends Controller
{
    protected $module   = 'master.database-mobil.tipe-kendaraan';
    protected $routes   = 'master.database-mobil.tipe-kendaraan';
    protected $views    = 'master.database-mobil.tipe-kendaraan';
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
                'title' => 'Tipe Kendaraan',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Asuransi Mobil' => route($this->routes . '.index'),
                    'Tipe Kendaraan' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:type|label:Tipe Kendaraan|className:text-center'),
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
        $records = TipeKendaraan::grid()->filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($record) {
                    return request()->start;
                }
            )
            ->addColumn(
                'type',
                function ($record) {
                    return "<span class='badge badge-danger'>" . $record->type . "</span>";
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
                            'attrs' => 'data-confirm-text="' . __('Hapus') . ' ' . $record->type . '?"',
                        ];
                    }
                    return $this->makeButtonDropdown($actions);
                }
            )
            ->rawColumns(['action', 'updated_by', 'type', 'description'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(TipeKendaraanRequest $request)
    {
        $record = new TipeKendaraan;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(TipeKendaraan $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(TipeKendaraan $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(TipeKendaraanRequest $request, TipeKendaraan $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(TipeKendaraan $record)
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
        $record = new TipeKendaraan;
        return $record->handleImport($request);
    }
}
