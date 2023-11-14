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
                  <li class="breadcrumb-item active">View</li>
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
                    <h3 class="card-title">View Guardiance</h3>
                    <div class="card-tools">
                        <a class="btn btn-primary" href="{{ route('guardiances.index') }}"> Back</a>
                    </div>
                </div>

                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-sm-2">
                            <strong>Type:</strong>
                        </label>
                        <div class="col-sm-10">
                            {{ $guardiance->guardiance_type->name }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2">
                            <strong>Name:</strong>
                        </label>
                        <div class="col-sm-10">
                            {{ $guardiance->user->name }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2">
                            <strong>Email:</strong>
                        </label>
                        <div class="col-sm-10">
                            {{ $guardiance->user->email }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2">
                            <strong>Username:</strong>
                        </label>
                        <div class="col-sm-10">
                            {{ $guardiance->user->username }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2">
                            <strong>Default Contact:</strong>
                        </label>
                        <div class="col-sm-10">
                            {{ $guardiance->user->contact }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2">
                            <strong>Contact:</strong>
                        </label>
                        <div class="col-sm-10">
                            {{ $guardiance->sec_contact }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2">
                            <strong>NIC / Passport:</strong>
                        </label>
                        <div class="col-sm-10">
                            {{ $guardiance->nic }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2">
                            <strong>Roles:</strong>
                        </label>
                        <div class="col-sm-10">
                            @if(!empty($guardiance->user->getRoleNames()))
                                @foreach($guardiance->user->getRoleNames() as $v)
                                    <label class="badge badge-success">{{ $v }}</label>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2">
                            <strong>Students:</strong>
                        </label>
                        <div class="col-sm-10">
                            @if($guardiance->students->isEmpty())
                                <label class="badge badge-info">N/A</label>
                            @else
                                @foreach($guardiance->students as $v)
                                    <label class="badge badge-success">{{ $v->name_initials }}</label>
                                @endforeach
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
