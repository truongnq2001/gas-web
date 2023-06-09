<?php

namespace App\Http\Controllers;

use App\Models\Export;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    protected $dashboard;

    //construct
    public function __construct()
    {
        $this->dashboard = new DashboardController();
    }

    //show export
    public function showExport()
    {
        $exportThirtyDay = $this->exportThirtyDay()[0]->soluong;
        $revenueThirtyDay = $this->revenueThirtyDay()[0]->tongtienxuat;
        $exportYear = $this->exportYear()[0]->soluong;
        $revenueYear = $this->revenueYear()[0]->tongtienxuat;

        return view('admin.exportStatistics', [
            'exportThirtyDay' => $exportThirtyDay,
            'revenueThirtyDay' => $this->dashboard->changeRevenue($revenueThirtyDay),
            'exportYear' => $exportYear,
            'revenueYear' => $this->dashboard->changeRevenue($revenueYear),
            'arrExportMonth' => $this->arrExportMonth(),
            'exportByGas' => $this->exportByGas(),
            'exportBySupplier' => $this->exportBySupplier(),
            'arrExportBySupplier' => $this->arrExportThirty(),
            'arrExport' => $this->arrExport(),
        ]);
    }

    // arr import
    private function arrExport()
    {
        $arrExport = DB::select("SELECT *
                                FROM soxuat
                                JOIN gas ON soxuat.maGAS = gas.id
                                JOIN daily ON soxuat.maDL = daily.id
                                ORDER BY soxuat.ngaythang DESC");
        return $arrExport;
    }

    private function arrExportThirty()
    {
        $arrExportThirty = DB::select("SELECT daily.ten AS tenDL, SUM(soxuat.soluong) AS soluong
                                        FROM soxuat
                                        JOIN gas ON soxuat.maGAS = gas.id
                                        JOIN daily ON soxuat.maDL = daily.id
                                        WHERE soxuat.ngaythang >= CURDATE() - INTERVAL 30 DAY
                                        GROUP BY soxuat.maDL, daily.ten
                                        ORDER BY soluong DESC");
        return $arrExportThirty;
    }

    // arr import
    public function arrExportByCustomer(Request $request)
    {
        if ($request->type == '30') {
            $arrExportByCustomer = $this->arrExportThirty();
        } elseif ($request->type == 'year') {
            $arrExportByCustomer = DB::select("SELECT daily.ten AS tenDL, SUM(soxuat.soluong) AS soluong
                                                FROM soxuat
                                                JOIN gas ON soxuat.maGAS = gas.id
                                                JOIN daily ON soxuat.maDL = daily.id
                                                GROUP BY soxuat.maDL, daily.ten
                                                ORDER BY soluong DESC");
        } 
        
        $view = view('admin.export.topExportCustomer', [
            'arrExportBySupplier' => $arrExportByCustomer,
            ])->render();
        
        return Response::json([
            'status' => 'success',
            'message' => 'Yêu cầu thành công!',
            'html' => $view,
        ]);
    }

    // arr export
    private function arrExportMonth()
    {
        $arrExportMonth = DB::select("SELECT MONTH(soxuat.ngaythang) AS thang, SUM(soxuat.soluong) AS soluong
                                FROM soxuat
                                JOIN gas ON soxuat.maGAS = gas.id
                                GROUP BY MONTH(soxuat.ngaythang)");
        return $arrExportMonth;
    }

    // importByGas
    private function exportBySupplier()
    {
        $exportBySupplier = DB::select("SELECT tenDL, soluong
                                        FROM (
                                            SELECT daily.ten AS tenDL, SUM(soxuat.soluong) AS soluong
                                            FROM soxuat
                                            JOIN gas ON soxuat.maGAS = gas.id
                                            JOIN daily ON soxuat.maDL = daily.id
                                            GROUP BY soxuat.maDL, daily.ten
                                            ORDER BY soluong DESC
                                            LIMIT 4
                                        ) AS top3
                                        UNION
                                        SELECT 'Khác' AS tenGAS, SUM(soluong) AS soluong
                                        FROM (
                                            SELECT daily.ten AS tenDL, SUM(soxuat.soluong) AS soluong
                                            FROM soxuat
                                            JOIN gas ON soxuat.maGAS = gas.id
                                            JOIN daily ON soxuat.maDL = daily.id
                                            GROUP BY soxuat.maDL, daily.ten
                                            ORDER BY soluong DESC
                                            LIMIT 4,999999999
                                        ) AS khac
                                        ORDER BY soluong DESC");
        return $exportBySupplier;
    }

    // importByGas
    private function exportByGas()
    {
        $exportByGas = DB::select("SELECT tenGAS, soluong
                                FROM (
                                    SELECT gas.tenGAS AS tenGAS, SUM(soxuat.soluong) AS soluong
                                    FROM soxuat
                                    JOIN gas ON soxuat.maGAS = gas.id
                                    GROUP BY soxuat.maGAS, gas.tenGAS
                                    ORDER BY soluong DESC
                                    LIMIT 3
                                ) AS top3
                                UNION
                                SELECT 'Các loại gas khác' AS tenGAS, SUM(soluong) AS soluong
                                FROM (
                                    SELECT gas.tenGAS AS tenGAS, SUM(soxuat.soluong) AS soluong
                                    FROM soxuat
                                    JOIN gas ON soxuat.maGAS = gas.id
                                    GROUP BY soxuat.maGAS, gas.tenGAS
                                    ORDER BY soluong DESC
                                    LIMIT 3,999999999
                                ) AS khac
                                ORDER BY soluong DESC");
        return $exportByGas;
    }

    // import 30 day
    private function exportThirtyDay()
    {
        $exportThirtyDay = DB::select("SELECT SUM(soxuat.soluong) AS soluong
                                FROM soxuat
                                WHERE soxuat.ngaythang >= CURDATE() - INTERVAL 30 DAY");
        return $exportThirtyDay;
    }

    // import year
    private function exportYear()
    {
        $exportYear = DB::select("SELECT SUM(soxuat.soluong) AS soluong
                                FROM soxuat");
        return $exportYear;
    }

    // expense 30 day
    private function revenueThirtyDay()
    {
        $revenueThirtyDay = DB::select("SELECT SUM(soxuat.soluong*gas.dongia) AS tongtienxuat
                                        FROM soxuat
                                        JOIN gas ON soxuat.maGAS = gas.id
                                        WHERE soxuat.ngaythang >= CURDATE() - INTERVAL 30 DAY");
        return $revenueThirtyDay;
    }

    // expense year
    private function revenueYear()
    {
        $revenueYear = DB::select("SELECT SUM(soxuat.soluong*gas.dongia) AS tongtienxuat
                                        FROM soxuat
                                        JOIN gas ON soxuat.maGAS = gas.id");
        return $revenueYear;
    }

    //show add import
    public function showAddExport()
    {
        return view('admin.addExport',[
            'gas' => DB::table('gas')->get(),
            'customer' => DB::table('daily')->get(),
        ]);
    }

    //show add import
    public function saveExport(Request $request)
    {
        $dateTime = Carbon::createFromFormat('Y-m-d\TH:i', $request->date);

        Export::create([
            'soluong' => $request->quantity,
            'maNV' => $request->maNV,
            'maGAS' => $request->maGAS,
            'maDL' => $request->maDL,
            'ngaythang' => $dateTime,
        ]);

        return back()->with('success', 'Thêm vào sổ xuất gas thành công!');
    }
}
