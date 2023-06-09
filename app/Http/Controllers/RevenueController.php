<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class RevenueController extends Controller
{
    protected $dashboard;

    //construct
    public function __construct()
    {
        $this->dashboard = new DashboardController();
    }

    //show revenue
    public function showRevenue()
    {
        $revenueThirtyDay = $this->dashboard->revenueThirtyDay()[0]->doanhthu;
        $revenueYear = $this->dashboard->revenueYear()[0]->doanhthu;

        $expenseThirtyDay = $this->dashboard->expenseThirtyDay()[0]->chiphi;
        $expenseYear = $this->dashboard->expenseYear()[0]->chiphi;

        $profitThirtyDay = $revenueThirtyDay - $expenseThirtyDay;
        $profitYear = $revenueYear - $expenseYear;

        return view('admin.revenueStatistics',[
            'revenueArr' => $this->revenueArr(),
            'revenueCustomerArr' => $this->revenueByCustomer(),
            'revenueByGas' => $this->revenueByGas(),

            'topRevenueCustomer' => $this->topRevenueCustomerThirtyDay(),
            'topRevenueGas' => $this->topRevenueGasThirtyDay(),

            'revenueThirtyDay' => $this->dashboard->changeRevenue($revenueThirtyDay),
            'revenueYear' => $this->dashboard->changeRevenue($revenueYear),
            'profitThiryDay' => $this->dashboard->changeRevenue($profitThirtyDay),
            'profitYear' => $this->dashboard->changeRevenue($profitYear),
        ]);
    }

    //refreshRevenueCustomer
    public function refreshRevenueCustomer(Request $request)
    {
        if ($request->type == '30') {
            $topRevenueCustomer = $this->topRevenueCustomerThirtyDay();
        } elseif($request->type == 'year'){
            $topRevenueCustomer = DB::select("SELECT daily.ten AS khachhang, SUM(gas.dongia * soxuat.soluong) AS doanhthu
                                            FROM sothanhtoan
                                            JOIN soxuat ON sothanhtoan.maSX = soxuat.id
                                            JOIN gas ON soxuat.maGAS = gas.id
                                            JOIN daily ON soxuat.maDL = daily.id
                                            GROUP BY daily.id, daily.ten
                                            ORDER BY doanhthu DESC");
        }

        $view = view('admin.revenue.topRevenueCustomer', [
            'topRevenueCustomer' => $topRevenueCustomer,
            ])->render();
        
        return Response::json([
            'status' => 'success',
            'message' => 'Chuyển trang thành công',
            'html' => $view,
        ]);
    }

    //refreshRevenueGas
    public function refreshRevenueGas(Request $request)
    {
        if ($request->type == '30') {
            $topRevenueGas = $this->topRevenueGasThirtyDay();
        } elseif($request->type == 'year'){
            $topRevenueGas = DB::select("SELECT nhacungcap.tenNCC AS tenNCC, gas.tenGAS AS tenGAS, SUM(gas.dongia * soxuat.soluong) AS doanhthu
                                            FROM sothanhtoan
                                            JOIN soxuat ON sothanhtoan.maSX = soxuat.id
                                            JOIN gas ON soxuat.maGAS = gas.id
                                            JOIN nhacungcap ON gas.maNCC = nhacungcap.id
                                            GROUP BY soxuat.maGAS, nhacungcap.tenNCC, gas.tenGAS
                                            ORDER BY doanhthu DESC");
        }

        $view = view('admin.revenue.topRevenueGas', [
            'topRevenueGas' => $topRevenueGas,
            ])->render();
        
        return Response::json([
            'status' => 'success',
            'message' => 'Chuyển trang thành công',
            'html' => $view,
        ]);
    }

    //top revenue by customer
    private function topRevenueCustomerThirtyDay()
    {
        $topRevenueCustomerThirtyDay = DB::select("SELECT daily.ten AS khachhang, SUM(gas.dongia * soxuat.soluong) AS doanhthu
                                            FROM sothanhtoan
                                            JOIN soxuat ON sothanhtoan.maSX = soxuat.id
                                            JOIN gas ON soxuat.maGAS = gas.id
                                            JOIN daily ON soxuat.maDL = daily.id
                                            WHERE sothanhtoan.ngaythang >= CURDATE() - INTERVAL 30 DAY
                                            GROUP BY daily.id, daily.ten
                                            ORDER BY doanhthu DESC");

        return $topRevenueCustomerThirtyDay;
    }

    //top revenue by gas
    private function topRevenueGasThirtyDay()
    {
        $topRevenueGasThirtyDay = DB::select("SELECT nhacungcap.tenNCC AS tenNCC, gas.tenGAS AS tenGAS, SUM(gas.dongia * soxuat.soluong) AS doanhthu
                                                FROM sothanhtoan
                                                JOIN soxuat ON sothanhtoan.maSX = soxuat.id
                                                JOIN gas ON soxuat.maGAS = gas.id
                                                JOIN nhacungcap ON gas.maNCC = nhacungcap.id
                                                WHERE sothanhtoan.ngaythang >= CURDATE() - INTERVAL 30 DAY
                                                GROUP BY soxuat.maGAS, nhacungcap.tenNCC, gas.tenGAS
                                                ORDER BY doanhthu DESC");

        return $topRevenueGasThirtyDay;
    }

    //revenue by customer
    private function revenueByCustomer()
    {
        $revenueCustomerArr = DB::select("SELECT khachhang, doanhthu
        FROM (
            SELECT daily.ten AS khachhang, SUM(gas.dongia * soxuat.soluong) AS doanhthu
            FROM sothanhtoan
            JOIN soxuat ON sothanhtoan.maSX = soxuat.id
            JOIN gas ON soxuat.maGAS = gas.id
            JOIN daily ON soxuat.maDL = daily.id
            GROUP BY daily.id, daily.ten
            ORDER BY doanhthu DESC
            LIMIT 3
        ) AS top3
        UNION
        SELECT 'Khác' AS khachhang, SUM(doanhthu) AS doanhthu
        FROM (
            SELECT SUM(gas.dongia * soxuat.soluong) AS doanhthu
            FROM sothanhtoan
            JOIN soxuat ON sothanhtoan.maSX = soxuat.id
            JOIN gas ON soxuat.maGAS = gas.id
            JOIN daily ON soxuat.maDL = daily.id
            GROUP BY daily.id
            ORDER BY doanhthu DESC
            LIMIT 3,999999999
        ) AS khac
        ORDER BY doanhthu DESC");

        return $revenueCustomerArr;
    }


    //revenue by customer
    private function revenueByGas()
    {
        $revenueByGas = DB::select("SELECT tenGAS, doanhthu
        FROM (
            SELECT gas.tenGAS AS tenGAS, SUM(gas.dongia * soxuat.soluong) AS doanhthu
            FROM sothanhtoan
            JOIN soxuat ON sothanhtoan.maSX = soxuat.id
            JOIN gas ON soxuat.maGAS = gas.id
            GROUP BY soxuat.maGAS, gas.tenGAS
            ORDER BY doanhthu DESC
            LIMIT 3
        ) AS top3
        UNION
        SELECT 'Khác' AS tenGAS, SUM(doanhthu) AS doanhthu
        FROM (
            SELECT SUM(gas.dongia * soxuat.soluong) AS doanhthu
            FROM sothanhtoan
            JOIN soxuat ON sothanhtoan.maSX = soxuat.id
            JOIN gas ON soxuat.maGAS = gas.id
            GROUP BY soxuat.maGAS
            ORDER BY doanhthu DESC
            LIMIT 3,999999999
        ) AS khac
        ORDER BY doanhthu DESC");

        return $revenueByGas;
    }

    //array revenue
    private function revenueArr()
    {
        $revenueArr = DB::select("SELECT MONTH(sothanhtoan.ngaythang) AS thang, SUM(gas.dongia * soxuat.soluong) AS doanhthu
                                    FROM sothanhtoan
                                    JOIN soxuat ON sothanhtoan.maSX = soxuat.id
                                    JOIN gas ON soxuat.maGAS = gas.id
                                    GROUP BY MONTH(sothanhtoan.ngaythang)");
        return $revenueArr;
    }
}
