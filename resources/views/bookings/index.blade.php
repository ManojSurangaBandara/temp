@extends('layouts.app')


@section('content')

<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Bookings</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item ">Booking Management</li>
                <li class="breadcrumb-item active">All</li>
              </ol>
            </div>
        </div>
    </section>

    <div class="card card-cyan">
        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-user-circle"></i>
                All Bookings
            </h3>

            <div class="card-tools"><a href="{{ url()->previous() }}" class="btn btn-sm bg-dark btn-block">
                <i class="fa fa-arrow-circle-left"></i> Back</a>
            </div>
        </div>
            <div class="card-body">
                {{$dataTable->table()}}
            </div>
    </div>

</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
