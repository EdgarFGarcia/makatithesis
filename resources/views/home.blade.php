@extends('layouts.main')

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
            </tr>
        </thead>
    </table>
@else
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
@endsection

@section('scripts')
<script type="text/javascript">

    var appointmentAdmin;
    var appointmentUser;

    $(document).ready(function(){
        loadTable();
        loadUserTable();

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

    function reloadAppointmentTable(){
        $('#appointmentAdmin').DataTable().ajax.reload();
        $('#userinfoappointment').modal("toggle");
    }

    function loadUserTable(){

        // $.ajax({
        //     url: "{{ url('api/loadTableUser') }}",
        //     method: "GET",
        //     datatype: "JSON",
        //     success:function(r){
        //         console.log(r);
        //     },
        //     error:function(r){
        //         console.log(r);
        //     }
        // });

        appointmentUser = $('#appointmentUser').DataTable({
            processSide: true,
            serverSide: true,
            ajax: {
                type: "GET",
                url: "{{ url('api/loadTableUser') }}",
            },
            columns: [
                {data: 'date', name: 'date'},
                {data: 'approved', name: 'approved'},
                {data: 'done', name: 'done'}
            ]
        });
    }

    function loadTable(){

        // $.ajax({
        //     url: "{{ url('api/loadAppointment') }}",
        //     method: "GET",
        //     datatype: "JSON",
        //     success:function(r){
        //         console.log(r);
        //     },
        //     error:function(r){
        //         console.log(r);
        //     }
        // });

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
                {data: 'done', name: 'done'}
            ]
        });
    }
</script>
@endsection