@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item ">System Management</li>
                  <li class="breadcrumb-item ">User Management</li>
                  <li class="breadcrumb-item active">Update</li>
                </ol>
            </div>
          </div>
    </section>
  </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-teal">
                        <div class="card-header">
                            <h3 class="card-title">Update User</h3>
                            {{-- <div class="card-tools">
                                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                            </div> --}}
                        </div>

                        <form role="form" action="{{ route('users.update',$user->id) }}" method="post"
                              enctype="multipart/form-data">
                              @csrf
                              @method('PUT')

                            <div class="card-body">

                                <div class="form-group row">
                                    <label for="force_id" class="col-sm-2 col-form-label">Force</label>
                                    <div class="col-sm-6">
                                        <select class="form-control @error('force_id') is-invalid @enderror"
                                            name="force_id" value="{{ old('force_id') }}" id="force_id" required>
                                            <option value="">Please Select</option>
                                            @foreach ($forces as $item)
                                                <option value="{{ $item->id }}" {{ $user->force_id == $item->id ? 'selected':'' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('force_id')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="rank_id" class="col-sm-2 col-form-label">Rank</label>
                                    <div class="col-sm-6">
                                        <select class="form-control @error('rank_id') is-invalid @enderror" name="rank_id" id="rank_id" required>
                                            <option value="">Please Select</option>
                                            @foreach ($ranks as $item)
                                                <option value="{{ $item->id }}" {{ $user->rank_id == $item->id ? 'selected':'' }}>
                                                    {{ $item->abbr }}
                                                </option>
                                            @endforeach                                                            
                                        </select>
                                        <span class="text-danger">
                                            @error('rank_id')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="regiment_department_id" class="col-sm-2 col-form-label">Regiment/Department</label>
                                    <div class="col-sm-6">
                                        <select class="form-control @error('regiment_department_id') is-invalid @enderror" name="regiment_department_id" id="regiment_department_id" required>
                                            <option value="">Please Select</option>
                                            @foreach ($regimentDepartments as $item)
                                                <option value="{{ $item->id }}" {{ $user->regiment_department_id == $item->id ? 'selected':'' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach                                                            
                                        </select>
                                        <span class="text-danger">
                                            @error('regiment_department_id')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="svc_no" class="col-sm-2 col-form-label">Service No</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('svc_no')
                                        is-invalid @enderror" name="svc_no" value="{{ $user->svc_no }}" id="svc_no" autocomplete="off">
                                        <span class="text-danger">@error('svc_no') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('name')
                                        is-invalid @enderror" name="name" value="{{ $user->name }}" id="name" autocomplete="off">
                                        <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('email')
                                        is-invalid @enderror" name="email" value="{{ $user->email }}" id="email" autocomplete="off">
                                        <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                                    </div>
                                </div>                               

                                <div class="form-group row">
                                    <label class="col-sm-2" for="roles">Role</label>
                                    <div class="col-sm-6 select2-blue">
                                        <select required name="roles[]" id="roles"
                                                class="multiple form-control" >
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
                                    <label for="user_type_id" class="col-sm-2 col-form-label">User Type</label>
                                    <div class="col-sm-6">
                                        <select class="form-control @error('user_type_id') is-invalid @enderror"
                                            name="user_type_id" value="{{ old('user_type_id') }}" id="user_type_id" required>
                                            <option value="">Please Select</option>
                                            @foreach ($usertypes as $item)
                                                <option value="{{ $item->id }}" {{ $user->user_type_id == $item->id ? 'selected':'' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('user_type_id')
                                                {{ $message }}
                                            @enderror
                                        </span>
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

        {{--  --}}
        
@endsection

@section('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
@endsection

@section('third_party_scripts')
    {{-- <script src="{{ asset('plugins/jquery/jquery.min.js') }}" ></script> --}}
    <script src="{{asset('plugins/select2/js/select2.js')}}" defer></script>
    {{-- <script>
        $(document).ready(function() {
            $('.multiple').select2();
        });
    </script> --}}

<script src="{{asset('plugins/select2/js/select2.js')}}" defer></script>        

{{-- <script type="text/javascript">          
    

    // $(document).ready(function() {
    //     $('.multiple').select2();            
    // });

    $('#force_id').change(function(){
        var id = $(this).val();
        console.log("in");

        $.ajax({
            url: '{{ route('ajax.getRanks') }}',
            type: 'get', 
            data:{'force_id':id,'_token' : $('meta[name="csrf-token"]').attr('content')},
            success: function(response){ 

                    $('#rank_id option').remove();
                    $('#rank_id').append(new Option( 'Select ',''));
                    $.each( response, function( key, value ) {                   
                    $('#rank_id').append(new Option(value.abbr, value.id));
                    }); 
            }
        });

    })
</script> --}}

<script type="text/javascript">
    $('#force_id').change(function () {
        var id = $(this).val();
        console.log("in");

        $.ajax({
            url: '{{ route('ajax.getRanks') }}',
            type: 'get',
            data: {
                'force_id': id,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#rank_id option').remove();
                $('#rank_id').append(new Option('Select', ''));
                $.each(response, function (key, value) {
                    $('#rank_id').append(new Option(value.abbr, value.id));
                });

                // Add an additional AJAX call to populate regiment_department_id
                $.ajax({
                    url: '{{ route('ajax.getRegementDepartment') }}',
                    type: 'get',
                    data: {
                        'force_id': id,
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (departmentResponse) {
                        $('#regiment_department_id option').remove();
                        $('#regiment_department_id').append(new Option('Select', ''));
                        $.each(departmentResponse, function (key, department) {
                            $('#regiment_department_id').append(new Option(department.name, department.id));
                        });
                    }
                });
            }
        });
    });
</script>
@endsection
