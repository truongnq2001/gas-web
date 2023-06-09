@extends('admin.master')
@section('title') Viết phiếu xuất gas - Quản lý phân phối khí gas @endsection
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
        <h5 class="mb-0">Phiếu xuất gas</h5>
      </div>
      <div class="card-body">
        <form id="formAuthentication" class="mb-3" action="{{ route('saveExport') }}" method="post">
          @csrf
          <input type="text" value="{{ Auth::user()->id }}" name="maNV" hidden>
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">Tên loại gas</label>
            <select class="form-select" id="selectGas" aria-label="Default select example" name="maGAS">
              <option selected="">Chọn một tên loại gas</option>
              @foreach ($gas as $item)
              <option value="{{ $item->id }}">{{ $item->tenGAS }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-company">Đại lý</label>
            <select class="form-select" id="selectCustomer" aria-label="Default select example" name="maDL">
              <option selected="">Chọn một đại lý</option>
              @foreach ($customer as $item)
                <option value="{{ $item->id }}">{{ $item->ten }}</option>
              @endforeach
            </select>
          </div>
                
          <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Số lượng</label>
            <input class="form-control" name="quantity" type="number" value="20" id="html5-number-input" style="width: 200px;">
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-message">Ngày nhập gas</label>
            <input class="form-control" type="datetime-local" name="date" value="2023-06-07T10:30:00" id="html5-datetime-local-input" style="width: 300px;">
          </div>
          <button type="submit" class="btn btn-primary">Lưu vào sổ xuất</button>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection