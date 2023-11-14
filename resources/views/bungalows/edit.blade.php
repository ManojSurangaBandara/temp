@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Guardiance</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item ">Guardiance Management</li>
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
                            <h3 class="card-title">Guardiance</h3>
                            {{-- <div class="card-tools">
                                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                            </div> --}}
                        </div>

                        <form role="form" action="{{ route('guardiances.update',$guardiance->id) }}" method="post"
                              enctype="multipart/form-data">
                              @csrf
                              @method('PUT')

                            <div class="card-body">

                                <div class="form-group row">
                                    <label for="guardiance_type_id" class="col-sm-2 col-form-label">Type</label>
                                    <div class="col-sm-6">
                                        <select class="form-control @error('guardiance_type_id') is-invalid @enderror"
                                            name="guardiance_type_id" value="{{ old('guardiance_type_id') }}" id="guardiance_type_id" required>
                                            @foreach ($guardiance_types as $item)
                                                <option value="{{ $item->id }}" {{$guardiance->guardiance_type_id == $item->id ? 'selected':''}}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('under_command')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('name')
                                        is-invalid @enderror" name="name" value="{{ $guardiance->user->name }}" id="name" autocomplete="off">
                                        <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('email')
                                        is-invalid @enderror" name="email" value="{{ $guardiance->user->email }}" id="email" autocomplete="off">
                                        <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('username')
                                        is-invalid @enderror" name="username" value="{{ $guardiance->user->username }}" id="username" autocomplete="off">
                                        <span class="text-danger">@error('username') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control @error('password')
                                        is-invalid @enderror" name="password" value="{{ old('password') }}" id="password" autocomplete="off">
                                        <span class="text-danger">@error('password') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="confirm-password" class="col-sm-2 col-form-label">Confirm Password</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control @error('confirm-password')
                                        is-invalid @enderror" name="confirm-password" value="{{ old('confirm-password') }}" id="confirm-password" autocomplete="off">
                                        <span class="text-danger">@error('confirm-password') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="contact" class="col-sm-2 col-form-label">Default Contact</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('contact')
                                        is-invalid @enderror" name="contact" value="{{ $guardiance->user->contact }}" id="contact" autocomplete="off">
                                        <span class="text-danger">@error('contact') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="sec_contact" class="col-sm-2 col-form-label">Contact</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('sec_contact')
                                        is-invalid @enderror" name="sec_contact" value="{{ $guardiance->sec_contact }}" id="sec_contact" autocomplete="off">
                                        <span class="text-danger">@error('sec_contact') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nic" class="col-sm-2 col-form-label">NIC / Passport</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('nic')
                                        is-invalid @enderror" name="nic" value="{{ $guardiance->nic }}" id="nic" autocomplete="off">
                                        <span class="text-danger">@error('nic') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2" for="roles">Role</label>
                                    <div class="col-sm-6 select2-blue">
                                        <select required name="roles[]" id="roles"
                                                class="multiple form-control" multiple>
                                            @foreach($roles as $roleValue => $roleName)
                                                <option value="{{ $roleValue }}" @if(in_array($roleValue, $userRole)) selected @endif>
                                                    {{ $roleName }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('roles')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" for="students">Students</label>
                                    <div class="col-sm-6 select2-purple">
                                        <select name="students[]" id="students" class="multiple form-control" multiple>
                                            @foreach($students as $item)
                                                <option value="{{ $item->id }}" @if(in_array($item->name_initials, $guardiance_student)) selected @endif>
                                                    {{ $item->name_initials}}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('students')
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
