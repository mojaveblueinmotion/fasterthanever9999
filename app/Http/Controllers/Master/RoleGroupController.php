<?php

namespace App\Http\Controllers\Master;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\RoleGroupRequest;
use App\Models\Master\RoleGroup;
use App\Support\Base;
use Illuminate\Http\Request;

class RoleGroupController extends Controller
{
    protected $module   = 'master.role-group';
    protected $routes   = 'master.role-group';
    protected $views    = 'master.role-group';
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
                'title' => 'Grup',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Grup' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:name|label:Nama Grup|className:text-left|sortable:false'),
                        $this->makeColumn('name:role.name|label:Role|className:text-center|sortable:false'),
                        $this->makeColumn('name:types|label:Tipe Aset|className:text-center|sortable:false'),
                        $this->makeColumn('name:members|label:Anggota|className:text-left|sortable:false'),
                        $this->makeColumn('name:updated_by'),
                        $this->makeColumn('name:action'),
                    ],
                ],
            ]
        );
        return $this->render($this->views . '.index');
    }

    public function grid(Request $request)
    {
        $user = auth()->user();
        $records = RoleGroup::with('members', 'role', 'types')
            ->grid()
            ->filters()
            ->when(
                $role_id = $request->role_id,
                function ($q) use ($role_id) {
                    $q->where('role_id', $role_id);
                }
            )
            ->when(
                $asset_type_id = $request->asset_type_id,
                function ($q) use ($asset_type_id) {
                    $q->whereHas(
                        'types',
                        function ($q) use ($asset_type_id) {
                            $q->where('asset_type_id', $asset_type_id);
                        }
                    );
                }
            )
            ->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($record) {
                    return request()->start;
                }
            )
            ->editColumn(
                'name',
                function ($record) {
                    return Base::makeLabel($record->name, 'danger');
                }
            )
            ->editColumn(
                'role.name',
                function ($record) {
                    return Base::makeLabel($record->role->name, 'warning');
                }
            )
            ->editColumn(
                'types',
                function ($record) {
                    $str = '';
                    foreach ($record->types as $type) {
                        $str .= "<span class='badge badge-info'>".$type->name . "</span><br>";
                    }
                    return $str;
                }
            )
            ->editColumn(
                'members',
                function ($record) {
                    return $record->getMembersRaw();
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
            ->rawColumns(
                [
                    'name',
                    'role.name',
                    'types',
                    'types',
                    'members',
                    'action', 'updated_by', 'location'
                ]
            )
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(RoleGroupRequest $request)
    {
        $record = new RoleGroup;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(RoleGroup $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(RoleGroup $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(RoleGroupRequest $request, RoleGroup $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(RoleGroup $record)
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
