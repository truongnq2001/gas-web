@extends('admin.master')
@section('title') Thống kê nhập gas - Quản lý phân phối khí gas @endsection
@section('content')
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y" style="margin-top: 30px;">
              <div class="row" style="margin-bottom: 30px;">
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <span class="badge bg-label-primary p-2"><i class="bx bx-gas-pump text-primary"></i></span>
                        </div>
                        <div class="dropdown">
                        </div>
                      </div>
                      <span class="fw-semibold d-block mb-1">Số gas nhập trong 30 ngày qua</span>
                      <h3 class="card-title mb-2" style="font-size: 20px;">{{ $importThirtyDay }} bình</h3>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <span class="badge bg-label-success p-2"><i class="bx bx-dollar text-success"></i></span>
                        </div>
                        <div class="dropdown">
                        </div>
                      </div>
                      <span class="fw-semibold d-block mb-1">Số tiền nhập gas trong 30 ngày</span>
                      <h3 class="card-title text-nowrap mb-1" style="font-size: 20px;">{{ $expenseThirtyDay }} VNĐ</h3>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <span class="badge bg-label-info p-2"><i class="bx bx-gas-pump text-info"></i></span>
                        </div>
                        <div class="dropdown">
                        </div>
                      </div>
                      <span class="fw-semibold d-block mb-1">Số gas nhập trong năm 2023</span>
                      <h3 class="card-title mb-2" style="font-size: 20px;">{{ $importYear }} bình</h3>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <span class="badge bg-label-danger p-2"><i class="bx bx-dollar text-danger"></i></span>
                        </div>
                        <div class="dropdown">
                        </div>
                      </div>
                      <span class="fw-semibold d-block mb-1">Số tiền nhập gas trong năm 2023</span>
                      <h3 class="card-title text-nowrap mb-2" style="font-size: 20px;">{{ $expenseYear }} VNĐ</h3>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-8 mb-4 order-0">
                  <div class="card">
                    <h5 class="card-header"> Số gas nhập trong năm 2023 (đơn vị tính: bình)</h5>
                    <div class="card-body">
                        <div id="capital"></div>
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
                    Morris.Area({
                    element: 'capital',
                    behaveLikeLine: true,
                    data: [
                        @foreach ($arrImportMonth as $item)
                          { x: '2023-0{{ $item->thang }}', y: {{ $item->soluong }} },
                        @endforeach
                    ],
                    xkey: 'x',
                    ykeys: ['y'],
                    labels: ['Số gas nhập'],
                    lineColors: ['#696cff'],
                });
            
                </script>
                <div class="col-lg-4 col-md-4 order-1">
                  <div class="card">
                    <h5 class="card-header">Số gas nhập theo loại gas năm 2023</h5>
                    <div class="card-body">
                        <div id="morris_donut"></div>
                    </div>
                </div>
                </div>
                <script>
                 if ($('#morris_donut').length) {
                    Morris.Donut({
                        element: 'morris_donut',
                        data: [
                            @foreach ($importByGas as $item)
                            { value: {{ (int)($item->soluong/$importYear*100) }}, label: '{{ $item->tenGAS }}' },
                            @endforeach
                        ],
                    
                        labelColor: '#2e2f39',
                          gridTextSize: '14px',
                        colors: [
                            "#5969ff",
                                        "#ff407b",
                                        "#25d5f2",
                                        "#ffc750"
                                      
                        ],

                        formatter: function(x) { return x + "%" },
                          resize: true
                    });
                }

                </script>
                <style>
                  #morris_donut tspan {
                      font-size: 6px!important;
                      font-family: 'Public Sans';
                      color: #566a7f !important;
                  }
                  #morris_donut svg text {
                      font-size: 6px!important;
                      font-family: 'Public Sans';
                      color: #566a7f !important;
                  }
                </style>
                <!-- Total Revenue -->
                <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
        
                </div>
                <!--/ Total Revenue -->
                <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                  <div class="row">
                    <div class="col-6 mb-4">
                      
                    </div>
                    <div class="col-6 mb-4">
                      
                    </div>
                     </div> 
                </div> 
              </div> 

                <div class="row" style="margin-top: 20px;">
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" style="margin-bottom: 25px;">
                    <div class="card h-100">
                      <div class="card-title mb-0" style="margin: 25px 0px 0px 25px;">
                          <h5 class="m-0 me-2">Số gas nhập theo nhà cung cấp trong năm 2023</h5>
                      </div>
                      <div class="card-body">
                          <div id="account" ></div>
                      </div>
                  </div>
                  </div>
                  <script>
                    var chart = c3.generate({
                        bindto: "#account",
                        color: { pattern: ["#8592a3", "#696cff", "#71dd37", "#ff3e1d", "#25d5f2"] },
                        data: {
                            // iris data from R
                            columns: [
                                @foreach ($importBySupplier as $item)
                                ['{{ $item->tenNCC }}', {{ $item->soluong }}],
                                @endforeach    
                            ],
                            type: 'pie',
                            
                        }
                    });
                    </script>
                    <style>
                    .c3 text{
                        font-family: 'Public Sans';
                    }
                    </style>
                 
    
                  <div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                          <h5 class="card-title m-0 me-2">Số gas nhập nhiều nhất theo nhà cung cấp</h5>
                          <div class="dropdown">
                            <div class="btn-group">
                                <button id="btnShow" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                  30 ngày qua
                                </button>
                                <ul class="dropdown-menu" style="">
                                  <li style="cursor: pointer;"><a class="dropdown-item" onclick="changeBtn('30 ngày qua')">30 ngày qua</a></li>
                                  <li style="cursor: pointer;"><a class="dropdown-item" onclick="changeBtn('Trong năm nay')">Trong năm nay</a></li>
                                </ul>
                              </div>
                          </div>
                        </div>
                        <div class="card-body" id="importSupplier">
                          @include('admin.import.topImportSupplier')
                        </div>
                      </div>
                  </div>
    
                </div>

                <script>
                  function changeBtn(text){
                      $('#btnShow').html(text);

                      if (text == '30 ngày qua') {
                        type = '30';
                      }else if(text == 'Trong năm nay'){
                        type = 'year';
                      }

                      $.ajax({
                          url: "/import/supplier",
                          type: "POST",
                          data: {
                              "_token": "{{ csrf_token() }}",
                              "type": type,
                          },
                          success: function(response){
                              if(response.status === "success"){
                                  $('#importSupplier').html(response.html);
                              }
                          },
                          error: function(response){
                              if (response.status === 'error') {
                                  // alert(response.message)
                              }
                          }, 
                      });    
                  }
                </script>

                <div class="row" style="margin-top: 30px;">
                  <div class="card">
                    <div class="cardHeader d-flex align-items-center justify-content-between" style="display: flex;">
                      <h5 class="card-header">Danh sách những lần nhập gas</h5>
                      
                    </div>
                    <div class="table-responsive text-nowrap">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Tên loại gas</th>
                            <th>Nhà cung cấp</th>
                            <th>Số lượng</th>
                            <th>Đơn giá nhập</th>
                            <th>Tổng tiền</th>
                            <th>Ngày nhập gas</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                          @foreach ($arrImport as $key => $item)
                          <tr>
                            <td>{{ $key+1 }}</td>
                            <td><strong>{{ $item->tenGAS }}</strong></td>
                            <td>{{ $item->tenNCC }}</td>
                            <td>{{ $item->soluong }} bình</td>
                            <td>{{ number_format($item->dongianhap, 0, ',', ',')}} VNĐ</td>
                            <td>{{ number_format($item->dongianhap*$item->soluong, 0, ',', ',')}} VNĐ</td>
                            <td>{{ $item->ngaythang }}</td>
                          </tr>
                          @endforeach
  
                        </tbody>
                      </table>
                    </div>
                    
                  </div>
                </div>
            
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