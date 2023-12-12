@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Booking</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                  <li class="breadcrumb-item ">Booking Management</li>
                  <li class="breadcrumb-item active">Refund</li>
                </ol>
            </div>
          </div>
    </section>
  </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-cyan">
                        <div class="card-header">
                            <h3 class="card-title">Booking</h3>
                            {{-- <div class="card-tools">
                                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                            </div> --}}
                        </div>

                        <form role="form" action="{{ route('bookings.refund_booking',$booking->id) }}" method="post"
                              enctype="multipart/form-data">
                              @csrf
                              @method('PUT')

                            <div class="card-body">            

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" for="bank_id">Bank</label>
                                    <div class="col-sm-6 select2-purple">
                                        <select name="bank_id" id="bank_id" class="form-control" required>
                                            @foreach($banks as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name}}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('bank_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="branch" class="col-sm-2 col-form-label">Branch</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('branch')
                                        is-invalid @enderror" name="branch" value="{{ old('branch') }}" id="branch" autocomplete="off" required>
                                        <span class="text-danger">@error('branch') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="acc_no" class="col-sm-2 col-form-label">Acc no</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('acc_no')
                                        is-invalid @enderror" name="acc_no" value="{{ old('acc_no') }}" id="acc_no" autocomplete="off" required>
                                        <span class="text-danger">@error('acc_no') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="acc_owner" class="col-sm-2 col-form-label">Acc owner</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('acc_owner')
                                        is-invalid @enderror" name="acc_owner" value="{{ old('acc_owner') }}" id="acc_owner" autocomplete="off" required>
                                        <span class="text-danger">@error('acc_owner') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="deposit_date" class="col-sm-2 col-form-label">Deposit Date</label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control @error('deposit_date')
                                        is-invalid @enderror" name="deposit_date" value="{{ old('deposit_date') }}" id="deposit_date" autocomplete="off" required>
                                        <span class="text-danger">@error('deposit_date') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="cheque_no" class="col-sm-2 col-form-label">Cheque No.</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('cheque_no')
                                        is-invalid @enderror" name="cheque_no" value="{{ old('cheque_no') }}" id="cheque_no" autocomplete="off" required>
                                        <span class="text-danger">@error('cheque_no') {{ $message }} @enderror</span>
                                    </div>
                                </div>
    
                                <div class="form-group row ">
                                    <label for="filepath" class="col-sm-2 col-form-label">Select Image<sup class="text-red">*</sup></label>
                                    <div class="col-sm-6">
                                        <input type="file" class="form-control @error('filepath') is-invalid @enderror" 
                                        name="filepath" value="{{ old('filepath') }}" required accept=".jpeg,.png,.jpg" required>
                                        <span class="text-danger">@error('filepath') {{ $message }}
                                        @enderror</span>
                                    </div>
                                </div>

                                </div>
                                <div class="card-footer">
                                    <a href="{{ url()->previous() }}" class="btn btn-sm bg-info"><i class="fa fa-arrow-circle-left"></i> Back</a>
                                        <button type="reset" class="btn btn-sm btn-secondary">Cancel</button>
                                        <button type="submit" class="btn btn-sm btn-success" >Update</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
        </div>
@endsection

@section('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
@endsection

@section('third_party_scripts')
    {{-- <script src="{{ asset('plugins/jquery/jquery.min.js') }}" ></script> --}}
    <script src="{{asset('plugins/select2/js/select2.js')}}" defer></script>
    <script>
        $(document).ready(function() {
            $('.multiple').select2();
        });
    </script>
@endsection
