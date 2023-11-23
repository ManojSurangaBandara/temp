{{-- @extends('layouts.app')

@section('content')
<div class="container-fluid">
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
              <h1>All Bungalow Bookings</h1>
          </div>
          <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item ">Bungalow Bookings</li>
                <li class="breadcrumb-item active">All</li>
              </ol>
          </div>
        </div>
  </section>
</div>
       

        <div class="col-md-12">
            <!-- Widget: user widget style 2 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-teal" style="height: 50%">
 
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username  text-center">Bungalow Bookings</h3>
                
              </div>
              <div class="card-footer p-0">

                
                <ul class="nav flex-column">
                    @foreach ($bungalows as $item)
                      <li class="nav-item">
                    <a href="{{ route('bookings.bungalow_bookings',$item->id) }}" class="nav-link">  
                      <div class="col-sm-8 d-inline">{{  $item->name }} 
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                          {{  $item->bookings->count() }}                          
                        </span>
                      </div>
                      <span class="float-right badge bg-teal font-weight-bold"> {{  $item->bookings->count() }} </span> 
                      
                      </a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
            <!-- /.widget-user -->
          </div>

@endsection

@section('third_party_stylesheets')  
@stop

@section('third_party_scripts') 
 
@stop --}}
@extends('layouts.app')


@section('content')

<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>All Bungalow Bookings</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item ">Bungalow Bookings</li>
                <li class="breadcrumb-item active">All</li>
              </ol>
            </div>
        </div>
    </section>

    <div class="card card-cyan">
        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-user-circle"></i>
                Bungalow Bookings
            </h3>

            <div class="card-tools"><a href="{{ route('bookings.create') }}" class="btn btn-sm bg-dark btn-block">
                <i class="fa fa-plus"></i> Create Reservation </a>
            </div>
        </div>
            <div class="card-body">
              {{-- @foreach ($bungalows as $item)
                
                <a href="{{ route('bookings.bungalow_bookings',$item->id) }}" class="nav-link">  
                  <div class="col-sm-8 d-inline">{{  $item->name }} 
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                      {{  $item->bookings->count() }}                          
                    </span>
                  </div>
                  <span class="float-right badge bg-teal font-weight-bold"> {{  $item->bookings->count() }} </span>
                </a>
                
              @endforeach --}}
              
              @foreach ($bungalows as $item)
                <div class="row">
                  <div class="col-sm-8">
                    <a href="{{ route('bookings.bungalow_bookings',$item->id) }}">
                      {{  $item->name }}
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                        {{  $item->bookings->count() }}                          
                      </span>
                    </a>                  
                  </div>
                  <div class="col-sm-4">
                    <a href="{{ route('bookings.calender',$item->id) }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                  </div>
                </div>
                
              @endforeach


            </div>
    </div>

</div>
@endsection

@section('third_party_stylesheets')  
@stop

@section('third_party_scripts') 
 
@stop

