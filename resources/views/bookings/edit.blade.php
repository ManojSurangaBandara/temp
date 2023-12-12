@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Bungalow</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                  <li class="breadcrumb-item ">Bungalow Management</li>
                  <li class="breadcrumb-item active">Update</li>
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
                            <h3 class="card-title">Bungalow</h3>
                            {{-- <div class="card-tools">
                                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                            </div> --}}
                        </div>

                        <form role="form" action="{{ route('bungalows.update',$bungalow->id) }}" method="post"
                              enctype="multipart/form-data">
                              @csrf
                              @method('PUT')

                            <div class="card-body">                                

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('name')
                                        is-invalid @enderror" name="name" value="{{ $bungalow->name }}" id="name" autocomplete="off">
                                        <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="no_ac_room" class="col-sm-2 col-form-label">No. AC Rooms</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control @error('no_ac_room')
                                        is-invalid @enderror" name="no_ac_room" value="{{ $bungalow->no_ac_room }}" id="no_ac_room" autocomplete="off"
                                        min="0">
                                        <span class="text-danger">@error('no_ac_room') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="no_none_ac_room" class="col-sm-2 col-form-label">No. None AC Rooms</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control @error('no_none_ac_room')
                                        is-invalid @enderror" name="no_none_ac_room" value="{{ $bungalow->no_none_ac_room }}" id="no_none_ac_room" autocomplete="off"
                                        min="0">
                                        <span class="text-danger">@error('no_none_ac_room') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="no_guest" class="col-sm-2 col-form-label">No. Guest</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control @error('no_guest')
                                        is-invalid @enderror" name="no_guest" value="{{ $bungalow->no_guest }}" id="no_guest" autocomplete="off"
                                        min="0">
                                        <span class="text-danger">@error('no_guest') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="serving_price" class="col-sm-2 col-form-label">Serving Price</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control @error('serving_price')
                                        is-invalid @enderror" name="serving_price" value="{{ $bungalow->serving_price }}" id="serving_price" autocomplete="off"
                                        min="0">
                                        <span class="text-danger">@error('serving_price') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="retired_price" class="col-sm-2 col-form-label">Retired Price</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control @error('retired_price')
                                        is-invalid @enderror" name="retired_price" value="{{ $bungalow->retired_price }}" id="retired_price" autocomplete="off"
                                        min="0">
                                        <span class="text-danger">@error('retired_price') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="official_price" class="col-sm-2 col-form-label">Official Price</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control @error('official_price')
                                        is-invalid @enderror" name="official_price" value="{{ $bungalow->official_price }}" id="official_price" autocomplete="off"
                                        min="0">
                                        <span class="text-danger">@error('official_price') {{ $message }} @enderror</span>
                                    </div>
                                </div>                                

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" for="ranks">Ranks</label>
                                    <div class="col-sm-6 select2-purple">
                                        <select name="ranks[]" id="ranks" class="multiple form-control" multiple required>
                                            @foreach($ranks as $item)
                                                <option value="{{ $item->id }}" @if(in_array($item->name, $bungalow_rank)) selected @endif>
                                                    {{ $item->name}}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('ranks')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
