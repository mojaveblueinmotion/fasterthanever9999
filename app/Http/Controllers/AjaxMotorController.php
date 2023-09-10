<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\AsuransiMotor\Merk;
use App\Models\Master\AsuransiMotor\Seri;
use App\Models\Master\AsuransiMotor\Tahun;
use App\Models\Master\AsuransiMotor\AsuransiMotor;

class AjaxMotorController extends Controller
{
    
    public function selectAsuransiMotor($search, Request $request)
    {
        $items = AsuransiMotor::keywordBy('name')->orderBy('name');
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
    // FOR DATABASE MOBIL
    public function selectMerkMotor($search, Request $request)
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

    public function selectTahunMotor($search, Request $request)
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

    public function tahunMotorOptions(Request $request)
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

    public function selectSeriMotor($search, Request $request)
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

    public function seriMotorOptions(Request $request)
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

}
