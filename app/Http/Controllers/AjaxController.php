<?php

namespace App\Http\Controllers;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Master\Asset;
use Illuminate\Http\Request;
use App\Models\Change\Change;
use App\Models\Master\Geo\City;
use App\Models\Master\Priority;
use App\Models\Master\Severity;
use App\Models\Problem\Problem;
use App\Models\Master\AssetType;
use App\Models\Master\RoleGroup;
use App\Models\Incident\Incident;
use App\Models\Master\Org\Struct;
use App\Models\Master\AssetDetail;
use App\Models\Knowledge\Knowledge;
use App\Models\Master\Geo\Province;
use App\Models\Master\Org\Position;
use App\Models\Master\Pegawai\Pegawai;
use App\Models\Master\DatabaseMobil\Merk;
use App\Models\Master\DatabaseMobil\Seri;
use App\Models\Setting\Globals\TempFiles;
use App\Models\Master\DatabaseMobil\Tahun;
use App\Models\Setting\Globals\Notification;
use App\Models\Master\DataAsuransi\FiturAsuransi;
use App\Models\Master\AsuransiMobil\AsuransiMobil;
use App\Models\Master\DataAsuransi\IntervalPembayaran;
use App\Models\Master\DataAsuransi\PerusahaanAsuransi;
use App\Models\Master\AsuransiPerjalanan\AsuransiPerjalanan;

class AjaxController extends Controller
{
    public function saveTempFiles(Request $request)
    {
        $this->beginTransaction();
        $mimes = null;
        if ($request->accept == '.xlsx') {
            $mimes = 'xlsx';
        }
        if ($request->accept == '.png, .jpg, .jpeg') {
            $mimes = 'png,jpg,jpeg';
        }
        if ($mimes) {
            $request->validate(
                ['file' => ['mimes:' . $mimes]]
            );
        }
        try {
            if ($file = $request->file('file')) {
                $file_path = str_replace('.' . $file->extension(), '', $file->hashName());
                $file_path .= '/' . $file->getClientOriginalName();

                $temp = new TempFiles;
                $temp->file_name = $file->getClientOriginalName();
                $temp->file_path = $file->storeAs('temp-files', $file_path, 'public');
                // $temp->file_type = $file->extension();
                $temp->file_size = $file->getSize();
                $temp->flag = $request->flag;
                $temp->save();
                return $this->commit(
                    [
                        'file' => TempFiles::find($temp->id)
                    ]
                );
            }
            return $this->rollback(['message' => 'File not found']);
        } catch (\Exception $e) {
            return $this->rollback(['error' => $e->getMessage()]);
        }
    }

    public function userNotification()
    {
        $notifications = auth()->user()
            ->notifications()
            ->with('creator.position', 'updater.position')
            ->latest()
            ->simplePaginate(25);
        return $this->render('layouts.base.notification', compact('notifications'));
    }

    public function userNotificationRead(Notification $notification)
    {
        auth()->user()
            ->notifications()
            ->updateExistingPivot($notification, array('readed_at' => now()), false);
        return redirect($notification->full_url);
    }

