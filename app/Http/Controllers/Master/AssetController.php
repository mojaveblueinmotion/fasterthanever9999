<?php

namespace App\Http\Controllers\Master;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\AssetDetailRequest;
use App\Http\Requests\Master\AssetRequest;
use App\Models\Master\Asset;
use App\Models\Master\AssetDetail;
use App\Support\Base;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    protected $module   = 'master.asset';
    protected $routes   = 'master.asset';
    protected $views    = 'master.asset';
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
                'title' => 'Aset TI',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Aset TI' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:name|label:Nama Aset|className:text-left|sortable:false'),
                        $this->makeColumn('name:type.name|label:Tipe Aset|className:text-center|sortable:false'),
                        $this->makeColumn('name:serial_number|label:Serial Number|className:text-center|sortable:false'),
                        $this->makeColumn('name:merk|label:Merk|className:text-center|sortable:false'),
                        $this->makeColumn('name:regist_date|label:Tgl Registrasi|className:text-center|sortable:false'),
                        $this->makeColumn('name:details_count|label:Jml Komponen|className:text-center|sortable:false'),
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
        $records = Asset::with('type')
            ->withCount('details')
            ->grid()
            ->filters()
            ->when(
                $asset_type_id = $request->asset_type_id,
                function ($q) use ($asset_type_id) {
                    $q->where('asset_type_id', $asset_type_id);
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
                'type.name',
                function ($record) {
                    return Base::makeLabel($record->type->name, 'primary');
                }
            )
            ->editColumn(
                'serial_number',
                function ($record) {
                    return Base::makeLabel($record->serial_number, 'success');
                }
            )
            ->editColumn(
                'merk',
                function ($record) {
                    return Base::makeLabel($record->merk, 'warning');
                }
            )
            ->editColumn(
                'regist_date',
                function ($record) {
                    return Base::makeLabel($record->regist_date->format('d/m/Y'), 'info');
                }
            )
            ->editColumn(
                'details_count',
                function ($record) {
                    return '<span data-short="' . $record->details_count . '" class="label label-inline text-nowrap " style="background-color: #b65808; color: white">' . $record->details_count . '</span>';
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
                        [
                            'type'      => 'detail',
                            'id'        => $record->id,
                            'label'     => 'Komponen',
                            'page'      => true,
                        ],
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
                    'type.name',
                    'serial_number',
                    'merk',
                    'regist_date',
                    'details_count',
                    'action',
                    'updated_by', 'location'
                ]
            )
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(AssetRequest $request)
    {
        $record = new Asset;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Asset $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(Asset $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(AssetRequest $request, Asset $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(Asset $record)
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

        $record = new Asset;
        return $record->handleImport($request);
    }

    public function detailGrid(Request $request, $asset_id)
    {
        $user = auth()->user();
        // dd($asset_id);
        $records = AssetDetail::with(
            ['files']
        )
            ->grid()
            ->filters()
            ->where('asset_id', $asset_id)
            ->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($detail) {
                    return request()->start;
                }
            )
            ->editColumn(
                'name',
                function ($detail) {
                    return Base::makeLabel($detail->name, 'danger');
                }
            )
            ->editColumn(
                'description',
                function ($detail) {
                    $str = "<span class='badge badge-primary'>" . str_word_count(strip_tags($detail->description)) . " Words</span> ";
                    $str .= "<span class='badge badge-info'>" . $detail->files->count() . " Files</span>";
                    return $str;
                }
            )
            ->addColumn(
                'updated_by',
                function ($detail) {
                    return $detail->createdByRaw();
                }
            )
            ->addColumn(
                'action',
                function ($detail) use ($user) {
                    $actions = [
                        [
                            'type'  => 'detail.show',
                            'id'    => $detail->id,
                            'attrs' => 'data-modal-size="modal-lg"',
                        ],
                        [
                            'type'  => 'detail.edit',
                            'id'    => $detail->id,
                            'attrs' => 'data-modal-size="modal-lg"',
                        ],
                    ];
                    if ($detail->canDeleted()) {
                        $actions[] = [
                            'type' => 'detail.delete',
                            'id' => $detail->id,
                            'attrs' => 'data-confirm-text="' . __('Hapus') . ' ' . $detail->name . '?"',
                        ];
                    }
                    return $this->makeButtonDropdown($actions);
                }
            )
            ->rawColumns(
                [
                    'name',
                    'description',
                    'action',
                    'updated_by',
                ]
            )
            ->make(true);
    }
    public function detail($id)
    {
        $record = Asset::with(
            [
                'type',
                'incidents',
                'problems',
                'changes',
            ]
        )->findOrFail($id);
        $this->prepare(
            [
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Aset' => route($this->routes . '.index'),
                    $record->name => route($this->routes . '.detail', $record->id),
                ],
                'tableStruct' => [
                    'url'   => route($this->routes . '.detail.grid', $record->id),
                    'datatable_1' => [
                        $this->makeColumn('name:num'),
                        $this->makeColumn('name:name|label:Komponen Aset|className:text-left|sortable:false'),
                        $this->makeColumn('name:description|label:Keterangan|className:text-center|sortable:false'),
                        $this->makeColumn('name:updated_by'),
                        $this->makeColumn('name:action'),
                    ],
                ],
            ]
        );
        return $this->render(
            $this->views . '.detail.index',
            compact('record')
        );
    }
    public function detailCreate($id)
    {
        $this->prepare(
            [
                'title' => 'Komponen Aset',
            ]
        );
        $record = Asset::findOrFail($id);
        return $this->render(
            $this->views . '.detail.create',
            compact('record')
        );
    }

    public function detailStore(AssetDetailRequest $request, $id)
    {
        $record = Asset::findOrFail($id);
        return $record->handleDetailStoreOrUpdate($request);
    }

    public function detailShow($id)
    {

        $detail = AssetDetail::findOrFail($id);
        $this->prepare(
            [
                'title' => 'Komponen Aset',
            ]
        );
        return $this->render($this->views . '.detail.show', compact('detail'));
    }

    public function detailEdit($id)
    {
        $detail = AssetDetail::findOrFail($id);
        $this->prepare(
            [
                'title' => 'Komponen Aset',
            ]
        );
        return $this->render($this->views . '.detail.edit', compact('detail'));
    }

    public function detailUpdate(AssetDetailRequest $request, $id)
    {
        $detail = AssetDetail::findOrFail($id);
        $record = $detail->asset;
        return $record->handleDetailStoreOrUpdate($request);
    }

    public function detailDestroy($id)
    {
        $detail = AssetDetail::findOrFail($id);
        $record = $detail->asset;
        return $record->handleDetailDestroy($detail);
    }
}
