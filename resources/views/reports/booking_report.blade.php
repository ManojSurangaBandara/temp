@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Booking</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Reports</li>
                <li class="breadcrumb-item active">Booking</li>
              </ol>
            </div>
          </div>        
    </section>
</div>


 
    <div class="container-fluid">
      
    <div class="card card-maroon">
    <div class="card-header">

      <h3 class="card-title">
        <i class="fas fa-user-circle"></i>
        All Bookings 
      </h3>
      <div class="card-tools"  >
        <div class="input-group input-group-sm "  >

          <!-- <a href="{{ url()->previous(); }}" class="btn bg-gray btn-sm" title="Go Back" 
            data-toggle="tooltip"> <i class="fa fa-arrow"></i> Back</a> -->
            
        
      </div>
      </div>
    </div>   

    <div class="row mt-1 ml-2">  
      <div class="col-2">        
        <select class="form-control" name="bungalow_id"  id="bungalow_id">
          <option value="">Bungalow</option>
              @foreach ($bungalows as $item)
                <option value="{{ $item->id }}">
                  {{ $item->name }}
                </option>
              @endforeach
        </select>
      </div>

      <div class="col-2">        
        <select class="form-control" name="type"  id="type">
          <option value="">Please Select</option>
          <option value="0">Serving</option>
          <option value="1">Retired</option>
          <option value="2">Official</option>
        </select>
      </div>

      {{-- <div class="col-2">
        <input type="date" class="form-control" name="check_in" id="check_in" placeholder="check in date">
      </div>

      <div class="col-2">
        <input type="date" class="form-control" name="check_out" id="check_out" placeholder="check out date">
      </div> --}}
      
    </div>

    <!-- /.card-header -->
          <div class="card-body">            
            <table class="table table-striped table-hover data-table">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Svc No</th>
                      <th>Rank</th>
                      <th>Name</th>
                      <th>Check in</th>
                      <th>Check out</th>
                      <th>Bungalow</th>

                  </tr>
              </thead>
              <tbody>
              </tbody>
            </table>  
          </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
    </div> 
@stop


@section('third_party_stylesheets')  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
  <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@stop
@section('third_party_scripts') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" defer></script>
     

    <script type="text/javascript">
      $(function () {
          console.log("in")
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
              url: "{{ route('reports.booking_report') }}",
              data: function (d) {
                    d.bungalow_id = $('#bungalow_id').val(),
                    d.type = $('#type').val(),                    
                    d.search = $('input[type="search"]').val()
                }
            },
            columns: [
                {data: 'index', name: 'index'},
                {data: 'svc_no', name: 'svc_no'},
                {data: 'rank', name: 'rank'},
                {data: 'name', name: 'name'},
                {data: 'check_in', name: 'check_in'},
                {data: 'check_out', name: 'check_out'},
                {data: 'bungalow.name', name: 'bungalow.name'},
            ]
        });
      
        $('#bungalow_id,#type,#check_in,#check_out').change(function(){
            table.draw();
        });
          
      });
    </script>    
    
@stop
