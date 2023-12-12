@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Roles</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                  <li class="breadcrumb-item ">System Management</li>
                  <li class="breadcrumb-item ">Role Management</li>
                  <li class="breadcrumb-item active">Create</li>
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
                            <h3 class="card-title">Create New Role</h3>
                            {{-- <div class="card-tools">
                                <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                            </div> --}}
                        </div>

                        <form role="form" method="POST" action="{{route('roles.store')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('name')
                                        is-invalid @enderror" name="name" value="{{ old('name') }}" id="name" autocomplete="off">
                                        <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <label class="col-sm-2 col-form-label">Permissions:</label>
                                @foreach ($permissionCategory as $item)
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-sm-12 col-form-label">{{ $item->name }}:</label>                                            
                                        </div>
                                        @foreach ($item->permissions as $value)
                                            <div class="col-sm-4">
                                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                                    {{ $value->visible_name }}
                                                    {{-- <a href="{{ route('permissions.edit',$value->id) }}"
                                                    class="btn btn-xs btn-light" data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pen-alt"></i> </a> --}}
                                                </label>
                                            </div>                                            
                                        @endforeach
                                    </div>
                                @endforeach

                                {{-- <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Permission:</label>
                                    <div class="col-sm-6">
                                        <br/>
                                        @foreach($permission as $value)
                                            <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                            {{ $value->visible_name }}</label>
                                        <br/>
                                        @endforeach
                                    </div>
                                </div> --}}
                            </div>

                                <div class="card-footer">
                                    <a href="{{ url()->previous() }}" class="btn btn-sm bg-info"><i class="fa fa-arrow-circle-left"></i> Back</a>
                                        <button type="reset" class="btn btn-sm btn-secondary">Cancel</button>
                                        <button type="submit" class="btn btn-sm btn-success" >Create</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
@endsection
