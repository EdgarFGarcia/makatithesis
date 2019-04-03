<div class="modal fade" id="makeAppointment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Make Appointment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="appointment">Appointment</label>
        <div class="input-group date" id="appointment" data-target-input="nearest">
            <input type="text" class="form-control datetimepicker-input" id="appointmentInner" data-target="#appointment"/>
            <div class="input-group-append" data-target="#appointment" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
            <button class="btn btn-info" id="checkInner">Check</button>
        </div>
        <label for="appointmentType">Appointment Type</label>
        <select name="appointmentType" id="appointmentType" class="form-control"></select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="reserve">Save</button>
      </div>
    </div>
  </div>
</div>