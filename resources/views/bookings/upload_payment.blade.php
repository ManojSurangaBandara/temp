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
                  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                  <li class="breadcrumb-item ">Booking</li>
                  <li class="breadcrumb-item active">Upload Payment</li>
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
                        <h3 class="card-title">Upload Payment</h3>
                    </div>

                    <form role="form" action="{{ route('bookings.upload_payment',$booking->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <!-- Your existing form fields -->

                            

                            <div class="form-group row">
                                <label for="bank_id" class="col-sm-2 col-form-label">Bank</label>
                                <div class="col-sm-6">
                                    <select class="form-control @error('bank_id') is-invalid @enderror"
                                        name="bank_id" value="{{ old('bank_id') }}" id="bank_id" required>
                                        <option value="">Please Select</option>
                                        @foreach ($banks as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">
                                        @error('bank_id')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="acc_no" class="col-sm-2 col-form-label">Acc no</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control @error('acc_no')
                                    is-invalid @enderror" name="acc_no" value="{{ old('acc_no') }}" id="acc_no" autocomplete="off" required>
                                    <span class="text-danger">@error('acc_no') {{ $message }} @enderror</span>
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
                                <button type="submit" class="btn btn-sm btn-success" >Upload</button>
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
