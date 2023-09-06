<?php

namespace App\Http\Controllers\Master\AsuransiPerjalanan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\AsuransiPerjalanan\TipePerlindunganRequest;
use App\Models\Master\AsuransiPerjalanan\TipePerlindungan;
use Illuminate\Http\Request;

class TipePerlindunganController extends Controller
{
    protected $module   = 'master.asuransi-perjalanan.tipe-perlindungan';
    protected $routes   = 'master.asuransi-perjalanan.tipe-perlindungan';
    protected $views    = 'master.asuransi-perjalanan.tipe-perlindungan';
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
                'title' => 'Tipe Perlindungan',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Asuransi Perjalanan' => route($this->routes . '.index'),
                    'Tipe Perlindungan' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:name|label:Tipe Perlindungan|className:text-center'),
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
        $records = TipePerlindungan::grid()->filters()->dtGet();

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

    public function store(TipePerlindunganRequest $request)
    {
        $record = new TipePerlindungan;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(TipePerlindungan $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(TipePerlindungan $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(TipePerlindunganRequest $request, TipePerlindungan $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(TipePerlindungan $record)
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
        $record = new TipePerlindungan;
        return $record->handleImport($request);
    }
}
