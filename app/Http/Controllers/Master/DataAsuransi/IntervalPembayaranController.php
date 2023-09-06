<?php

namespace App\Http\Controllers\Master\DataAsuransi;

use Illuminate\Http\Request;
use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Models\Master\DataAsuransi\IntervalPembayaran;
use App\Http\Requests\Master\DataAsuransi\IntervalPembayaranRequest;

class IntervalPembayaranController extends Controller
{
    protected $module   = 'master.data-asuransi.interval-pembayaran';
    protected $routes   = 'master.data-asuransi.interval-pembayaran';
    protected $views    = 'master.data-asuransi.interval-pembayaran';
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
                'title' => 'Interval Pembayaran',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Data Asuransi' => route($this->routes . '.index'),
                    'Interval Pembayaran' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:name|label:Interval Pembayaran|className:text-center'),
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
        $records = IntervalPembayaran::grid()->filters()->dtGet();

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

    public function store(IntervalPembayaranRequest $request)
    {
        $record = new IntervalPembayaran;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(IntervalPembayaran $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(IntervalPembayaran $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(IntervalPembayaranRequest $request, IntervalPembayaran $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(IntervalPembayaran $record)
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
        $record = new IntervalPembayaran;
        return $record->handleImport($request);
    }
}