    public function selectAsset($search, Request $request)
    {
        $items = Asset::keywordBy('name')
            ->when(
                $asset_type_id = $request->asset_type_id,
                function ($q) use ($asset_type_id) {
                    $q->where('asset_type_id', $asset_type_id);
                }
            )
            ->orderBy('name')
            ->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectAssetDetail($search, Request $request)
    {
        $items = AssetDetail::keywordBy('name')
            ->when(
                $asset_id = $request->asset_id,
                function ($q) use ($asset_id) {
                    $q->where('asset_id', $asset_id);
                }
            )
            ->orderBy('name')
            ->paginate(50);

        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectAssetType($search, Request $request)
    {
        $items = AssetType::keywordBy('name')
            ->orderBy('name')
            ->paginate();

        return $this->responseSelect2($items, 'name', 'id');
    }
    public function selectCity($search, Request $request)
    {
        $items = City::keywordBy('name')
            ->when(
                $code = $request->code,
                function ($q) use ($code) {
                    $q->where('code', $code);
                }
            )
            ->when(
                $province_id = $request->province_id,
                function ($q) use ($province_id) {
                    $q->where('province_id', $province_id);
                }
            )
            ->orderBy('name');
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectChange($search, Request $request)
    {
        $items = Change::keywordBy('code')
            ->when(
                $status = $request->status,
                function ($q) use ($status) {
                    $q->where('status', $status);
                }
            )
            ->when(
                $asset_id = $request->asset_id,
                function ($q) use ($asset_id) {
                    $q->where('asset_id', $asset_id);
                }
            )
            ->orderBy('code');
        $items = $items->paginate();
        return $this->responseSelect2($items, 'code', 'id');
    }
    public function selectIncident($search, Request $request)
    {
        $items = Incident::keywordBy('code')
            ->when(
                $status = $request->status,
                function ($q) use ($status) {
                    $q->where('status', $status);
                }
            )
            ->when(
                $asset_id = $request->asset_id,
                function ($q) use ($asset_id) {
                    $q->where('asset_id', $asset_id);
                }
            )
            ->orderBy('code');
        $items = $items->paginate();
        return $this->responseSelect2($items, 'code', 'id');
    }
    public function selectKnowledge($search, Request $request)
    {
        $items = Knowledge::keywordBy('title')
            ->when(
                $status = $request->status,
                function ($q) use ($status) {
                    $q->where('status', $status);
                }
            )
            ->when(
                $asset_id = $request->asset_id,
                function ($q) use ($asset_id) {
                    $q->where('asset_id', $asset_id);
                }
            )
            ->orderBy('title');
        $items = $items->paginate();
        return $this->responseSelect2($items, 'title', 'id');
    }
    public function selectPosition($search, Request $request)
    {
        $items = Position::keywordBy('name')
            ->when(
                $location_id = $request->location_id,
                function ($q) use ($location_id) {
                    $q->where('location_id', $location_id);
                }
            )
            ->orderBy('name')
            ->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }
    public function selectProblem($search, Request $request)
    {
        $items = Problem::keywordBy('code')
            ->when(
                $status = $request->status,
                function ($q) use ($status) {
                    $q->where('status', $status);
                }
            )
            ->when(
                $asset_id = $request->asset_id,
                function ($q) use ($asset_id) {
                    $q->where('asset_id', $asset_id);
                }
            )
            ->orderBy('code');
        $items = $items->paginate();
        return $this->responseSelect2($items, 'code', 'id');
    }

    public function selectPriority($search, Request $request)
    {
        $items = Priority::keywordBy('name')
            ->orderBy('name')
            ->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectProvince($search, Request $request)
    {
        $items = Province::keywordBy('name')
            ->when(
                $code = $request->code,
                function ($q) use ($code) {
                    $q->where('code', $code);
                }
            )
            ->orderBy('name');
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function cityOptions(Request $request)
    {
        $items = City::keywordBy('name')->when(
            $province_id = $request->province_id,
            function ($q) use ($province_id) {
                $q->where('province_id', $province_id);
            }
        )
            ->orderBy('name', 'ASC')
            ->get();

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }
    
    public function selectProvinceForCity($search, Request $request)
    {
        $items = Province::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectIntervalPembayaran($search, Request $request)
    {
        $items = IntervalPembayaran::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectPerusahaanAsuransi($search, Request $request)
    {
        $items = PerusahaanAsuransi::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectFiturAsuransi($search, Request $request)
    {
        $items = FiturAsuransi::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectRole($search, Request $request)
    {
        $items = Role::keywordBy('name')
            ->when(
                $id_in = $request->id_in,
                function ($q) use ($id_in) {
                    $q->whereIn('id', $id_in);
                }
            )
            ->orderBy('name');
        switch ($search) {
            case 'approver':
                $perms = str_replace('_', '.', $request->perms) . '.approve';
                $items = $items->whereHas(
                    'permissions',
                    function ($q) use ($perms) {
                        $q->where('name', $perms);
                    }
                );
                break;
        }
        $items = $items
            ->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectSeverity($search, Request $request)
    {
        $items = Severity::keywordBy('name')
            ->orderBy('name')
            ->paginate();

        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectStruct(Request $request, $search)
    {
        $items = Struct::keywordBy('name')
            ->orderBy('level')
            ->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items->where('level', '!=', 'root');
                break;
            case 'parent_boc':
                $items = $items->whereIn('level', ['root']);
                break;
            case 'parent_bod':
                $items = $items->whereIn('level', ['root', 'bod']);
                break;
            case 'parent_division':
                $items = $items->whereIn('level', ['bod']);
                break;
            case 'parent_department':
                $items = $items->whereIn('level', ['division']);
                break;
            case 'parent_unit-bisnis':
                $items = $items->whereIn('level', ['bod']);
                break;
            case 'parent_position':
                $items = $items->whereNotIn('level', ['root', 'group']);
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->when(
            $has_positions = $request->has_positions,
            function ($q) use ($has_positions) {
                $q->whereHas('positions');
            }
        )
            ->get();
        $results = [];
        $more = false;

        $levels = [
            'root',
            'bod',
            'division',
            'department',
            'unit-bisnis',
        ];
        if ($request->level) {
            $levels = [$request->level];
        }
        $i = 0;
        foreach ($levels as $level) {
            if ($items->where('level', $level)->count()) {
                foreach ($items->where('level', $level) as $item) {
                    $results[$i]['text'] = strtoupper($item->show_level);
                    $results[$i]['children'][] = ['id' => $item->id, 'text' => $item->name];
                }
                $i++;
            }
        }
        return response()->json(compact('results', 'more'));
    }

    public function selectTechnician($search, Request $request)
    {
        $items = RoleGroup::isTechnician()
            ->keywordBy('name')
            ->orderBy('name')
            ->paginate();

        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectUser($search, Request $request)
    {
        $items = User::keywordBy('name')
            ->where('status', 'active')
            ->orderBy('name');

        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'agent':
                $items = $items->whereHas(
                    'roles',
                    function ($q) {
                        $q->where('id', 2);
                    }
                );
                break;
            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();

        $results = [];
        $more = false;
        foreach ($items as $item) {
            $results[] = ['id' => $item->id, 'text' => $item->name . ' (' . $item->position->name . ')'];
        }
        return response()->json(compact('results', 'more'));
    }

    // FOR DATABASE MOBIL
    public function selectMerk($search, Request $request)
    {
        $items = Merk::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectTahun($search, Request $request)
    {
        $items = Tahun::keywordBy('tahun')->orderBy('tahun');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();

        $results = [];
        $more = false;
        foreach ($items as $item) {
            $results[] = ['id' => $item->id, 'text' => $item->tahun . ' (' . $item->merk->name . ')'];
        }
        return response()->json(compact('results', 'more'));
    }

    public function tahunOptions(Request $request)
    {
        $items = Tahun::when(
            $merk_id = $request->merk_id,
            function ($q) use ($merk_id) {
                $q->where('merk_id', $merk_id);
            }
        )
            ->orderBy('tahun', 'ASC')
            ->get();

        $items = $items->paginate();
        return $this->responseSelect2($items, 'tahun', 'id');
    }

    public function selectSeri($search, Request $request)
    {
        $items = Seri::keywordBy('code')->orderBy('code');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();

        $results = [];
        $more = false;
        foreach ($items as $item) {
            $results[] = ['id' => $item->id, 'text' => $item->code . ' (' . $item->model . ')'];
        }
        return response()->json(compact('results', 'more'));
    }

    public function seriOptions(Request $request)
    {
        $items = Seri::when(
            $merk_id = $request->merk_id,
            function ($q) use ($merk_id) {
                $q->where('merk_id', $merk_id);
            }
        )
            ->orderBy('code', 'ASC')
            ->get();

        $results = [];
        $more = false;
        foreach ($items as $item) {
            $results[] = ['id' => $item->id, 'text' => $item->code . ' (' . $item->model . ')'];
        }
        return response()->json(compact('results', 'more'));
    }

    // ==========================================================
    public function selectAgent($search, Request $request)
    {
        $items = User::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items->whereHas(
                    'roles',
                    function ($q) {
                        $q->where('id', 2);
                    });
                break;
            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectAsuransiMobil($search, Request $request)
    {
        $items = AsuransiMobil::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    // Asuransi Perjalanan
    public function selectAsuransiPerjalanan($search, Request $request)
    {
        $items = AsuransiPerjalanan::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }
}
