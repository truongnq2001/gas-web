@extends('admin.master')
@section('title') Dashboard - Quản lý phân phối khí gas @endsection
@section('content')
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y" style="margin-top: 30px;">
              <div class="row">
                <div class="col-lg-4 col-md-4 order-1">
                  <div class="row">
                    <h4>Thống kê 30 ngày qua</h4>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body box-review">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                              {{-- <img
                                src="../assets/img/icons/unicons/chart-success.png"
                                alt="chart success"
                                class="rounded"
                              /> --}}
                            </div>
                            <div class="dropdown">
                            </div>
                          </div>
                          <span class="fw-semibold d-block mb-1">Doanh thu</span>
                          <h3 class="card-title mb-2" style="font-size: 20px;">{{ $revenueThirtyDay }} VNĐ</h3>
                          @if ($percentRevenue > 0)
                          <small class="text-success fw-semibold">
                            <i class="bx bx-up-arrow-alt"></i> +{{ $percentRevenue }}%
                          </small>
                          @else
                          <small class="text-danger fw-semibold">
                            <i class="bx bx-up-arrow-alt"></i> +{{ $percentRevenue }}%
                          </small>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body box-review">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="../assets/img/icons/unicons/wallet-info.png"
                                alt="Credit Card"
                                class="rounded"
                              />
                            </div>
                            <div class="dropdown">
                            </div>
                          </div>
                          <span class="fw-semibold d-block mb-1">Chi phí</span>
                          <h3 class="card-title text-nowrap mb-1" style="font-size: 20px;">{{ $expenseThiryDay }} VNĐ</h3>
                          @if ($percentExpense > 0)
                          <small class="text-success fw-semibold">
                            <i class="bx bx-up-arrow-alt"></i> +{{ $percentExpense }}%
                          </small>
                          @else
                          <small class="text-danger fw-semibold">
                            <i class="bx bx-up-arrow-alt"></i> +{{ $percentExpense }}%
                          </small>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-4">
                      <div class="card">
                        <div class="card-body box-review">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img src="../assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded" />
                            </div>
                            <div class="dropdown">
                            </div>
                          </div>
                          <span class="fw-semibold d-block mb-1">Số gas đã xuất</span>
                          <h3 class="card-title mb-2" style="font-size: 20px;">{{ $exportThiryDay }} bình</h3>
                          @if ($percentExport > 0)
                            <small class="text-success fw-semibold">
                              <i class="bx bx-up-arrow-alt"></i> +{{ $percentExport }}%
                            </small>
                            @else
                            <small class="text-danger fw-semibold">
                              <i class="bx bx-up-arrow-alt"></i> +{{ $percentExport }}%
                            </small>
                            @endif
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-4">
                      <div class="card">
                        <div class="card-body box-review">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img src="../assets/img/icons/unicons/cc-success.png" alt="User" class="rounded" />
                            </div>
                            <div class="dropdown">
                            </div>
                          </div>
                          <span class="fw-semibold d-block mb-1">Lợi nhuận</span>
                          <h3 class="card-title text-nowrap mb-2" style="font-size: 20px;">{{ $profitThiryDay }} VNĐ</h3>
                            @if ($percentProfit > 0)
                            <small class="text-success fw-semibold">
                              <i class="bx bx-up-arrow-alt"></i> +{{ $percentProfit }}%
                            </small>
                            @else
                            <small class="text-danger fw-semibold">
                              <i class="bx bx-up-arrow-alt"></i> +{{ $percentProfit }}%
                            </small>
                            @endif
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <style>
                .box-review{
                  padding: 1rem 1rem !important;
                }
                </style>
                <!-- Total Revenue -->
              
                <!--/ Total Revenue -->
                <div class="col-12 col-md-8 col-lg-8 order-3 order-md-2">
                  
                <div class="col-lg-12 mb-4 order-0">
                  <div class="card">
                    <h5 class="card-header"> Biểu đồ cột doanh thu năm 2023 (đơn vị tính: VNĐ)</h5>
                    <div class="card-body">
                      <div id="goodservice"></div>
                    </div>
                  </div>
                </div>
                <style>
                  .c3 svg{
                    font-family: "Public Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif !important;
                  }
                </style>
                <script>
                    "use strict";
                    var a = c3.generate({
                      bindto: "#goodservice",
                      size: { height: 350 },
                      color: { pattern: ["#5969ff", "#ff407b"] },
                      data: {
                          columns: [
                              ["Doanh thu", <?php  foreach ($revenueArr as $item) {
                                                      echo $item->doanhthu.', ';
                                                    } ?>],
                              ["Trung bình", <?php for ($i=0; $i <count($revenueArr) ; $i++) { 
                                                      echo $averageRevenue.', ';
                                                  } ?>]
                          ],
                          types: { "Doanh thu": "bar" },

                      },
                      bar: {

                          width: 45

                      },
                      legend: {
                          show: true
                      },
                      axis: {
                          x: {
                              type: "category",
                              categories: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6"]
                          },
                          y: {
                              tick: {
                                  format: function (value) {
                                      if (typeof value === 'number') {
                                          var str = value.toString();
                                          if (str.length >= 4 && str.slice(-3) === '000') {
                                              return d3.format(",")(value);
                                          }
                                      }
                                      return value;
                                  }
                              }
                          }

                      },

                  });
                </script>
                <style>
                .c3 text{
                  font-family: 'Public Sans';
                }
                </style>
            
                <div class="row">
                    <div class="col-12 mb-4">
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <!-- Order Statistics -->
                <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                      <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Top 6 loại gas đã xuất nhiều nhất trong 30 ngày qua</h5>
                        {{-- <small class="text-muted">42.82k Total Sales</small> --}}
                      </div>
                    </div>
                    <br>
                    <div class="card-body">
                      
                      <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"
                              ><i class='bx bx-gas-pump' ></i></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">{{ $arrayGasExport[0]->tenGAS }}</h6>
                              <small class="text-muted">{{ $arrayGasExport[0]->tenNCC }}</small>
                            </div>
                            <div class="user-progress">
                              <small class="fw-semibold">{{ $arrayGasExport[0]->soluong }} bình</small>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-success"><i class='bx bx-gas-pump' ></i></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">{{ $arrayGasExport[1]->tenGAS }}</h6>
                              <small class="text-muted">{{ $arrayGasExport[1]->tenNCC }}</small>
                            </div>
                            <div class="user-progress">
                              <small class="fw-semibold">{{ $arrayGasExport[1]->soluong }} bình</small>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-warning"><i class='bx bx-gas-pump' ></i></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">{{ $arrayGasExport[2]->tenGAS }}</h6>
                              <small class="text-muted">{{ $arrayGasExport[2]->tenNCC }}</small>
                            </div>
                            <div class="user-progress">
                              <small class="fw-semibold">{{ $arrayGasExport[2]->soluong }} bình</small>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-danger"><i class='bx bx-gas-pump' ></i></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">{{ $arrayGasExport[3]->tenGAS }}</h6>
                              <small class="text-muted">{{ $arrayGasExport[3]->tenNCC }}</small>
                            </div>
                            <div class="user-progress">
                              <small class="fw-semibold">{{ $arrayGasExport[3]->soluong }} bình</small>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-info"><i class='bx bx-gas-pump' ></i></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">{{ $arrayGasExport[4]->tenGAS }}</h6>
                              <small class="text-muted">{{ $arrayGasExport[4]->tenNCC }}</small>
                            </div>
                            <div class="user-progress">
                              <small class="fw-semibold">{{ $arrayGasExport[4]->soluong }} bình</small>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-secondary"
                              ><i class='bx bx-gas-pump' ></i></i
                            ></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">{{ $arrayGasExport[5]->tenGAS }}</h6>
                              <small class="text-muted">{{ $arrayGasExport[5]->tenNCC }}</small>
                            </div>
                            <div class="user-progress">
                              <small class="fw-semibold">{{ $arrayGasExport[5]->soluong }} bình</small>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!--/ Order Statistics -->

                <!-- Expense Overview -->
                <div class="col-md-6 col-lg-4 order-2 mb-4">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="card-title m-0 me-2">Tỷ lệ doanh thu 30 ngày qua</h5>
                      
                    </div>
                    <div class="card-body">
                      <div class="card-body">
                        <div id="morris_gross" style="height: 272px;"></div>
                    </div>
                    <div class="card-footer bg-white">
                        <p>Doanh thu <span class="float-right text-dark">{{ number_format($revenueThirtyDayBase, 0, ',', ',')}} VNĐ</span></p>
                        <p>Lợi nhuận<span class="float-right text-dark"> +{{ number_format($profitThiryDayBase, 0, ',', ',')}} VNĐ</span>
                        </p>
                    </div>
                    </div>
                  </div>
                </div>
                <!--/ Expense Overview -->

                <!-- Transactions -->
                <div class="col-md-6 col-lg-4 order-2 mb-4">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="card-title m-0 me-2">Tỷ lệ doanh thu trong năm 2023</h5>
                      
                    </div>
                    <div class="card-body">
                      <div class="card-body">
                        <div id="morris_gross_red" style="height: 272px;"></div>
                    </div>
                    <div class="card-footer bg-white">
                        <p>Doanh thu <span class="float-right text-dark">{{ number_format($revenueYear, 0, ',', ',')}} VNĐ</span></p>
                        <p>Lợi nhuận<span class="float-right text-dark"> +{{ number_format($profitYear, 0, ',', ',')}} VNĐ </span>
                        </p>
                    </div>
                    </div>
                  </div>
                </div>
                <!--/ Transactions -->
              </div>
            </div>
            <script>
              "use strict";
              Morris.Donut({
                element: 'morris_gross',

                data: [
                    { <?php echo"value: ".$percentExpenseRevenue."," ?> label: 'Chi phí' },
                    { <?php echo"value: ".$percentProfitRevenue."," ?> label: 'Lãi' }
                   
                ],
             
                labelColor: '#5969ff',

                colors: [
                    '#5969ff',
                    '#a8b0ff'
                   
                ],

                formatter: function(x) { return x + "%" },
                  resize: true

            });

            Morris.Donut({
                element: 'morris_gross_red',

                data: [
                    { <?php echo"value: ".$percentExpenseYear."," ?> label: 'Chi phí' },
                    { <?php echo"value: ".$percentProfitYear."," ?> label: 'Lãi' }
                   
                ],
             
                labelColor: 'rgb(255, 64, 123)',

                colors: [
                    'rgb(255, 64, 123)',
                    'rgb(255, 213, 225)'
                   
                ],

                formatter: function(x) { return x + "%" },
                  resize: true

            });
            </script>
            <!-- / Content -->

            

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->    
@endsection