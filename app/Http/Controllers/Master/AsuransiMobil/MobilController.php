<?php

namespace App\Http\Controllers\Master\AsuransiMobil;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\AsuransiMobil\MobilRequest;
use App\Models\Master\AsuransiMobil\Mobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    protected $module   = 'master.asuransi-mobil.mobil';
    protected $routes   = 'master.asuransi-mobil.mobil';
    protected $views    = 'master.asuransi-mobil.mobil';
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
                'title' => 'Mobil',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Asuransi Mobil' => route($this->routes . '.index'),
                    'Mobil' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:year|label:Tahun|className:text-center'),
                        $this->makeColumn('name:merk|label:Merk|className:text-center'),
                        $this->makeColumn('name:type|label:Tipe|className:text-center'),
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
        $records = Mobil::grid()->filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($record) {
                    return request()->start;
                }
            )
            ->addColumn(
                'year',
                function ($record) {
                    return "<span class='badge badge-danger'>" . $record->year . "</span>";
                }
            )
            ->addColumn(
                'merk',
                function ($record) {
                    return "<span class='badge badge-primary'>" . $record->merk . "</span>";
                }
            )
            ->addColumn(
                'type',
                function ($record) {
                    return "<span class='badge badge-info'>" . $record->type . "</span>";
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
            ->rawColumns(['action', 'updated_by', 'year', 'merk', 'type', 'description'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(MobilRequest $request)
    {
        $record = new Mobil;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Mobil $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(Mobil $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(MobilRequest $request, Mobil $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(Mobil $record)
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
        $record = new Mobil;
        return $record->handleImport($request);
    }
}
