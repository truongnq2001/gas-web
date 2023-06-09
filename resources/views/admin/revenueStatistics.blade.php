@extends('admin.master')
@section('title') Thống kê doanh thu - Quản lý phân phối khí gas @endsection
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
                          <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                        </div>
                        <div class="dropdown">
                        </div>
                      </div>
                      <span class="fw-semibold d-block mb-1">Doanh thu 30 ngày qua</span>
                      <h3 class="card-title mb-2" style="font-size: 20px;">{{ $revenueThirtyDay }} VNĐ</h3>
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
                      <span class="fw-semibold d-block mb-1">Lợi nhuận 30 ngày qua</span>
                      <h3 class="card-title text-nowrap mb-1" style="font-size: 20px;">{{ $profitThiryDay }} VNĐ</h3>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <span class="badge bg-label-info p-2"><i class="bx bx-dollar text-info"></i></span>
                        </div>
                        <div class="dropdown">
                        </div>
                      </div>
                      <span class="fw-semibold d-block mb-1">Doanh thu trong năm 2023</span>
                      <h3 class="card-title mb-2" style="font-size: 20px;">{{ $revenueYear }} VNĐ</h3>
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
                      <span class="fw-semibold d-block mb-1">Lợi nhuận trong năm 2023</span>
                      <h3 class="card-title text-nowrap mb-2" style="font-size: 20px;">{{ $profitYear }} VNĐ</h3>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-8 mb-4 order-0">
                  <div class="card">
                    <h5 class="card-header"> Doanh thu trong năm 2023 (đơn vị tính: VNĐ)</h5>
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
                          @foreach ($revenueArr as $item)
                              { x: '2023-0{{ $item->thang }}', y: {{ $item->doanhthu }} },
                          @endforeach
                    ],
                    xkey: 'x',
                    ykeys: ['y'],
                    labels: ['Doanh thu'],
                    lineColors: ['#ff407b'],
                });
            
                </script>
                <div class="col-lg-4 col-md-4 order-1">
                    <div class="card h-100">
                        <div class="card-title mb-0" style="margin: 25px 0px 0px 25px;">
                            <h5 class="m-0 me-2">Doanh thu theo khách hàng năm 2023</h5>
                        </div>
                        <div class="card-body">
                            <div id="account" ></div>
                        </div>
                    </div>
                </div>
                <script>
                var chart = c3.generate({
                    bindto: "#account",
                    color: { pattern: ["#5969ff", "#ff407b", "#25d5f2", "#71dd37"] },
                    data: {
                        // iris data from R
                        columns: [
                          @foreach ($revenueCustomerArr as $item)
                              ['{{ $item->khachhang }}', {{ $item->doanhthu }}],
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
    <div class="row">
                    <div class="col-12 mb-4">
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" style="    margin-bottom: 50px;">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Doanh thu theo loại gas trong năm 2023</h5>
                        <div class="card-body">
                            <div id="c3chart_gas"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Doanh thu theo tháng trong năm 2023</h5>
                        <div class="card-body">
                            <div id="morris_bar"></div>
                        </div>
                    </div>
                </div>
                <script>
                    if ($('#morris_bar').length) {
                        Morris.Bar({
                            element: 'morris_bar',
                            data: [
                              @foreach ($revenueArr as $item)
                                  { x: '2023-0{{ $item->thang }}', y: {{ $item->doanhthu }} },
                              @endforeach
                            ],
                            xkey: 'x',
                            ykeys: ['y'],
                            labels: ['Doanh thu'],
                            barColors: ['#696cff'],
                                resize: true,
                                    gridTextSize: '14px'

                        });
                    }
                    if ($('#c3chart_gas').length) {
                      var chart = c3.generate({
                          bindto: "#c3chart_gas",
                          data: {
                              columns: [
                                @foreach ($revenueByGas as $item)
                                    ['{{ $item->tenGAS }}', {{ $item->doanhthu }}],
                                @endforeach
                              ],
                              type: 'donut',
                              onclick: function(d, i) { console.log("onclick", d, i); },
                              onmouseover: function(d, i) { console.log("onmouseover", d, i); },
                              onmouseout: function(d, i) { console.log("onmouseout", d, i); },

                              colors: {
                                  '{{ $revenueByGas[0]->tenGAS }}': '#5969ff',
                                  '{{ $revenueByGas[1]->tenGAS }}': '#ff407b',
                                  '{{ $revenueByGas[2]->tenGAS }}': '#03c3ec',
                                  '{{ $revenueByGas[3]->tenGAS }}': '#71dd37',
                              }
                          },
                          donut: {
                              title: "Loại gas"


                          }


                      })};
                </script>
              </div>
              <div class="row">
                <!-- Order Statistics -->
                <div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                          <h5 class="card-title m-0 me-2">Top doanh thu theo khách hàng</h5>
                          <div class="dropdown">
                            <div class="btn-group">
                                <button id="btnShowCustomer" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                  30 ngày qua
                                </button>
                                <ul class="dropdown-menu" style="">
                                  <li style="cursor: pointer;"><a class="dropdown-item" onclick="changeBtnCustomer('30 ngày qua')">30 ngày qua</a></li>
                                  <li style="cursor: pointer;"><a class="dropdown-item" onclick="changeBtnCustomer('Từ đầu năm đến bây giờ')">Từ đầu năm đến bây giờ</a></li>
                                </ul>
                              </div>
                          </div>
                        </div>
                        <div class="card-body" id="revenueCustomer">
                          @include('admin.revenue.topRevenueCustomer')
                        </div>
                      </div>
                      <script>
                        function changeBtnCustomer(text){
                            $('#btnShowCustomer').html(text);

                            if (text == '30 ngày qua') {
                              type = '30';
                            }else if(text == 'Từ đầu năm đến bây giờ'){
                              type = 'year';
                            }

                            $.ajax({
                                url: "/revenue/customer",
                                type: "POST",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "type": type,
                                },
                                success: function(response){
                                    if(response.status === "success"){
                                        $('#revenueCustomer').html(response.html);
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
                </div>
                <!--/ Order Statistics -->

                <!-- Expense Overview -->
                
                <!--/ Expense Overview -->

                <!-- Transactions -->
                <div class="col-md-6 col-lg-6 order-2 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                          <h5 class="card-title m-0 me-2">Top doanh thu theo loại gas</h5>
                          <div class="dropdown">
                            <div class="btn-group">
                                <button id="btnShowGas" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                  30 ngày qua
                                </button>
                                <ul class="dropdown-menu" style="">
                                  <li style="cursor: pointer;"><a class="dropdown-item" onclick="changeBtnGas('30 ngày qua')">30 ngày qua</a></li>
                                  <li style="cursor: pointer;"><a class="dropdown-item" onclick="changeBtnGas('Từ đầu năm đến bây giờ')">Từ đầu năm đến bây giờ</a></li>
                                </ul>
                              </div>
                          </div>
                        </div>
                        <div class="card-body" id="revenueGas">
                          @include('admin.revenue.topRevenueGas')
                        </div>
                      </div>
                      <script>
                        function changeBtnGas(text){
                            $('#btnShowGas').html(text);

                            if (text == '30 ngày qua') {
                              type = '30';
                            }else if(text == 'Từ đầu năm đến bây giờ'){
                              type = 'year';
                            }

                            $.ajax({
                                url: "/revenue/gas",
                                type: "POST",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "type": type,
                                },
                                success: function(response){
                                    if(response.status === "success"){
                                        $('#revenueGas').html(response.html);
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
                </div>
                <!--/ Transactions -->
              </div>
            </div>
            <script>
              "use strict";
              Morris.Donut({
                element: 'morris_gross',

                data: [
                    { value: 80, label: 'Chi phí' },
                    { value: 20, label: 'Lãi' }
                   
                ],
             
                labelColor: '#5969ff',

                colors: [
                    '#5969ff',
                    '#a8b0ff'
                   
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