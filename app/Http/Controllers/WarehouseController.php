<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    //show payment
    public function showWarehouse()
    {
        $arrImport = DB::select("SELECT sonhap.maGAS, gas.tenGAS, gas.dongia, gas.dongianhap, nhacungcap.tenNCC, SUM(sonhap.soluong) AS soluong
                                    FROM sonhap
                                    JOIN gas ON sonhap.maGAS = gas.id
                                    JOIN nhacungcap ON sonhap.maNCC = nhacungcap.id
                                    GROUP BY sonhap.maGAS, gas.tenGAS, gas.dongia, gas.dongianhap, nhacungcap.tenNCC");
        $arrExport = DB::select("SELECT soxuat.maGAS, gas.tenGAS, SUM(soxuat.soluong) AS soluong
                                    FROM soxuat
                                    JOIN gas ON soxuat.maGAS = gas.id
                                    GROUP BY soxuat.maGAS, gas.tenGAS");

        $arrWarehouse = $arrImport;

        for ($i=0; $i < count($arrWarehouse); $i++) { 
            for ($j=0; $j < count($arrExport); $j++) { 
                if ($arrWarehouse[$i]->maGAS == $arrExport[$j]->maGAS) {
                    $arrWarehouse[$i]->soluong = $arrWarehouse[$i]->soluong - $arrExport[$j]->soluong;
                    break;
                }
            }
            
        }

        return view('admin.gasWarehouse', [
            'arrWarehouse' => $arrWarehouse,
        ]);
    }
}
