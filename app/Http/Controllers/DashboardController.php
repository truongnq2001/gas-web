<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //show dashboard
    public function showDashboard()
    {
        $revenueArr = DB::select("SELECT MONTH(sothanhtoan.ngaythang) AS thang, SUM(gas.dongia * soxuat.soluong) AS doanhthu
                                    FROM sothanhtoan
                                    JOIN soxuat ON sothanhtoan.maSX = soxuat.id
                                    JOIN gas ON soxuat.maGAS = gas.id
                                    GROUP BY MONTH(sothanhtoan.ngaythang)");
        $totalRevenue = 0;
        foreach ($revenueArr as $item) {
            $totalRevenue += $item->doanhthu;
        }
        $averageRevenue = $totalRevenue/count($revenueArr);

        $revenueThirtyDay = $this->revenueThirtyDay()[0]->doanhthu;
        $revenueSixtyDay = $this->revenueSixtyDay()[0]->doanhthu;
        $revenueYear = $this->revenueYear()[0]->doanhthu;

        $expenseThirtyDay = $this->expenseThirtyDay()[0]->chiphi;
        $expenseSixtyDay = $this->expenseSixtyDay()[0]->chiphi;
        $expenseYear = $this->expenseYear()[0]->chiphi;

        $exportThiryDay = $this->exportThiryDay()[0]->soluong;
        $exportSixtyDay = $this->exportSixtyDay()[0]->soluong;

        $percentRevenue = ($revenueThirtyDay - $revenueSixtyDay)/$revenueSixtyDay*100;
        $percentRevenue = number_format(round($percentRevenue, 2), 2);

        $percentExpense = ($expenseThirtyDay - $expenseSixtyDay)/$expenseSixtyDay*100;
        $percentExpense = number_format(round($percentExpense, 2), 2);

        $percentProfit = (($revenueThirtyDay- $expenseThirtyDay) - ($revenueSixtyDay-$expenseSixtyDay))/($revenueSixtyDay-$expenseSixtyDay)*100;
        $percentProfit = number_format(round($percentProfit, 2), 2);
        
        $percentExport = ($exportThiryDay - $exportSixtyDay)/$exportSixtyDay*100;
        $percentExport = number_format(round($percentExport, 2), 2);

        $percentExpenseRevenue = (int)($expenseThirtyDay/$revenueThirtyDay*100);
        $percentProfitRevenue = (int)(($revenueThirtyDay - $expenseThirtyDay)/$revenueThirtyDay*100);

        $percentExpenseYear = (int)($expenseYear/$revenueYear*100);
        $percentProfitYear = (int)(($revenueYear - $expenseYear)/$revenueYear*100);

        return view('admin.dashboard',[
            'averageRevenue' => $averageRevenue,
            'revenueArr' => $revenueArr,
            'revenueThirtyDay'=> $this->changeRevenue($revenueThirtyDay),
            'expenseThiryDay' => $this->changeRevenue($expenseThirtyDay),
            'profitThiryDay' => $this->changeRevenue($revenueThirtyDay - $expenseThirtyDay),
            'exportThiryDay' => $exportThiryDay,

            'revenueThirtyDayBase'=> $revenueThirtyDay,
            'expenseThiryDayBase' => $expenseThirtyDay,
            'profitThiryDayBase' => $revenueThirtyDay - $expenseThirtyDay,

            'revenueYear' => $revenueYear,
            'profitYear' => $revenueYear - $expenseYear,

            'percentExpenseRevenue' => $percentExpenseRevenue,
            'percentProfitRevenue' => $percentProfitRevenue,
            'percentExpenseYear' => $percentExpenseYear,
            'percentProfitYear' => $percentProfitYear,

            'percentRevenue' => $percentRevenue,
            'percentExpense' => $percentExpense,
            'percentProfit' => $percentProfit,
            'percentExport' => $percentExport,

            'arrayGasExport' => $this->arrayGasExport(),
        ]);
    }

    //revenue 30 day
    public function revenueThirtyDay()
    {
        $revenueThirtyDay = DB::select("SELECT SUM(gas.dongia * soxuat.soluong) AS doanhthu
                                        FROM sothanhtoan
                                        JOIN soxuat ON sothanhtoan.maSX = soxuat.id
                                        JOIN gas ON soxuat.maGAS = gas.id
                                        JOIN daily ON soxuat.maDL = daily.id
                                        WHERE sothanhtoan.ngaythang >= CURDATE() - INTERVAL 30 DAY");
        return $revenueThirtyDay;
    }

    //revenue 60 day
    private function revenueSixtyDay()
    {
        $revenueSixtyDay = DB::select("SELECT SUM(gas.dongia * soxuat.soluong) AS doanhthu
                                        FROM sothanhtoan
                                        JOIN soxuat ON sothanhtoan.maSX = soxuat.id
                                        JOIN gas ON soxuat.maGAS = gas.id
                                        JOIN daily ON soxuat.maDL = daily.id
                                        WHERE sothanhtoan.ngaythang >= CURDATE() - INTERVAL 60 DAY
                                        AND sothanhtoan.ngaythang < CURDATE() - INTERVAL 30 DAY");
        return $revenueSixtyDay;
    }

    //revenue 2023
    public function revenueYear()
    {
        $revenueYear = DB::select("SELECT SUM(gas.dongia * soxuat.soluong) AS doanhthu
                                    FROM sothanhtoan
                                    JOIN soxuat ON sothanhtoan.maSX = soxuat.id
                                    JOIN gas ON soxuat.maGAS = gas.id
                                    JOIN daily ON soxuat.maDL = daily.id");
        return $revenueYear;
    }

    //expense 30 day
    public function expenseThirtyDay()
    {
        $expenseThirtyDay = DB::select("SELECT SUM(gas.dongianhap * soxuat.soluong) AS chiphi
                                        FROM sothanhtoan
                                        JOIN soxuat ON sothanhtoan.maSX = soxuat.id
                                        JOIN gas ON soxuat.maGAS = gas.id
                                        JOIN daily ON soxuat.maDL = daily.id
                                        WHERE sothanhtoan.ngaythang >= CURDATE() - INTERVAL 30 DAY");
        return $expenseThirtyDay;
    }

    //expense 60 day
    private function expenseSixtyDay()
    {
        $expenseSixtyDay = DB::select("SELECT SUM(gas.dongianhap * soxuat.soluong) AS chiphi
                                        FROM sothanhtoan
                                        JOIN soxuat ON sothanhtoan.maSX = soxuat.id
                                        JOIN gas ON soxuat.maGAS = gas.id
                                        JOIN daily ON soxuat.maDL = daily.id
                                        WHERE sothanhtoan.ngaythang >= CURDATE() - INTERVAL 60 DAY
                                        AND sothanhtoan.ngaythang < CURDATE() - INTERVAL 30 DAY");
        return $expenseSixtyDay;
    }

    //revenue 2023
    public function expenseYear()
    {
        $expenseYear = DB::select("SELECT SUM(gas.dongianhap * soxuat.soluong) AS chiphi
                                    FROM sothanhtoan
                                    JOIN soxuat ON sothanhtoan.maSX = soxuat.id
                                    JOIN gas ON soxuat.maGAS = gas.id
                                    JOIN daily ON soxuat.maDL = daily.id");
        return $expenseYear;
    }

    //export 30 day
    private function exportThiryDay()
    {
        $exportThiryDay = DB::select("SELECT SUM(soxuat.soluong) AS soluong
                                        FROM soxuat
                                        WHERE soxuat.ngaythang >= CURDATE() - INTERVAL 30 DAY");
        return $exportThiryDay;
    }

    //export 60 day
    private function exportSixtyDay()
    {
        $exportSixtyDay = DB::select("SELECT SUM(soxuat.soluong) AS soluong
                                        FROM soxuat
                                        WHERE soxuat.ngaythang >= CURDATE() - INTERVAL 60 DAY 
                                        AND soxuat.ngaythang < CURDATE() - INTERVAL 30 DAY");
        return $exportSixtyDay;
    }

    //array gas best seller
    private function arrayGasExport()
    {
        $arrayGasExport = DB::select("SELECT gas.tenGAS AS tenGAS, nhacungcap.tenNCC AS tenNCC, SUM(soxuat.soluong) AS soluong
                                        FROM soxuat
                                        JOIN gas ON soxuat.maGAS = gas.id
                                        JOIN nhacungcap ON gas.maNCC = nhacungcap.id
                                        WHERE soxuat.ngaythang >= CURDATE() - INTERVAL 30 DAY
                                        GROUP BY soxuat.maGAS, gas.tenGAS, nhacungcap.tenNCC
                                        ORDER BY soluong DESC");
        return $arrayGasExport;
    }

    //change revenue
    public function changeRevenue(int $num)
    {
        if ($num/1000000000 > 1) {
            $numStr = number_format($num / 1000000000, 2, ',', ',') . ' tỷ';;
        }elseif ($num/1000000 > 1) {
            $numStr = (int)($num/1000000).' triệu';
        } 
        return $numStr;
    }
}
