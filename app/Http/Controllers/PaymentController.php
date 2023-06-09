<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    //show payment
    public function showPayment(Request $request)
    {
        $queryStr = "SELECT daily.ten, soxuat.soluong, gas.tenGAS, gas.dongia, sothanhtoan.dathanhtoan, sothanhtoan.ngaythang  
                    FROM soxuat
                    LEFT JOIN sothanhtoan ON sothanhtoan.maSX = soxuat.id
                    LEFT JOIN daily ON soxuat.maDL = daily.id
                    LEFT JOIN gas ON soxuat.maGAS = gas.id";

        if ($request->check == 'all') {
            $queryStr = $queryStr."";
        }
        elseif ($request->check == 'paid') {
            $queryStr = $queryStr." WHERE sothanhtoan.dathanhtoan = 1";
        }
        elseif ($request->check == 'unpaid') {
            $queryStr = "SELECT daily.ten, soxuat.soluong, gas.tenGAS, gas.dongia
                                    FROM soxuat
                                    LEFT JOIN daily ON soxuat.maDL = daily.id
                                    LEFT JOIN gas ON soxuat.maGAS = gas.id
                                    WHERE NOT EXISTS (
                                        SELECT *
                                        FROM sothanhtoan
                                        WHERE sothanhtoan.maSX = soxuat.id
                                    )";
        }

        if ($request->time == '' || $request->time == 'latest') {
            $queryStr = $queryStr." ORDER BY soxuat.ngaythang DESC";
        }
        elseif ($request->time == 'oldest') {
            $queryStr = $queryStr." ORDER BY soxuat.ngaythang ASC";
        }

        $arrPayment = DB::select($queryStr);

        return view('admin.paymentStatistics', [
            'arrPayment' => $arrPayment,
        ]);
    }

    //show add import
    public function showAddPayment()
    {
        $payment = DB::select("SELECT soxuat.id, daily.ten, soxuat.soluong, gas.tenGAS, gas.dongia, gas.dongia*soxuat.soluong AS tongtien
                    FROM soxuat
                    LEFT JOIN daily ON soxuat.maDL = daily.id
                    LEFT JOIN gas ON soxuat.maGAS = gas.id
                    WHERE NOT EXISTS (
                        SELECT *
                        FROM sothanhtoan
                        WHERE sothanhtoan.maSX = soxuat.id
                    )");
        return view('admin.addPayment',[
            'payment' => $payment,
        ]);
    }

    //show add import
    public function savePayment(Request $request)
    {
        $dateTime = Carbon::createFromFormat('Y-m-d\TH:i', $request->date);

        Payment::create([
            'maNV' => $request->maNV,
            'maSX' => $request->maSX,
            'dathanhtoan' => 1,
            'ngaythang' => $dateTime,
        ]);

        return back()->with('success', 'Thêm vào sổ thanh toán thành công!');
    }
}
