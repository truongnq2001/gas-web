@extends('admin.master')
@section('title') Thống kê thanh toán - Quản lý phân phối khí gas @endsection
@section('content')
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y" style="margin-top: 20px;">
              <div class="row">
                <div class="card">
                  <div class="cardHeader d-flex align-items-center justify-content-between" style="display: flex;">
                    <h5 class="card-header">Danh sách thanh toán</h5>
                    <div style="display: flex;">
                      <?php
                        function getUrlExcept($param){
                            $currentUrl = url()->current(); // Lấy URL hiện tại
                            $queryParams = request()->except([$param]); // Lấy tất cả các tham số trên URL trừ tham số $param
                            $newUrl = url($currentUrl) . '?' . http_build_query($queryParams); // Tạo URL mới từ URL hiện tại và các tham số lấy được
                            return $newUrl;
                        }
                      ?>
                      @if (request()->input('time') == 'latest' || request()->input('time') == '') 
                      <select id="selectCheck" class="form-select color-dropdown" style="width: 200px; margin-right: 20px;">
                        <option value="{{ route('payment') }}?time=latest&check=all" @if (request()->input('check') == 'all') selected @endif>Tất cả</option>
                        <option value="{{ route('payment') }}?time=latest&check=paid" @if (request()->input('check') == 'paid') selected @endif>Đã thanh toán</option>
                        <option value="{{ route('payment') }}?time=latest&check=unpaid" @if (request()->input('check') == 'unpaid') selected @endif>Chưa thanh toán</option>
                      </select>
                      @else 
                      <select id="selectCheck" class="form-select color-dropdown" style="width: 200px; margin-right: 20px;">
                        <option value="{{ route('payment') }}?time=oldest&check=all" @if (request()->input('check') == 'all') selected @endif>Tất cả</option>
                        <option value="{{ route('payment') }}?time=oldest&check=paid" @if (request()->input('check') == 'paid') selected @endif>Đã thanh toán</option>
                        <option value="{{ route('payment') }}?time=oldest&check=unpaid" @if (request()->input('check') == 'unpaid') selected @endif>Chưa thanh toán</option>
                      </select>
                      @endif
                      <select id="selectTime" class="form-select color-dropdown" style="width: 150px; margin-right: 20px;">
                        <option value="{{ route('payment') }}?time=latest" @if (request()->input('time') == 'latest') selected @endif>Mới nhất</option>
                        <option value="{{ route('payment') }}?time=oldest" @if (request()->input('time') == 'oldest') selected @endif>Cũ nhất</option>
                      </select>
                    </div>
                    <script>
                      $('#selectTime').change(function() {
                        var selectedValue = $(this).val();

                        window.location.href = selectedValue;
                      });
                      $('#selectCheck').change(function() {
                        var selectedValue = $(this).val();

                        window.location.href = selectedValue;
                      });
                    </script>
                  </div>
                  <div class="table-responsive text-nowrap">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Tên đại lý</th>
                          <th>Loại gas</th>
                          <th>Đơn giá</th>
                          <th>Số lượng</th>
                          <th>Tổng tiền</th>
                          <th>Ngày thanh toán</th>
                          <th>Trạng thái</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        @foreach ($arrPayment as $key => $item)
                        <tr>
                          <td>{{ $key+1 }}</td>
                          <td><strong>{{ $item->ten }}</strong></td>
                          <td>{{ $item->tenGAS }}</td>
                          <td>{{ number_format($item->dongia, 0, ',', ',')}} VNĐ</td>
                          <td>{{ $item->soluong }} bình</td>
                          <td>{{ number_format($item->soluong*$item->dongia, 0, ',', ',')}} VNĐ</td>
                          @if (isset($item->ngaythang) && $item->ngaythang != null)
                            <td>{{ $item->ngaythang }}</td>
                          @else
                            <td></td>
                          @endif
                          @if (isset($item->ngaythang) && $item->dathanhtoan != null)
                            <td><span class="badge bg-label-success me-1">Đã thanh toán</span></td>
                          @else
                          <td><span class="badge bg-label-warning me-1">Chưa thanh toán</span></td>
                          @endif
                        </tr>
                        @endforeach
                       
                      </tbody>
                    </table>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
                     
    <!-- / Layout wrapper -->    
@endsection