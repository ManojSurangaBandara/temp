@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Person Profile</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Reports</li>
                <li class="breadcrumb-item active">Person Profile</li>
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
        All Persons 
      </h3>
      <div class="card-tools"  >
        <div class="input-group input-group-sm "  >

          <!-- <a href="{{ url()->previous(); }}" class="btn bg-gray btn-sm" title="Go Back" 
            data-toggle="tooltip"> <i class="fa fa-arrow"></i> Back</a> -->
            
        
      </div>
      </div>
    </div>
    

    <div class="row mt-1 ml-2">
      <div class="col-2" @if(Auth::user()->user_type_id != 1) hidden @endif>        
        <select class="form-control" name="force_id"  id="force_id">
          <option value="">Forces</option>
              @foreach ($forces as $item)
                <option value="{{ $item->id }}" {{ auth()->user()->force_id == $item->id ? 'selected':'' }}>
                  {{ $item->name }}
                </option>
              @endforeach
        </select>
      </div>

      <div class="col-2">        
        <select class="form-control" name="regiment_department_id"  id="regiment_department_id">
          <option value="">Reg/Dep</option>
              @foreach ($regimentDepartments as $item)
                <option value="{{ $item->id }}">
                  {{ $item->name }}
                </option>
              @endforeach
        </select>
      </div>

      <div class="col-2">        
        <select class="form-control" name="rank_id"  id="rank_id">
          <option value="">Rank</option>
              @foreach ($ranks as $item)
                <option value="{{ $item->id }}">
                  {{ $item->name }}
                </option>
              @endforeach
        </select>
      </div>

      <div class="col-2">        
        <select class="form-control" name="ranaviru_types_id"  id="ranaviru_types_id">
          <option value="">Ranaviru Type</option>
              @foreach ($ranaviruTypes as $item)
                <option value="{{ $item->id }}">
                  {{ $item->name }}
                </option>
              @endforeach
        </select>
      </div>
      
      <div class="col-2">        
        <select class="form-control" name="marital_status_id"  id="marital_status_id">
          <option value="">Marital Status</option>
              @foreach ($maritalStatus as $item)
                <option value="{{ $item->id }}">
                  {{ $item->name }}
                </option>
              @endforeach
        </select>
      </div>

      <div class="col-2">        
        <select class="form-control" name="ethnicity_id"  id="ethnicity_id">
          <option value="">Ethnicity</option>
              @foreach ($ethnicity as $item)
                <option value="{{ $item->id }}">
                  {{ $item->name }}
                </option>
              @endforeach
        </select>
      </div>

      <div class="col-2">        
        <select class="form-control" name="province_id"  id="province_id">
          <option value="">Province</option>
              @foreach ($provinces as $item)
                <option value="{{ $item->id }}">
                  {{ $item->name }}
                </option>
              @endforeach
        </select>
      </div>

      <div class="col-2">        
        <select class="form-control" name="district_id"  id="district_id">
          <option value="">District</option>
              @foreach ($districts as $item)
                <option value="{{ $item->id }}">
                  {{ $item->name }}
                </option>
              @endforeach
        </select>
      </div>

      <div class="col-2">        
        <select class="form-control" name="dsdivision_id"  id="dsdivision_id">
          <option value="">DSDivision</option>
              @foreach ($dsDivisions as $item)
                <option value="{{ $item->id }}">
                  {{ $item->name }}
                </option>
              @endforeach
        </select>
      </div>
      
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
              url: "{{ route('reports.person_profile') }}",
              data: function (d) {
                    d.force_id = $('#force_id').val(),
                    d.regiment_department_id = $('#regiment_department_id').val(),
                    d.rank_id = $('#rank_id').val(),
                    d.ranaviru_types_id = $('#ranaviru_types_id').val(),
                    d.marital_status_id = $('#marital_status_id').val(),
                    d.ethnicity_id = $('#ethnicity_id').val(),
                    d.province_id = $('#province_id').val(),
                    d.district_id = $('#district_id').val(),
                    d.dsdivision_id = $('#dsdivision_id').val(),
                    d.search = $('input[type="search"]').val()
                }
            },
            columns: [
                {data: 'index', name: 'index'},
                // {data: 'machine_type.name', name: 'machine_type.name'},
                {data: 'svc_no', name: 'svc_no'},
                {data: 'rank.name', name: 'rank.name'},
                {data: 'name_with_initials', name: 'name_with_initials'},
                // {data: 'project', name: 'project'},                
                // {data: 'location', name: 'location'},
            ]
        });
      
        $('#force_id,#regiment_department_id,#rank_id,#ranaviru_types_id,#marital_status_id,#ethnicity_id,#province_id,#district_id,#dsdivision_id').change(function(){
            table.draw();
        });
          
      });
    </script>
    
    <script type="text/javascript">      
    //   $('#force_id').change(function () {
    //     var id = $(this).val();
        
    //       $.ajax({
    //         url: '{{ route('ajax.getRanks') }}',
    //         type: 'get',
    //         data: {
    //           'force_id': id,
    //           '_token': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function (response) {
    //           $('#rank_id option').remove();
    //           $('#rank_id').append(new Option('Select', ''));
    //           $.each(response, function (key, value) {
    //           $('#rank_id').append(new Option(value.abbr, value.id));
    //         });
        
    //         // Add an additional AJAX call to populate regiment_department_id
    //         $.ajax({
    //           url: '{{ route('ajax.getRegementDepartment') }}',
    //           type: 'get',
    //           data: {
    //                 'force_id': id,
    //                 '_token': $('meta[name="csrf-token"]').attr('content')
    //                 },
    //                 success: function (departmentResponse) {
    //                   $('#regiment_department_id option').remove();
    //                   $('#regiment_department_id').append(new Option('Select', ''));
    //                   $.each(departmentResponse, function (key, department) {
    //                     $('#regiment_department_id').append(new Option(department.name, department.id));
    //                   });
    //                 }
    //           });
    //       }
    //   });
    // });
    
    $(document).ready(function() {
        // Function to make the AJAX request
        function makeAjaxRequest(id) {
            $.ajax({
                url: '{{ route('ajax.getRanks') }}',
                type: 'get',
                data: {
                    'force_id': id,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#rank_id option').remove();
                    $('#rank_id').append(new Option('Select', ''));
                    $.each(response, function(key, value) {
                        $('#rank_id').append(new Option(value.abbr, value.id));
                    });
                }
            });

            // Add an additional AJAX call to populate regiment_department_id
            $.ajax({
                url: '{{ route('ajax.getRegementDepartment') }}', // Corrected route name
                type: 'get',
                data: {
                    'force_id': id,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(departmentResponse) {
                    $('#regiment_department_id option').remove();
                    $('#regiment_department_id').append(new Option('Select', ''));
                    $.each(departmentResponse, function(key, department) {
                        $('#regiment_department_id').append(new Option(department.name, department.id));
                    });
                }
            });
        }

        // Call the function on page load
        makeAjaxRequest($('#force_id').val());

        // Add an event handler for the change event on #force_id
        $('#force_id').change(function() {
            var id = $(this).val();
            // Call the function when the #force_id element changes
            makeAjaxRequest(id);
        });
    });


        $('#province_id').change(function(){
            var id = $(this).val();

            $.ajax({
                url: '{{ route('ajax.getDistricts') }}',
                type: 'get', 
                data:{'province_id':id,'_token' : $('meta[name="csrf-token"]').attr('content')},
                success: function(response){ 

                        $('#district_id option').remove();
                        $('#district_id').append(new Option( 'Select ',''));
                        $.each( response, function( key, value ) {                   
                        $('#district_id').append(new Option(value.name, value.id));
                        }); 
                }
            });

        })

        $('#district_id').change(function(){
            var id = $(this).val();
            console.log(id);

            $.ajax({
                url: '{{ route('ajax.getDSDivisions') }}',
                type: 'get', 
                data:{'district_id':id,'_token' : $('meta[name="csrf-token"]').attr('content')},
                success: function(response){ 

                        $('#dsdivision_id option').remove();
                        $('#dsdivision_id').append(new Option( 'Select ',''));
                        $.each( response, function( key, value ) {                   
                        $('#dsdivision_id').append(new Option(value.name, value.id));
                        }); 
                }
            });

        })
    </script>
@stop
