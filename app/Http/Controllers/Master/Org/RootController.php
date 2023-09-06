<?php

namespace App\Http\Controllers\Master\Org;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Org\RootRequest;
use App\Models\Master\Geo\City;
use App\Models\Master\Geo\Province;
use App\Models\Master\Org\Struct;
use App\Support\Base;
use Illuminate\Http\Request;

class RootController extends Controller
{
    protected $module = 'master.org.root';
    protected $routes = 'master.org.root';
    protected $views = 'master.org.root';
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
                'title' => 'Root',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Stuktur Organisasi' => route($this->routes . '.index'),
                    'Root' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:phone|label:Telepon|className:text-center|sortable:false'),
                        $this->makeColumn('name:address|label:Alamat|className:text-left|width:400px|sortable:false'),
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
        $records = Struct::root()->filters()->dtGet();

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
                'phone',
                function ($record) {
                    return Base::makeLabel($record->phone, 'warning');
                }
            )
            ->editColumn(
                'address',
                function ($record) {
                    return Base::makeLabel($record->address, 'primary');
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
                    return $this->makeButtonDropdown($actions);
                }
            )
            ->rawColumns(
                [
                    'name',
                    'phone',
                    'address',
                    'updated_by',
                    'action',
                ]
            )
            ->make(true);
    }

    public function show(Struct $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(Struct $record)
    {
        // dd(json_decode($record));
        $PROVINCES  = Province::orderBy('name', 'ASC')->get();
        $CITIES     = City::where('province_id', $record->city->province_id)
            ->orderBy('name', 'ASC')->get();
        return $this->render(
            $this->views . '.edit',
            compact('record', 'PROVINCES', 'CITIES')
        );
    }

    public function update(RootRequest $request, Struct $record)
    {
        return $record->handleStoreOrUpdate($request, 'root');
    }
}
