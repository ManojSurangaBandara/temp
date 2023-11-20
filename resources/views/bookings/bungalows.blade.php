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
</div>
       

        <div class="col-md-12">
            <!-- Widget: user widget style 2 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-teal" style="height: 50%">
 
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username  text-center">Bungalow Bookings</h3>
                {{-- <h5 class="widget-user-desc">Forces Wise</h5> --}}
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
 
@stop
