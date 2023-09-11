<?php

namespace App\Http\Controllers\Api\Asuransi;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\AsuransiPerjalanan\PolisPerjalanan;
use App\Http\Controllers\Controller;
use App\Models\Setting\Globals\Files;
use App\Models\AsuransiPerjalanan\PolisPerjalananPayment;
use App\Http\Controllers\Api\BaseController;

class AsuransiPerjalananApiController extends BaseController
{
    public function agentAsuransiPerjalanan(Request $request){
        try{
            // $noAsuransi = PolisPerjalanan::generateNoAsuransi();
            $record = PolisPerjalanan::firstOrNew(['no_asuransi' => $request->no_asuransi]);   
            $record->fill($request->only($record->fillable));
            // $record->no_asuransi = $noAsuransi->no_asuransi;
            // $record->no_max = $noAsuransi->no_max;
            // $record->no_max = "001";
            $record->status = 'penawaran';
            $record->save();

            return response()->json([
                'success' => true,
                'message' => "Data Asuransi Perjalanan Berhasil Ditambahkan | status = Penawaran",
                'data' => $record
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }
    }

    public function agentPenawaranAsuransiPerjalanan(Request $request){
        try{
            $record = PolisPerjalanan::where('no_asuransi', $request->no_asuransi)->first();
            $record->update([
                'status' => 'pending'
            ]);
            $record->save();

            $recordPayment = new PolisPerjalananPayment;   
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
                        $sys_file->target_type  = PolisPerjalanan::class;
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
                'message' => "Data Asuransi Perjalanan Berhasil Diupdate | status = pending",
                'data' => $record
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }
    }

    public function testFilesPerjalanan(Request $request)
    {
        $record = new PolisPerjalanan;   
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
                    $sys_file->target_type  = PolisPerjalanan::class;
                    $sys_file->module       = 'asuransi.polis-perjalanan';
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
