<?php

namespace App\Http\Controllers\Api\Asuransi;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Asuransi\PolisMobil;
use App\Http\Controllers\Controller;
use App\Models\Setting\Globals\Files;
use App\Models\Asuransi\PolisMobilCek;
use App\Models\Asuransi\PolisMobilNilai;
use App\Models\Asuransi\PolisMobilClient;
use App\Models\Asuransi\PolisMobilPayment;
use App\Http\Controllers\Api\BaseController;

class AsuransiMobilApiController extends BaseController
{
    public function agentAsuransiMobil(Request $request){
        try{
            // $noAsuransi = PolisMobil::generateNoAsuransi();
            $record = PolisMobil::firstOrNew(['no_asuransi' => $request->no_asuransi]);   
            $record->fill($request->only($record->fillable));
            // $record->no_asuransi = $noAsuransi->no_asuransi;
            // $record->no_max = $noAsuransi->no_max;
            $record->no_max = "001";
            $record->status = 'penawaran';
            $record->save();

            $recordCek = PolisMobilCek::firstOrNew(['polis_id' => $record->id]); 
            $recordCek->fill($request->only($recordCek->fillable));
            $recordCek->save();
            
            $recordNilai = PolisMobilCek::firstOrNew(['polis_id' => $record->id]); 
            $recordNilai->fill($request->only($recordNilai->fillable));
            // $recordNilai->polis_id = $record->id;
            $recordNilai->save();

            return response()->json([
                'success' => true,
                'message' => "Data Asuransi Berhasil Ditambahkan | status = Penawaran",
                'data' => $record
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e,
                'data' => $record
            ]);
        }
    }

    public function agentPenawaranAsuransiMobil(Request $request){
        try{
            $record = PolisMobil::where('no_asuransi', $request->no_asuransi)->first();
            $record->update([
                'status' => 'pending'
            ]);
            $record->save();

            $recordClient = new PolisMobilClient;   
            $recordClient->fill($request->only($recordClient->fillable));
            $recordClient->polis_id = $record->id;
            $recordClient->save();

            $recordPayment = new PolisMobilPayment;   
            $recordPayment->fill($request->only($recordPayment->fillable));
            $recordPayment->polis_id = $record->id;
            $recordPayment->save();

            if ($request->files) {
                foreach($request->files as $nama_file => $arr){
                    foreach ($request->file($nama_file) as $key => $file) {
                        // dd(53, $file->getClientOriginalName());
                        $file_path = Carbon::now()->format('Ymdhisu')
                            . md5($file->getClientOriginalName())
                            . '/' . $file->getClientOriginalName();
        
                        $sys_file = new Files;
                        $sys_file->target_id    = $record->id;
                        $sys_file->target_type  = PolisMobil::class;
                        $sys_file->module       = 'asuransi.polis-mobil';
                        $sys_file->file_name    = $file->getClientOriginalName();
                        $sys_file->file_path    = $file->storeAs('files', $file_path, 'public');
                        // $temp->file_type = $file->extension();
                        $sys_file->file_size = $file->getSize();
                        $sys_file->flag = $nama_file;
                        $sys_file->save();
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Data Asuransi Berhasil Diupdate | status = pending",
                'data' => $record
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e,
                'data' => $record
            ]);
        }
    }

    public function testFiles(Request $request)
    {
        $record = new PolisMobil;   
        $record->fill($request->only($record->fillable));
        $record->status = 'penawaran';
        $record->save();

        if ($request->files) {
            foreach($request->files as $nama_file => $arr){
                foreach ($request->file($nama_file) as $key => $file) {
                    // dd(53, $file->getClientOriginalName());
                    $file_path = Carbon::now()->format('Ymdhisu')
                        . md5($file->getClientOriginalName())
                        . '/' . $file->getClientOriginalName();
    
                    $sys_file = new Files;
                    $sys_file->target_id    = $record->id;
                    $sys_file->target_type  = PolisMobil::class;
                    $sys_file->module       = 'asuransi.polis-mobil';
                    $sys_file->file_name    = $file->getClientOriginalName();
                    $sys_file->file_path    = $file->storeAs('files', $file_path, 'public');
                    // $temp->file_type = $file->extension();
                    $sys_file->file_size = $file->getSize();
                    $sys_file->flag = $nama_file;
                    $sys_file->save();
                }
            }
        }
    }
}
