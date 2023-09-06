<?php

namespace App\Http\Controllers\Master\AsuransiMobil;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\AsuransiMobil\LuasPertanggunganRequest;
use App\Models\Master\AsuransiMobil\LuasPertanggungan;
use Illuminate\Http\Request;

class LuasPertanggunganController extends Controller
{
    protected $module   = 'master.asuransi-mobil.luas-pertanggungan';
    protected $routes   = 'master.asuransi-mobil.luas-pertanggungan';
    protected $views    = 'master.asuransi-mobil.luas-pertanggungan';
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
                'title' => 'Luas Pertanggungan',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Asuransi Mobil' => route($this->routes . '.index'),
                    'Luas Pertanggungan' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:name|label:Luas Pertanggungan|className:text-center'),
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
        $records = LuasPertanggungan::grid()->filters()->dtGet();

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
            ->rawColumns(['action', 'updated_by', 'name', 'description'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(LuasPertanggunganRequest $request)
    {
        $record = new LuasPertanggungan;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(LuasPertanggungan $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(LuasPertanggungan $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(LuasPertanggunganRequest $request, LuasPertanggungan $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(LuasPertanggungan $record)
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
        $record = new LuasPertanggungan;
        return $record->handleImport($request);
    }
}
