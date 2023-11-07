@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Permission</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item ">System Management</li>
                  <li class="breadcrumb-item ">Permission Management</li>
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
                    <h3 class="card-title">Update Permission</h3>
                    {{-- <div class="card-tools">
                        <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                    </div> --}}
                </div>

                <form role="form" action="{{ route('permissions.update',$permission->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Permission Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control @error('name')
                                is-invalid @enderror" name="name" value="{{ $permission->name }}" id="name" autocomplete="off" disabled>
                                <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="permission_category_id" class="col-sm-2 col-form-label">Permission Category</label>
                            <div class="col-sm-6">
                                <select class="form-control @error('permission_category_id') is-invalid @enderror"
                                    name="permission_category_id" value="{{ old('permission_category_id') }}" id="permission_category_id" required>
                                    @foreach ($permissioncategories as $item)
                                        <option value="{{ $item->id }}" {{$permission->permission_category_id == $item->id ? 'selected':''}}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    @error('permission_category_id')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="visible_name" class="col-sm-2 col-form-label">Visible Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control @error('visible_name')
                                is-invalid @enderror" name="visible_name" value="{{ $permission->visible_name }}" 
                                id="visible_name" autocomplete="off" required>
                                <span class="text-danger">@error('visible_name') {{ $message }} @enderror</span>
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
  </div>
@endsection
