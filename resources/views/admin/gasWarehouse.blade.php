@extends('admin.master')
@section('title')Danh sách gas còn trong kho - Quản lý phân phối khí gas @endsection
@section('content')
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y" style="margin-top: 20px;">
              <div class="row">
                <div class="card">
                  <div class="cardHeader d-flex align-items-center justify-content-between" style="display: flex;">
                    <h5 class="card-header">Danh sách gas còn trong kho</h5>
                    <div style="display: flex;">
                    </div>
                  </div>
                  <div class="table-responsive text-nowrap">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Tên loại gas</th>
                          <th>Nhà cung cấp</th>
                          <th>Đơn giá nhập</th>
                          <th>Đơn giá xuất</th>
                          <th>Số lượng còn</th>
                          <th>Trạng thái</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        @foreach ($arrWarehouse as $key => $item)
                        <tr>
                          <td>{{ $key+1 }}</td>
                          <td><strong>{{ $item->tenGAS }}</strong></td>
                          <td>{{ $item->tenNCC }}</td>
                          <td>{{ number_format($item->dongianhap, 0, ',', ',')}} VNĐ</td>
                          <td>{{ number_format($item->dongia, 0, ',', ',')}} VNĐ</td>
                          <td>{{ $item->soluong }} bình</td>
                          @if ($item->soluong >= 100)
                            <td><span class="badge bg-label-success me-1">Đủ hàng</span></td>
                          @elseif($item->soluong < 100 && $item->soluong >= 60)
                          <td><span class="badge bg-label-warning me-1">Sắp hết hàng</span></td>
                          @else
                          <td><span class="badge bg-label-danger me-1">Cần nhập thêm hàng</span></td>
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