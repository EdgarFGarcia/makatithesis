<div class="col-md-12">
	<h4>Customer Information:</h4>
	<div class="row">
		<div class="col-md-4">
			<label for="firstname">First Name</label>
			<input type="text" class="form-control" placeholder="Joe" id="firstname" required="required" />
		</div>
		<div class="col-md-4">
			<label for="middlename">Middle Name</label>
			<input type="text" class="form-control" placeholder="Smith" id="middlename" required="required"/>
		</div>
		<div class="col-md-4">
			<label for="lastname">Last Name</label>
			<input type="text" class="form-control" placeholder="Stevens" id="lastname" required="required"/>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<label for="phonenumber">Birth Date</label>
			<div class="input-group bdate" id="datepickerbday" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" id="bday" data-target="#datepickerbday"/>
                <div class="input-group-append" data-target="#datepickerbday" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
		</div>
		<div class="col-md-4">
			<label for="mobilenumber">Mobile Number</label>
			<input type="text" class="form-control" placeholder="927xxxxxxx" id="mobilenumber">
		</div>
		<div class="col-md-4">
			<label for="emailaddress">Email Address</label>
			<input type="email" class="form-control" placeholder="admin@gmail.com" id="emailaddress" required="required">
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<label for="datetimepicker1">Appointment</label>
			<div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" id="appointment" data-target="#datetimepicker1"/>
                <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
                <button class="btn btn-info" id="check">Check</button>
            </div>
		</div>
		<div class="col-md-4">
			<label for="appointmentType">Appointment Type</label>
			<select name="appointmentType" id="appointmentType" class="form-control">
				
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<button type="submit" class="btn btn-success" id="save">Save</button>
		</div>
	</div>
</div>