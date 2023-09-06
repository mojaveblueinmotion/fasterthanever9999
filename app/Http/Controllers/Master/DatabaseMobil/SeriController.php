<?php

namespace App\Http\Controllers\Master\DatabaseMobil;

use Illuminate\Http\Request;
use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Models\Master\DatabaseMobil\Seri;
use App\Http\Requests\Master\DatabaseMobil\SeriRequest;

class SeriController extends Controller
{
    protected $module   = 'master.database-mobil.seri';
    protected $routes   = 'master.database-mobil.seri';
    protected $views    = 'master.database-mobil.seri';
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
                'title' => 'Seri Mobil',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Database Mobil' => route($this->routes . '.index'),
                    'Seri Mobil' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:code|label:Code|className:text-center'),
                        $this->makeColumn('name:model|label:Model|className:text-center'),
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
        $records = Seri::grid()->filters()->dtGet();

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
                    return "<span class='badge badge-info'>" . $record->merk->name . "</span>";
                }
            )
            ->addColumn(
                'code',
                function ($record) {
                    return "<span class='badge badge-danger'>" . $record->code . "</span>";
                }
            )
            ->addColumn(
                'model',
                function ($record) {
                    return "<span class='badge badge-primary'>" . $record->model . "</span>";
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
            ->rawColumns(['action', 'updated_by', 'merk_id', 'code', 'model', 'description'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(SeriRequest $request)
    {
        $record = new Seri;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Seri $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(Seri $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(SeriRequest $request, Seri $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(Seri $record)
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
        $record = new Seri;
        return $record->handleImport($request);
    }
}
