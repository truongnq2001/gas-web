<?php

namespace App\Http\Controllers;

use App\Models\Import;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ImportController extends Controller
{
    protected $dashboard;

    //construct
    public function __construct()
    {
        $this->dashboard = new DashboardController();
    }

    //show import
    public function showImport()
    {
        $importThirtyDay = $this->importThirtyDay()[0]->soluong;
        $expenseThirtyDay = $this->expenseThirtyDay()[0]->tongtiennhap;
        $importYear = $this->importYear()[0]->soluong;
        $expenseYear = $this->expenseYear()[0]->tongtiennhap;

        return view('admin.importStatistics',[
            'importThirtyDay' => $importThirtyDay,
            'expenseThirtyDay' => $this->dashboard->changeRevenue($expenseThirtyDay),
            'importYear' => $importYear,
            'expenseYear' => $this->dashboard->changeRevenue($expenseYear),
            'arrImportMonth' => $this->arrImportMonth(),
            'arrImport' => $this->arrImport(),
            'importByGas' => $this->importByGas(),
            'importBySupplier' => $this->importBySupplier(),
            'arrImportBySupplier' => $this->arrImportThirty(),
        ]);
    }

    // arr import
    private function arrImportMonth()
    {
        $arrImportMonth = DB::select("SELECT MONTH(sonhap.ngaythang) AS thang, SUM(sonhap.soluong) AS soluong
                                FROM sonhap
                                JOIN gas ON sonhap.maGAS = gas.id
                                GROUP BY MONTH(sonhap.ngaythang)");
        return $arrImportMonth;
    }

    // arr import
    private function arrImport()
    {
        $arrImport = DB::select("SELECT *
                                FROM sonhap
                                JOIN gas ON sonhap.maGAS = gas.id
                                JOIN nhacungcap ON gas.maNCC = nhacungcap.id
                                ORDER BY sonhap.ngaythang DESC");
        return $arrImport;
    }

    private function arrImportThirty()
    {
        $arrImportBySupplier = DB::select("SELECT nhacungcap.tenNCC AS tenNCC, SUM(sonhap.soluong) AS soluong
                                    FROM sonhap
                                    JOIN gas ON sonhap.maGAS = gas.id
                                    JOIN nhacungcap ON gas.maNCC = nhacungcap.id
                                    WHERE sonhap.ngaythang >= CURDATE() - INTERVAL 30 DAY
                                    GROUP BY gas.maNCC, nhacungcap.tenNCC
                                    ORDER BY soluong DESC");
        return $arrImportBySupplier;
    }

    // arr import
    public function arrImportBySupplier(Request $request)
    {
        if ($request->type == '30') {
            $arrImportBySupplier = $this->arrImportThirty();
        } elseif ($request->type == 'year') {
            $arrImportBySupplier = DB::select("SELECT nhacungcap.tenNCC AS tenNCC, SUM(sonhap.soluong) AS soluong
                                    FROM sonhap
                                    JOIN gas ON sonhap.maGAS = gas.id
                                    JOIN nhacungcap ON gas.maNCC = nhacungcap.id
                                    GROUP BY gas.maNCC, nhacungcap.tenNCC
                                    ORDER BY soluong DESC");
        } 
        
        $view = view('admin.import.topImportSupplier', [
            'arrImportBySupplier' => $arrImportBySupplier,
            ])->render();
        
        return Response::json([
            'status' => 'success',
            'message' => 'Yêu cầu thành công!',
            'html' => $view,
        ]);
    }

    // importByGas
    private function importByGas()
    {
        $importByGas = DB::select("SELECT tenGAS, soluong
                                FROM (
                                    SELECT gas.tenGAS AS tenGAS, SUM(sonhap.soluong) AS soluong
                                    FROM sonhap
                                    JOIN gas ON sonhap.maGAS = gas.id
                                    GROUP BY sonhap.maGAS, gas.tenGAS
                                    ORDER BY soluong DESC
                                    LIMIT 3
                                ) AS top3
                                UNION
                                SELECT 'Các loại gas khác' AS tenGAS, SUM(soluong) AS soluong
                                FROM (
                                    SELECT gas.tenGAS AS tenGAS, SUM(sonhap.soluong) AS soluong
                                    FROM sonhap
                                    JOIN gas ON sonhap.maGAS = gas.id
                                    GROUP BY sonhap.maGAS, gas.tenGAS
                                    ORDER BY soluong DESC
                                    LIMIT 3,999999999
                                ) AS khac
                                ORDER BY soluong DESC");
        return $importByGas;
    }

    // importByGas
    private function importBySupplier()
    {
        $importBySupplier = DB::select("SELECT tenNCC, soluong
                                FROM (
                                    SELECT nhacungcap.tenNCC AS tenNCC, SUM(sonhap.soluong) AS soluong
                                    FROM sonhap
                                    JOIN gas ON sonhap.maGAS = gas.id
                                    JOIN nhacungcap ON gas.maNCC = nhacungcap.id
                                    GROUP BY gas.maNCC, nhacungcap.tenNCC
                                    ORDER BY soluong DESC
                                    LIMIT 4
                                ) AS top3
                                UNION
                                SELECT 'Khác' AS tenGAS, SUM(soluong) AS soluong
                                FROM (
                                    SELECT nhacungcap.tenNCC AS tenNCC, SUM(sonhap.soluong) AS soluong
                                    FROM sonhap
                                    JOIN gas ON sonhap.maGAS = gas.id
                                    JOIN nhacungcap ON gas.maNCC = nhacungcap.id
                                    GROUP BY gas.maNCC, nhacungcap.tenNCC
                                    ORDER BY soluong DESC
                                    LIMIT 4,999999999
                                ) AS khac
                                ORDER BY soluong DESC");
        return $importBySupplier;
    }

    // import 30 day
    private function importThirtyDay()
    {
        $importThirtyDay = DB::select("SELECT SUM(sonhap.soluong) AS soluong
                                FROM sonhap
                                WHERE sonhap.ngaythang >= CURDATE() - INTERVAL 30 DAY");
        return $importThirtyDay;
    }

    // import year
    private function importYear()
    {
        $importYear = DB::select("SELECT SUM(sonhap.soluong) AS soluong
                                FROM sonhap");
        return $importYear;
    }

    // expense 30 day
    private function expenseThirtyDay()
    {
        $expenseThirtyDay = DB::select("SELECT SUM(sonhap.soluong*gas.dongianhap) AS tongtiennhap
                                        FROM sonhap
                                        JOIN gas ON sonhap.maGAS = gas.id
                                        WHERE sonhap.ngaythang >= CURDATE() - INTERVAL 30 DAY");
        return $expenseThirtyDay;
    }

    // expense year
    private function expenseYear()
    {
        $expenseYear = DB::select("SELECT SUM(sonhap.soluong*gas.dongianhap) AS tongtiennhap
                                        FROM sonhap
                                        JOIN gas ON sonhap.maGAS = gas.id");
        return $expenseYear;
    }

    //show add import
    public function showAddImport()
    {
        return view('admin.addImportStatistics',[
            'gas' => DB::table('gas')->get(),
            'supplier' => DB::table('nhacungcap')->get(),
        ]);
    }

    //show add import
    public function saveImport(Request $request)
    {
        $dateTime = Carbon::createFromFormat('Y-m-d\TH:i', $request->date);

        Import::create([
            'soluong' => $request->quantity,
            'maNV' => $request->maNV,
            'maGAS' => $request->maGAS,
            'maNCC' => $request->maNCC,
            'ngaythang' => $dateTime,
        ]);

        return back()->with('success', 'Thêm vào sổ nhập gas thành công!');
    }
}
