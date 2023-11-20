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

                    <form role="form" method="POST" action="{{ route('bookings.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <!-- Your existing form fields -->

                            <div class="form-group row">
                                <label for="type" class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-6">
                                    <select class="form-control @error('type') is-invalid @enderror"
                                        name="type" value="{{ old('type') }}" id="type" required>
                                        <option value="">Please Select</option>
                                        <option value="0">Serving</option>
                                        <option value="1">Retired</option>
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
                                    is-invalid @enderror" name="check_in" value="{{ old('check_in') }}" id="check_in" autocomplete="off">
                                    <span class="text-danger">@error('check_in') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="check_out" class="col-sm-2 col-form-label">Check out</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control @error('check_out')
                                    is-invalid @enderror" name="check_out" value="{{ old('check_out') }}" id="check_out" autocomplete="off">
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
                                                       class="form-control" required/></td>
                                            <td><input type="text" name="guests[0][nic]" placeholder="NIC"
                                                       class="form-control"/></td>
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
                                                       class="form-control" required/></td>
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

@section('third_party_scripts')
    <script>
        $(document).ready(function () {           

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
                    '<td><input type="text" name="guests[' + guestIndex + '][nic]" placeholder="NIC" class="form-control"/></td>' +
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
        });
    </script>
@endsection
