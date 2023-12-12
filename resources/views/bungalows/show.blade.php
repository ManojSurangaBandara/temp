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
                    <h3 class="card-title">View Bungalow</h3>
                    <div class="card-tools">
                        <a class="btn btn-primary" href="{{ route('bungalows.index') }}"> Back</a>
                    </div>
                </div>

                <div class="card-body">                    

                    <div class="form-group row">
                        <label class="col-sm-2">
                            <strong>Name:</strong>
                        </label>
                        <div class="col-sm-10">
                            {{ $bungalow->user->name }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2">
                            <strong>Students:</strong>
                        </label>
                        <div class="col-sm-10">
                            @if($bungalow->ranks->isEmpty())
                                <label class="badge badge-info">N/A</label>
                            @else
                                @foreach($bungalow->ranks as $v)
                                    <label class="badge badge-success">{{ $v->name }}</label>
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
