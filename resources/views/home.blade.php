@extends('layouts.main')
@section('title', 'KABAKA - Home')
@section('firstcardtitle')
@if(Auth::User()->position_id == 2)
    Appointment Of Patients
@else
    Your Appointment
@endif
@endsection

@section('firstcardcontent')
@if(Auth::User()->position_id == 2)
    <table class="table table-bordered" id="appointmentAdmin">
        <thead>
            <tr>
                <td>Name</td>
                <td>Date</td>
                <td>Approved</td>
                <td>Done</td>
                <td>Paid</td>
            </tr>
        </thead>
    </table>
@else
    <button class="btn btn-info" id="makeAppointmentUser" data-toggle="modal" data-target="#makeAppointment">Make An Appointment</button>
    <table class="table table-bordered" id="appointmentUser">
        <thead>
            <tr>
                <td>Date</td>
                <td>Approved</td>
                <td>Done</td>
            </tr>
        </thead>
    </table>
@endif
@include('modal.infoappointment')
@include('modal.makeappointment')
@include('modal.makepayment');
@endsection

@section('appointmentCalendarTitle')
@if(Auth::User()->position_id == 2)
    Schedule of Patients
@else
    Your Schedule(s)
@endif
@endsection

@section('appointmentCalendarContent')
@if(Auth::User()->position_id == 2)
<div class="col-md-12" id="calendarAdmin">
    
</div>
@else
<div class="col-md-12" id="calendar">
    
</div>
@endif
@endsection

