@extends('layouts.app')
@section('content')  
<div class="container-fluid">
    <!-- Content Header (Page header) -->
<section class="content-header">
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Change Password</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item ">Change Password</li> 
      </ol>
    </div>
  </div>
</div><!-- /.container-fluid -->
</section>
      <div class="card card-teal">
        <div class="card-header">

          <h3 class="card-title">
            <i class="fas fa-user-circle"></i>
            Change Password
          </h3>
          <div class="card-tools"  >
            <div class="input-group input-group-sm "  >

              <a href="{{ url()->previous(); }}" class="btn bg-gray btn-sm"> <i class="fa fa-arrow"></i> Back</a>
              
          </div>
          </div>
        </div>
        <!-- /.card-header -->
              <div class="card-body">
                <form method="post" action="{{ route('change.password') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="current_password" class="col-sm-2 col-form-label">Current Password</label>
                        <div class="col-sm-6">
                        <input type="password"
                               name="current_password"
                               value="{{ old('current_password') }}"
                               class="form-control @error('current_password') is-invalid @enderror"
                               placeholder="current password"> 
                        @error('current_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-6">
                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="new password"> 
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    </div>
    
                                        <div class="form-group row">
                        <label for="password_confirmation" class="col-sm-2 col-form-label"> Confirmation password</label>
                        <div class="col-sm-6">
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               placeholder="Retype new password">
                               @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        
                    </div>
                    </div>
                    
                    <input type="submit" value="Update" class="btn btn-sm btn-success">
                </form>
              </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
</div>


 
@endsection