<?php

namespace App\Http\Controllers\Master\Org;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Org\DepartmentRequest;
use App\Models\Master\Org\Struct;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $module = 'master.org.department';
    protected $routes = 'master.org.department';
    protected $views = 'master.org.department';
    protected $perms = 'master';

    public function __construct()
    {
        $this->prepare(
            [
                'module' => $this->module,
                'routes' => $this->routes,
                'views' => $this->views,
                'perms' => $this->perms,
                'permission' => $this->perms . '.view',
                'title' => 'Departemen',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Stuktur Organisasi' => route($this->routes . '.index'),
                    'Departemen' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:name|label:Nama|className:text-left|sortable:false'),
                        $this->makeColumn('name:parent|label:Parent|className:text-center|sortable:false'),
                        $this->makeColumn('name:updated_by|sortable:false'),
                        $this->makeColumn('name:action|sortable:false'),
                    ],
                ],
            ]
        );
        return $this->render($this->views . '.index');
    }

    public function grid()
    {
        $user = auth()->user();
        $records = Struct::with('parent')
            ->department()
            ->grid()
            ->filters()->dtGet();

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
                'parent',
                function ($record) {
                    return "<span class='badge' style='background-color:#0000ff; color:white;'>" . $record->parent->name ?? null . "</span>";
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
            ->rawColumns(['action', 'updated_by', 'name', 'parent'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(DepartmentRequest $request)
    {
        $record = new Struct;
        return $record->handleStoreOrUpdate($request, 'department');
    }

    public function show(Struct $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(Struct $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(DepartmentRequest $request, Struct $record)
    {
        return $record->handleStoreOrUpdate($request, 'department');
    }

    public function destroy(Struct $record)
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
        $request->validate(
            [
                'uploads.uploaded' => 'required',
                'uploads.temp_files_ids.*' => 'required',
            ],
            [],
            [
                'uploads.uploaded' => 'File',
                'uploads.temp_files_ids.*' => 'File',
            ]
        );

        $record = new Struct;
        return $record->handleImport($request, 'department');
    }
}
