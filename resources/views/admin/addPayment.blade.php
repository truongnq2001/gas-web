@extends('admin.master')
@section('title') Viết phiếu thanh toán - Quản lý phân phối khí gas @endsection
@section('content')

<div class="row" style="padding: 1.625rem !important;">

  <div class="col-lg">
    @if(session('success'))
          <div class="alert alert-success" role="alert">
              {{ session('success') }}
          </div>
      @endif
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Phiếu thanh toán</h5>
      </div>
      <div class="card-body">
        <form id="formAuthentication" class="mb-3" action="{{ route('savePayment') }}" method="post">
          @csrf
          <input type="text" value="{{ Auth::user()->id }}" name="maNV" hidden>
          <div class="mb-3">
            <label class="form-label" for="basic-default-company">Sổ xuất</label>
            <select class="form-select" id="selectExport" aria-label="Default select example" name="maSX">
              <option selected="">Chọn một lần xuất gas</option>
              @foreach ($payment as $item)
                <option value="{{ $item->id }}" data-customer="{{ $item->ten }}" data-gas="{{ $item->tenGAS }}" data-quantity="{{ $item->soluong }}" data-price="{{ $item->dongia }}" data-total="{{ $item->tongtien }}">Tên: {{ $item->ten }}, Số lượng: {{ $item->soluong }}, Loại gas: {{ $item->tenGAS }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label" for="basic-default-email">Tên đại lý</label>
            <div class="input-group input-group-merge">
              <input type="text" id="basic-default-email" class="form-control inputCustomer" placeholder="Tên đại lý" aria-label="john.doe" aria-describedby="basic-default-email2" disabled>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label" for="basic-default-email">Tên loại gas</label>
            <div class="input-group input-group-merge">
                <input type="text" id="basic-default-email" class="form-control inputGas" placeholder="Tên loại gas" aria-label="john.doe" aria-describedby="basic-default-email2" disabled>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label" for="basic-default-email">Số lượng</label>
            <div class="input-group input-group-merge">
                <input type="text" id="basic-default-email" class="form-control inputQuantity" placeholder="Số lượng" aria-label="john.doe" aria-describedby="basic-default-email2" disabled>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label" for="basic-default-email">Đơn giá</label>
            <div class="input-group input-group-merge">
                <input type="text" id="basic-default-email" class="form-control inputPrice" placeholder="Đơn giá" aria-label="john.doe" aria-describedby="basic-default-email2" disabled>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label" for="basic-default-email">Tổng tiền</label>
            <div class="input-group input-group-merge">
                <input type="text" id="basic-default-email" class="form-control inputTotal" placeholder="Tổng tiền" aria-label="john.doe" aria-describedby="basic-default-email2" disabled>
            </div>
          </div>

          <script>
            $('#selectExport').change(function() {
              var selectedCustomer = $(this).children('option:selected').data('customer');              
              $('.inputCustomer').val(selectedCustomer);

              var selectedGas = $(this).children('option:selected').data('gas');              
              $('.inputGas').val(selectedGas);

              var selectedQuantity = $(this).children('option:selected').data('quantity');              
              $('.inputQuantity').val(selectedQuantity);

              var selectedPrice = $(this).children('option:selected').data('price') + ' VNĐ';              
              $('.inputPrice').val(selectedPrice);

              var selectedTotal = $(this).children('option:selected').data('total') + ' VNĐ';              
              $('.inputTotal').val(selectedTotal);
            });
          </script>
                
          <div class="mb-3">
            <label class="form-label" for="basic-default-message">Ngày thanh toán</label>
            <input class="form-control" type="datetime-local" name="date" value="2023-06-07T10:30:00" id="html5-datetime-local-input" style="width: 300px;">
          </div>
          <button type="submit" class="btn btn-primary">Lưu vào sổ thanh toán</button>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection