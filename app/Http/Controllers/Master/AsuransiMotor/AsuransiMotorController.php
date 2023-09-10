<?php

namespace App\Http\Controllers\Master\AsuransiMotor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\AsuransiMotor\AsuransiMotorRequest;
use App\Models\Master\AsuransiMotor\AsuransiMotor;
use Illuminate\Http\Request;

class AsuransiMotorController extends Controller
{
    protected $module   = 'master.asuransi-motor.asuransi-motor';
    protected $routes   = 'master.asuransi-motor.asuransi-motor';
    protected $views    = 'master.asuransi-motor.asuransi-motor';
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
                'title' => 'Asuransi Motor',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Asuransi Motor' => route($this->routes . '.index'),
                    'Asuransi Motor' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:perusahaan_asuransi_id|label:Perusahaan Asuransi|className:text-center'),
                        $this->makeColumn('name:name|label:Nama Asuransi|className:text-center'),
                        $this->makeColumn('name:pembayaran_persentasi|label:Pembayaran|className:text-center'),
                        $this->makeColumn('name:call_center|label:Call Center|className:text-center'),
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
        $records = AsuransiMotor::grid()->filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($record) {
                    return request()->start;
                }
            )
            ->addColumn(
                'perusahaan_asuransi_id',
                function ($record) {
                    return "<span class='badge badge-danger'>" . $record->perusahaanAsuransi->name . "</span>";
                }
            )
            ->addColumn(
                'name',
                function ($record) {
                    return "<span class='badge badge-primary'>" . $record->name . "</span>";
                }
            )
            ->addColumn(
                'pembayaran_persentasi',
                function ($record) {
                    return "<span class='badge badge-info'>Rp. " . $record->pembayaran_persentasi . "/". $record->intervalPembayaran->name."</span>";
                }
            )
            ->addColumn('call_center', function ($record) {
                return  "<span class='badge badge-primary'>" . $record->call_center . "</span>";
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
            ->rawColumns(['action', 'updated_by', 'name', 'perusahaan_asuransi_id', 'pembayaran_persentasi', 'call_center'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(AsuransiMotorRequest $request)
    {
        $record = new AsuransiMotor;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(AsuransiMotor $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(AsuransiMotor $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(AsuransiMotorRequest $request, AsuransiMotor $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(AsuransiMotor $record)
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
        $record = new KondisiKendaraan;
        return $record->handleImport($request);
    }
}
