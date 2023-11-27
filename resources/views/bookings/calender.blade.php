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

            <div class="card-tools"><a href="{{ route('bookings.index') }}" class="btn btn-sm bg-dark btn-block">
                <i class="fa fa-arrow-circle-left"></i> Back</a>
            </div>
        </div>
            <div class="card-body">
                <div id="calendar"></div>
            </div>
    </div>

</div>
@endsection

@section('third_party_stylesheets')   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
@stop

@section('third_party_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js" defer></script>

    <script>
        $(document).ready(function () {
            var eventData = <?php echo json_encode($events); ?>;
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultDate: new Date(), // Set your default date
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                events: eventData
            });
        });
    </script>
    
@stop
