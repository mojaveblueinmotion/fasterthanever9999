<?php

namespace App\Http\Controllers\Api\Auth;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Master\AsuransiMotor\Merk;
use App\Models\Master\AsuransiMotor\Seri;
use App\Models\Master\AsuransiMotor\Tahun;
use App\Http\Controllers\Api\BaseController;
use App\Models\Master\AsuransiMotor\TipeMotor;
use App\Models\Master\AsuransiMotor\AsuransiMotor;

class MasterMotorController extends BaseController
{
    // Motor
    public function selectAsuransiMotor(){
        try{
            $record =  AsuransiMotor::all();

            return response()->json([
                'success' => true,
                'message' => "Data Asuransi Motor",
                'data' => $record

            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }
    }

    public function selectMerkMotor($merk){
        try{
            $record =  Merk::where('name', 'like', '%' . $merk . '%')->get();

            return response()->json([
                'success' => true,
                'message' => "Data Merk Motor",
                'data' => $record

            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }
    }
    
    public function selectSeriMotor($merk_id){
        try{
            $record =  Seri::where('merk_id', $merk_id)->get();

            return response()->json([
                'success' => true,
                'message' => "Data Seri Motor",
                'data' => $record

            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }
    }

    public function selectTahunMotor($seri_id){
        try{
            $record =  Tahun::where('seri_id', $seri_id)->get();

            return response()->json([
                'success' => true,
                'message' => "Data Tahun Motor",
                'data' => $record

            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }
    }

    public function selectTipeMotor(){
        try{
            $record =  TipeMotor::all();

            return response()->json([
                'success' => true,
                'message' => "Data Tipe Motor",
                'data' => $record

            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }
    }
}
