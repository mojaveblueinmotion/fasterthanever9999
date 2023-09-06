<?php

namespace App\Http\Controllers\Setting\User;

use App\Support\Base;
use App\Models\Auth\User;
use Illuminate\Http\Request;
use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\User\UserRequest;

class UserController extends Controller
{
    protected $module = 'setting.user';
    protected $routes = 'setting.user';
    protected $views = 'setting.user';
    protected $perms = 'setting';

    public function __construct()
    {
        $this->prepare(
            [
                'module' => $this->module,
                'routes' => $this->routes,
                'views' => $this->views,
                'perms' => $this->perms,
                'permission' => $this->perms . '.view',
                'title' => 'Manajemen User',
                'breadcrumb' => [
                    'Pengaturan Umum' => route($this->routes . '.index'),
                    'Manajemen User' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:name|label:Nama|className:text-center|sortable:false'),
                        $this->makeColumn('name:username|label:Username|className:text-center|sortable:false'),
                        $this->makeColumn('name:struct|label:Unit Kerja|className:text-center|sortable:false'),
                        // $this->makeColumn('name:nik|label:NIK|className:text-center'),
                        $this->makeColumn('name:position|label:Jabatan|className:text-center|sortable:false'),
                        $this->makeColumn('name:role|label:Hak Akses|className:text-center width-10px|sortable:false'),
                        $this->makeColumn('name:status|className:width-10px|sortable:false'),
                        $this->makeColumn('name:updated_by|className:width-10px|sortable:false'),
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
        $records = User::with(
            [
                'position.location',
                'roles',
            ]
        )
            ->grid()
            ->filters()
            ->dtGet()
            ->orderBy('updated_at', 'DESC');

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
                    return '<span data-short="Active" class="label label-danger label-inline text-nowrap " style="">' . $record->name . '</span>';
                }
            )
            ->addColumn(
                'username',
                function ($record) {
                    return '<span data-short="Active" class="label label-info label-inline text-nowrap " style="">' . $record->username . '</span>';
                }
            )
            ->addColumn(
                'struct',
                function ($record) {
                    return '<span data-short="Active" class="label label-warning label-inline text-nowrap " style="">' . ($record->position->location->name ?? '-') . '</span>';
                }
            )
            ->addColumn(
                'position',
                function ($record) {
                    if (isset($record->position)) {
                        return '<span data-short="Active" class="label label-inline text-white text-nowrap " style="background:purple">' . $record->position->name ?? '-' . '</span>';
                    }
                    return '<span data-short="Active" class="label label-inline text-white text-nowrap " style="background:purple">' . '-' . '</span>';
                }
            )
            ->addColumn(
                'role',
                function ($record) {
                    if ($record->roles()->exists()) {
                        $x = '';
                        foreach ($record->roles as $role) {
                            $x .= '<span data-short="Active" class="label label-danger label-inline text-nowrap " style="">' . $role->name . '</span>';
                            $x .= '<br>';
                        }
                        return $x;
                    }
                    return Base::makeLabel('-', 'danger');
                }
            )
            ->editColumn(
                'status',
                function ($record) {
                    return $record->labelStatus();
                }
            )
            ->editColumn(
                'updated_by',
                function ($record) {
                    return $record->createdByRaw();
                }
            )
            ->addColumn(
                'action',
                function ($record) use ($user) {
                    $actions = [];
                    $actions[] = [
                        'type' => 'show',
                        'id' => $record->id
                    ];
                    $actions[] = [
                        'type' => 'edit',
                        'id' => $record->id,
                    ];

                    // if ($user->id == 1) {
                    //     $actions[] = [
                    //         'label' => 'Reset Password',
                    //         'icon' => 'fa fa-retweet text-warning',
                    //         'class' => 'base-form--postByUrl',
                    //         'attrs' => 'data-swal-text="Reset password akan mengubah password menjadi: qwerty123456"',
                    //         'id' => $record->id,
                    //         'url' => route($this->routes . '.reset-password', $record->id)
                    //     ];
                    // }

                    if ($record->position_id != null) {
                        if ($record->canDeleted()) {
                            $actions[] = [
                                'type' => 'delete',
                                'id' => $record->id,
                                'attrs' => 'data-confirm-text="' . __('Hapus') . ' User ' . $record->name . '?"',
                            ];
                        }
                    }
                    return $this->makeButtonDropdown($actions);
                }
            )
            ->rawColumns(
                [
                    'name',
                    'username',
                    'struct',
                    'position',
                    'role',
                    'status',
                    'updated_by',
                    'action',
                ]
            )
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(UserRequest $request)
    {
        $record = new User;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(User $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(User $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(UserRequest $request, User $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(User $record)
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

        $record = new User;
        return $record->handleImport($request);
    }
}
