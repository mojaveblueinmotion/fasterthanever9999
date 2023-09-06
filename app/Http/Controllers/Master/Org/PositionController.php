<?php

namespace App\Http\Controllers\Master\Org;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Org\PositionRequest;
use App\Models\Master\Org\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    protected $module   = 'master.org.position';
    protected $routes   = 'master.org.position';
    protected $views    = 'master.org.position';
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
                'title' => 'Jabatan',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Stuktur Organisasi' => route($this->routes . '.index'),
                    'Jabatan' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:location|label:Unit Kerja|className:text-center|sortable:false'),
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
        $records = Position::with('location')
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
                'name',
                function ($record) {
                    return "<span class='badge badge-danger'>" . $record->name . "</span>";
                }
            )
            ->addColumn(
                'location',
                function ($record) {
                    return "<span class='badge' style='background-color:#0000ff; color:white;'>" . $record->location->name . "</span>";
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
            ->rawColumns(['action', 'updated_by', 'location', 'name'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(PositionRequest $request)
    {
        $record = new Position;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Position $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(Position $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(PositionRequest $request, Position $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(Position $record)
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
        $levels = [
            'boc' => __('Pengawas'),
            'bod' => __('Direksi'),
            'division' => __('Divisi'),
            'department' => __('Departemen'),
            'branch' => __('Cabang'),
            'subbranch' => __('Cabang Pembantu'),
        ];
        $data['levels'] = $levels;
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

        $record = new Position;
        return $record->handleImport($request);
    }
}
