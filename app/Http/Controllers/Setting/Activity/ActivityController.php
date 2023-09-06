<?php

namespace App\Http\Controllers\Setting\Activity;

use App\Exports\Setting\ActivityExport;
use App\Http\Controllers\Controller;
use App\Models\Setting\Globals\Activity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ActivityController extends Controller
{
    protected $module   = 'setting.activity';
    protected $routes   = 'setting.activity';
    protected $views    = 'setting.activity';
    protected $perms    = 'setting';

    public function __construct()
    {
        $this->prepare(
            [
                'module' => $this->module,
                'routes' => $this->routes,
                'views' => $this->views,
                'permission' => $this->perms . '.view',
                'title' => 'History Aktivitas',
                'breadcrumb' => [
                    'Pengaturan Umum' => route($this->routes . '.index'),
                    'History Aktivitas' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:module|label:Modul|className:text-left|sortable:false'),
                        $this->makeColumn('name:message|label:Deskripsi|className:text-left|sortable:false'),
                        $this->makeColumn('name:created_by'),
                        // $this->makeColumn('name:action'),
                    ],
                ],
            ]
        );
        return $this->render($this->views . '.index');
    }

    public function grid()
    {
        $records = Activity::grid()->filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($record) {
                    return request()->start;
                }
            )
            ->addColumn(
                'module',
                function ($record) {
                    return $record->show_module;
                }
            )
            ->addColumn(
                'message',
                function ($record) {
                    return $record->show_message;
                }
            )
            ->editColumn(
                'created_by',
                function ($record) {
                    return $record->createdByRaw();
                }
            )
            ->rawColumns(['action', 'created_by'])
            ->make(true);
    }



    public function export()
    {
        return Excel::download(new ActivityExport, date('Y-m-d') . ' Audit Trail.xlsx');
    }
}