@section('scripts')
<script type="text/javascript">

    var appointmentAdmin;
    var appointmentUser;
    var user_id = {{Auth::User()->id}}

    $(document).ready(function(){

        // var updateInterval = 3000;
        // setInterval(function(){
                loadTable();
        // }, updateInterval);
        loadUserTable();
        loadCalender();
        loadCalendarAdmin();

        // check appointment availability
        $(document).on('click', '#checkInner', function(){
            var appointment = $('#appointmentInner').val();
            $.ajax({

                url : "{{url('api/checkdate')}}",
                method : "POST",
                datatype : "JSON",
                data : {
                    appointment : appointment
                },
                success:function(r){
                    if(r.response){
                        toastr.info(r.message);
                    }
                },
                error:function(r){
                    console.log(r);
                }

            });
        });

        $(document).on('click', '#changepassword', function(){
            var changepassword = $('#passwordchange').val();
            $.ajax({
                url : "{{ url('api/editprofile') }}",
                method : "POST",
                datatype : "JSON",
                data : {
                    changepassword : changepassword,
                    user_id : user_id
                },
                success:function(r){
                    if(r.response){
                        toastr.success(r.message);
                        $('#profile').modal("toggle");
                    }
                },
                error:function(r){
                    console.log(r);
                }
            });
        });

        $('#appointment').datetimepicker();

        $(document).on('click', '#reserve', function(){
            var appointment = $('#appointmentInner').val();
            // console.log(appointment);
            $.ajax({
                url: "{{ url('api/appointmentInner') }}",
                method: "POST",
                datatype: "JSON",
                data: {
                    user_id : user_id,
                    appointment : appointment
                },
                success:function(r){
                    if(r.response){
                        $('#makeAppointment').modal("toggle");
                        toastr.success(r.message);
                        reloadUserTable();
                    }
                    
                    if(!r.response){
                        // console.log("I went here");
                        toastr.error(r.message);
                    }
                    
                },
                error:function(r){
                    toastr.error(r.message);
                }
            });

        });
        

        $('#appointmentAdmin').on('click', 'tbody tr', function(){
            var data = appointmentAdmin.row(this).data();
            console.log(data);

            // $('#userinfoappointment').modal("toggle");

            $.ajax({
                url: "{{ url('api/loadDataAppointment') }}",
                method: "POST",
                datatype: "JSON",
                data: {
                    data: data
                },
                success:function(r){
                    // console.log(r.response);
                    // console.log(r.response.appointment);
                    $('#userinfoappointment').modal("toggle");
                    $('#appointmentData').val(r.response.appointment);
                    $('#fullname').val(r.response.name);
                    $('#appointId').val(r.response.appointmentId);
                },
                error:function(r){
                    console.log(r);
                }
            });

        });

        $('#appointmentUser').on('click', 'tbody tr', function(){
            var data = appointmentUser.row(this).data();
            console.log(data);

            $.ajax({

                url : "{{ url('api/payment') }}",
                method : "POST",
                datatype : "JSON",
                data : {
                    data : data
                },
                success:function(r){
                    if(r.response){
                        console.log(r.query[0].mode_of_payment);
                        $('#userpayment').modal("toggle");
                        $('#pid').val(r.query[0].date);
                        $('#amount').val(r.query[0].payment);
                        if(r.query[0].is_paid == 0){
                            $('#settled').val("No");
                        }else{
                            $('#settled').val("Yes");
                        }
                        if(r.query[0].mode_of_payment != null){
                            $('#modeofpayment').attr('disabled', 'disabled');
                            $('#modeofpayment').val(r.query[0].mode_of_payment);
                        }
                    }
                },
                error:function(r){
                    console.log(r);
                    toastr.info("Already made a payment");
                }

            });
        });

        $(document).on('click', '#payment', function(){
            var modeofpayment = $('#modeofpayment').val();
            var paymentid = $('#pid').val();

            $.ajax({

                url : "{{ url('api/makepayment') }}",
                method : "POST",
                datatype : "JSON",
                data : {
                    modeofpayment : modeofpayment,
                    paymentid : paymentid
                },
                success:function(r){
                    // console.log(r);
                    if(r.response){
                        $('#userpayment').modal("toggle");
                        toastr.info(r.message);
                    }
                },
                error:function(r){
                    console.log(r);
                }

            });

        });

        $(document).on('click', '#approve', function(){
            var appointId = $('#appointId').val();
            // console.log(appointId);

            $.ajax({

                url: "{{ url('api/approveAppointment') }}",
                method: "POST",
                datatype: "JSON",
                data: {
                    appointId : appointId
                },
                success:function(r){
                    console.log(r);
                    reloadAppointmentTable();

                    $('#appointmentData').val('');
                    $('#fullname').val('');
                    $('#appointId').val('');
                },
                error:function(r){
                    console.log(r);
                }

            });

        });

        $(document).on('click', '#done', function(){
            var appointId = $('#appointId').val();

            $.ajax({

                url: "{{ url('api/approveAppointmentDone') }}",
                method: "POST",
                datatype: "JSON",
                data: {
                    appointId : appointId
                },
                success:function(r){
                    console.log(r);
                    reloadAppointmentTable();

                    $('#appointmentData').val('');
                    $('#fullname').val('');
                    $('#appointId').val('');
                },
                error:function(r){
                    console.log(r);
                }

            });

        });

    });

    function reloadUserTable(){
        $('#appointmentUser').DataTable().ajax.reload();
    }

    function reloadAppointmentTable(){
        $('#appointmentAdmin').DataTable().ajax.reload();
        $('#userinfoappointment').modal("toggle");
        $('#calendarAdmin').fullCalendar('removeEvents');
        $('#calendarAdmin').fullCalendar('refetchEvents');
    }

    function loadUserTable(){

        appointmentUser = $('#appointmentUser').DataTable({
            processSide: true,
            serverSide: true,
            ajax: {
                type: "GET",
                url: "{{ url('api/loadTableUser') }}",
                data : {
                    user_id : user_id
                },
            },
            columns: [
                {data: 'date', name: 'date'},
                {data: 'approved', name: 'approved'},
                {data: 'done', name: 'done'}
            ]
        });
    }

    function loadTable(){

        appointmentAdmin = $('#appointmentAdmin').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                type: "get",
                url: "{{ url('api/loadAppointment') }}",
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'appointment', name: 'appointment'},
                {data: 'approved', name: 'approved'},
                {data: 'done', name: 'done'},
                {data: 'is_paid', name: 'is_paid'}
            ]
        });
    }

    function loadCalendarAdmin(){
        $('#calendarAdmin').fullCalendar({
            eventSources: [{
                url: "{{ url('api/loadAllCalendar') }}",
                type: "POST",
                error: function(r){
                    console.log(r);
                },
                success:function(r){
                    console.log(r);
                },
                color: 'black',
                textColor: 'white'
            }]
        });
    }

    function loadCalender(){

        $('#calendar').fullCalendar({

            eventSources: [
            // your event source
            {
              url: '{{ url('api/loadMyAppointment') }}',
              type: 'POST',
              data: {
                user_id : user_id
              },
              error: function(r) {
                console.log(r);
              },
              color: 'black',   // a non-ajax option
              textColor: 'white' // a non-ajax option
            }

            // any other sources...

          ]

            // eventSources: [
            //     url: "{{ url('api/loadMyAppointment') }}",
            //     type: "POST",
            //     data: {
            //         user_id : user_id
            //     },
            //     error:function(r){
            //         console.log(r);
            //     },
            //     color: 'red',
            //     textColor: 'black'
            // ]

        });

        
        
    }
</script>
@endsection