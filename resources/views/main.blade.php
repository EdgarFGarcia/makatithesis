@extends('welcome')

@section('content')
<div class="container">
	<nav>
	  <div class="nav nav-tabs" id="nav-tab" role="tablist">
	    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Customer Info</a>
	    <!-- <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Appointment</a>
	    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Payment Method</a> -->
	  </div>
	</nav>
	<div class="tab-content" id="nav-tabContent">
	  	<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
	  		@include('inner.innerhome')
		</div>
	  	<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
	  		@include('inner.innerprofile')
	  	</div>
	  	<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
	  		@include('inner.innercontact')
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script>
	$(document).ready(function(){
		$('#datetimepicker1').datetimepicker();

		$('#mobilenumber').keyup(function(){
			var prefix = "63";
			if(this.value.indexOf(prefix) !== 0){
				this.value = prefix + this.value;
			}
		});

		$(document).on('click', '#save', function(){
			var firstname = $('#firstname').val();
			var middlename = $('#middlename').val();
			var lastname = $('#lastname').val();
			var phonenumber = $('#phonenumber').val();
			var mobilenumber = $('#mobilenumber').val();
			var emailaddress = $('#emailaddress').val();
			var date = $('#appontment').val();

			$.ajax({
				url: "{{ url('api/appoint') }}",
				method: "POST",
				datatype: "JSON",
				data:{
					firstname : firstname,
					middlename : middlename,
					lastname : lastname,
					phonenumber : phonenumber,
					mobilenumber : mobilenumber,
					emailaddress : emailaddress,
					appointment : date
				},
				success:function(r){
					// console.log(r);
					if(r.response){
						toastr.success("Appointment Successful");
						$('#firstname').val('');
						$('#middlename').val('');
						$('#lastname').val('');
						$('#phonenumber').val('');
						$('#mobilenumber').val('');
						$('#emailaddress').val('');
						$('#appontment').val('');
					}
					if(!r.response){
                        // console.log("I went here");
                        toastr.error(r.message);
                    }
				},
				error:function(r){
					if(r.message = "The given data was invalid."){
						toastr.error("User Already Exist, Please Login");
					}				
				}
			});

		});

	});
</script>
@endsection