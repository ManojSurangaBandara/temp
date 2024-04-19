@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Booking Retired</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                  <li class="breadcrumb-item ">Booking</li>
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
                        <h3 class="card-title">Create New Booking</h3>
                    </div>

                    <form role="form" method="POST" action="{{ route('bookings.store_retired_admin') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <!-- Your existing form fields -->
                            {{-- <div class="form-group row">
                                <label for="eno" class="col-sm-2 col-form-label">E-Number</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control @error('eno')
                                    is-invalid @enderror" name="eno" value="{{ old('eno') }}" id="eno" autocomplete="off">
                                    <span class="text-danger">@error('eno') {{ $message }} @enderror</span>
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label for="svc_no" class="col-sm-2 col-form-label">Svc Number</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control @error('svc_no')
                                    is-invalid @enderror" name="svc_no" value="{{ old('svc_no') }}" id="svc_no" autocomplete="off">
                                    <span class="text-danger">@error('svc_no') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="form-group row" style="display: none;">
                                <label for="approve" class="col-sm-2 col-form-label">Approve</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control @error('approve')
                                    is-invalid @enderror" name="approve" value="0" id="approve" autocomplete="off">
                                    <span class="text-danger">@error('approve') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="form-group row" @if(!auth()->user()->can('booking-modify-regiment')) style="display:none" @endif>
                                <label for="regiment" class="col-sm-2 col-form-label">Regiment</label>
                                <div class="col-sm-6">
                                    <select class="form-control @error('regiment') is-invalid @enderror"
                                        name="regiment" value="{{ old('regiment') }}" id="regiment" required>
                                        <option value="">Please Select</option>
                                        @foreach ($regiments as $item)
                                            <option value="{{ $item->name }}" {{ auth()->user()->regiment_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">@error('regiment') {{ $message }} @enderror</span>
                                </div>
                            </div>
                            {{ auth()->user()->regiment_id == $item->id }}

                            <div class="form-group row">
                                <label for="unit" class="col-sm-2 col-form-label">Unit</label>
                                <div class="col-sm-6">
                                    <select class="form-control @error('unit') is-invalid @enderror"
                                        name="unit" value="{{ old('unit') }}" id="unit" required>
                                        <option value="">Please Select</option>
                                    </select>
                                    <span class="text-danger">@error('unit') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="form-group row" >
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control @error('name')
                                    is-invalid @enderror" name="name" value="{{ old('name') }}" id="name" autocomplete="off">
                                    <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nic" class="col-sm-2 col-form-label">NIC</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control @error('nic')
                                    is-invalid @enderror" name="nic" value="{{ old('nic') }}" id="nic" autocomplete="off">
                                    <span class="text-danger">@error('nic') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="contact_no" class="col-sm-2 col-form-label">Contact Number</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control @error('contact_no')
                                    is-invalid @enderror" name="contact_no" value="{{ old('contact_no') }}" id="contact_no" autocomplete="off">
                                    <span class="text-danger">@error('contact_no') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="form-group row" style="display: none;">
                                <label for="type" class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-6">
                                    <select class="form-control @error('type') is-invalid @enderror"
                                        name="type" value="{{ old('type') }}" id="type" required>
                                        <option value="">Please Select</option>
                                        <option value="0">Serving</option>
                                        <option value="1" selected>Retired</option>
                                        <option value="2">Official</option>
                                    </select>
                                    <span class="text-danger">
                                        @error('type')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="rank_id" class="col-sm-2 col-form-label">Rank</label>
                                <div class="col-sm-6">
                                    <select class="form-control @error('rank_id') is-invalid @enderror"
                                        name="rank_id" value="{{ old('rank_id') }}" id="rank_id" required>
                                        <option value="">Please Select</option>
                                        @foreach ($ranks as $item)
                                            <option value="{{ $item->name }}">
                                                {{ $item->name }}
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
                                <label for="bungalow_id" class="col-sm-2 col-form-label">Bungalow</label>
                                <div class="col-sm-6">
                                    <select class="form-control @error('bungalow_id') is-invalid @enderror"
                                        name="bungalow_id" value="{{ old('bungalow_id') }}" id="bungalow_id" required>
                                        <option value="">Please Select</option>
                                    </select>
                                    <span class="text-danger">
                                        @error('bungalow_id')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="army_id" class="col-sm-2 col-form-label">Army No</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control @error('army_id')
                                    is-invalid @enderror" name="army_id" value="{{ old('army_id') }}" id="army_id" autocomplete="off">
                                    <span class="text-danger">@error('army_id') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="check_in" class="col-sm-2 col-form-label">Check in</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control @error('check_in')
                                    is-invalid @enderror" name="check_in" value="{{ old('check_in') }}" id="check_in" autocomplete="off"
                                    min="{{ now()->toDateString() }}"
                                    max="{{ now()->addDays(60)->toDateString() }}">
                                    <span class="text-danger">@error('check_in') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="check_out" class="col-sm-2 col-form-label">Check out</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control @error('check_out')
                                    is-invalid @enderror" name="check_out" value="{{ old('check_out') }}" id="check_out" autocomplete="off"
                                    min="{{ now()->toDateString() }}"
                                    max="{{ now()->addDays(60)->toDateString() }}">
                                    <span class="text-danger">@error('check_out') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="form-group row" id="guests-field">
                                <label class="col-sm-2 col-form-label" for="Item_Auto_Id">Add Guests</label>
                                <div class="col-sm-9">
                                    <table class="table" id="guestsTable">
                                        <!-- Your guests table header -->
                                        <tr>
                                            <th>Name</th>
                                            <th>NIC</th>
                                            <th>Action</th>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="guests[0][name]" placeholder="Enter Name"
                                                       class="form-control"/></td>
                                            <td><input type="text" name="guests[0][nic]" placeholder="NIC"
                                                       class="form-control" pattern="[0-9VXvx]+"/></td>
                                            <td>
                                                <button type="button" name="addGuest" id="addGuest"
                                                        class="btn btn-dark">
                                                    Add More
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group row" id="vehicles-field">
                                <label class="col-sm-2 col-form-label" for="Item_Auto_Id">Add Vehicles</label>
                                <div class="col-sm-9">
                                    <table class="table" id="vehiclesTable">
                                        <!-- Your vehicles table header -->
                                        <tr>
                                            <th>Register Number</th>
                                            <th>Action</th>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="vehicles[0][reg_no]" placeholder="Enter Name"
                                                       class="form-control"/></td>
                                            <td>
                                                <button type="button" name="addVehicle" id="addVehicle"
                                                        class="btn btn-dark">
                                                    Add More
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="payment" class="col-sm-2 col-form-label">Payment Amount</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="payment" id="payment" readonly>
                                </div>
                            </div>

                            <div class="form-group row ">
                                <label for="filpath" class="col-sm-2 col-form-label">Select Image<sup class="text-red">*</sup></label>
                                <div class="col-sm-6">
                                    <input type="file" class="form-control @error('filpath') is-invalid @enderror"
                                    name="filpath" value="{{ old('filpath') }}" required accept=".jpeg,.png,.jpg" required>
                                    <span class="text-danger">@error('filpath') {{ $message }}
                                    @enderror</span>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <a href="{{ url()->previous() }}" class="btn btn-sm bg-info"><i class="fa fa-arrow-circle-left"></i> Back</a>
                                <button type="reset" class="btn btn-sm btn-secondary">Cancel</button>
                                <button type="submit" class="btn btn-sm btn-success" >Create</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
@stop

@section('third_party_scripts')
<script src="{{ asset('plugins/select2/js/select2.min.js') }}" defer></script>
    <script>
        $(document).ready(function () {

            // Initialize Select2 for the existing select element
            $("#regiment, #rank_id, #unit, #bungalow_id").select2({
                theme: "default" // You can choose a theme based on your preferences
            });



            // When the rank dropdown changes
            $('#rank_id').on('change', function() {
                var rankId = $(this).val();
                console.log(rankId);
                // Make an AJAX request to get bungalows based on the selected rank
                $.ajax({
                    url: '{{ route('ajax.getBungalow') }}',
                    method: 'GET',
                    data: { name: rankId },
                    success: function(data) {
                        // Clear existing options
                        $('#bungalow_id').empty();

                        // Populate the bungalow dropdown with new options
                        $.each(data, function(index, bungalow) {
                            $('#bungalow_id').append('<option value="' + bungalow.id + '">' + bungalow.name + '</option>');
                        });
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            var userRegimentId = $('#regiment').val();

            if (userRegimentId) {
                $.ajax({
                    url: '{{ route('ajax.getUnits') }}',
                    type: 'get',
                    data:{'regiment':userRegimentId,'_token' : $('meta[name="csrf-token"]').attr('content')},
                    success: function(response){

                            $('#unit option').remove();
                            $('#unit').append(new Option( 'Select ',''));
                            $.each( response, function( key, value ) {
                                $('#unit').append(new Option(value.name, value.userRegimentId));
                            });
                    }
                });
            }

            //When the regiment dropdown changes
            $('#regiment').change(function(){
            var id = $(this).val();
            console.log(id);

                $.ajax({
                    url: '{{ route('ajax.getUnits') }}',
                    type: 'get',
                    data:{'regiment':id,'_token' : $('meta[name="csrf-token"]').attr('content')},
                    success: function(response){

                            $('#unit option').remove();
                            $('#unit').append(new Option( 'Select ',''));
                            $.each( response, function( key, value ) {
                                $('#unit').append(new Option(value.name, value.id));
                            });
                    }
                });

            })

            // function loadUnits(regimentId) {
            //     $.ajax({
            //         url: '{{ route('ajax.getUnits') }}',
            //         type: 'get',
            //         data: {'regiment': regimentId, '_token': $('meta[name="csrf-token"]').attr('content')},
            //         success: function(response){
            //             $('#unit option').remove();
            //             $('#unit').append(new Option('Select', ''));
            //             $.each(response, function(key, value) {
            //                 $('#unit').append(new Option(value.name, value.id));
            //             });
            //         }
            //     });
            // }

            // // Load units when the page loads
            // $(document).ready(function() {
            //     var userRegimentId = $('#regiment').val();
            //     if (userRegimentId) {
            //         loadUnits(userRegimentId);
            //     }
            // });

            // // Load units when the regiment selection changes
            // $('#regiment').change(function(){
            //     var selectedRegimentId = $(this).val();
            //     if (selectedRegimentId) {
            //         loadUnits(selectedRegimentId);
            //     }
            // });

            $('#type, #bungalow_id, #check_in, #check_out').on('change', function () {
                updatePayment();
            });

            function updatePayment() {
                var type = $('#type').val();
                var bungalow = $('#bungalow_id').val();
                var checkIn = $('#check_in').val();
                var checkOut = $('#check_out').val();

                if (checkIn && checkOut) {
                    // Calculate the number of days
                    var startDate = new Date(checkIn);
                    var endDate = new Date(checkOut);
                    var timeDifference = endDate.getTime() - startDate.getTime();
                    var daysDifference = timeDifference / (1000 * 60 * 60 * 24);

                    // Make an AJAX request to get the payment amount
                    $.ajax({
                        url: '{{ route('ajax.getPayment') }}',
                        method: 'GET',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "type": type,
                            "bungalow_id": bungalow
                        },
                        success: function (data) {
                            // Update the payment amount field
                            var paymentAmount = 0;

                            // var paymentAmount = data[0]['serving_price'] * daysDifference;
                            // $('#payment').val(paymentAmount);
                            console.log(type);

                            var paymentAmount = 0; // Default value

                            switch (type) {
                                case '0':
                                    paymentAmount = data[0]['serving_price'] * daysDifference;
                                    break;
                                case '1':
                                    paymentAmount = data[0]['retired_price'] * daysDifference;
                                    break;
                                case '2':
                                    paymentAmount = data[0]['official_price'] * daysDifference;
                                    break;
                            }

                            console.log(paymentAmount); // Move this line outside the switch statement
                            $('#payment').val(paymentAmount);

                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            }


            var guestIndex = 0;
            var vehicleIndex = 0;

            $("#addGuest").click(function () {
                ++guestIndex;
                $("#guestsTable tbody").append('<tr>' +
                    '<td><input type="text" name="guests[' + guestIndex + '][name]" placeholder="Enter Name" class="form-control" required/></td>' +
                    '<td><input type="text" name="guests[' + guestIndex + '][nic]" placeholder="NIC" class="form-control" pattern="[0-9VXvx]+"/></td>' +
                    '<td><button type="button" class="btn btn-danger remove-row">Remove</button></td>' +
                    '</tr>');
            });

            $("#addVehicle").click(function () {
                ++vehicleIndex;
                $("#vehiclesTable tbody").append('<tr>' +
                    '<td><input type="text" name="vehicles[' + vehicleIndex + '][reg_no]" placeholder="Enter Name" class="form-control" required/></td>' +
                    '<td><button type="button" class="btn btn-danger remove-row">Remove</button></td>' +
                    '</tr>');
            });

            $(document).on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
            });

            // When the check_in or check_out input fields change
            $('#check_in, #check_out').on('change', function() {
                var checkInDate = new Date($('#check_in').val());
                var checkOutDate = new Date($('#check_out').val());

                // Calculate the difference in days
                var dateDifference = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));

                // Check if the difference is greater than 3 days
                if (dateDifference > 3) {
                    // Set check_out date to be exactly 3 days after check_in
                    var newCheckOutDate = new Date(checkInDate.getTime() + (3 * 24 * 60 * 60 * 1000));
                    var formattedNewCheckOutDate = newCheckOutDate.toISOString().split('T')[0];
                    $('#check_out').val(formattedNewCheckOutDate);
                }
            });
        });
    </script>
@endsection
