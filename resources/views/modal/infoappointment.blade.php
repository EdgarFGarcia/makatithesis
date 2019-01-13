<div class="modal" id="userinfoappointment">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Appointment Information</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <!-- <label id="appointId"></label><br/>
        <label id="fullname">Name: </label><br/>
        <label id="appointmentData">Appointment Date: </label> -->
        <label for="appointId">Appointment ID:</label>
        <input type="text" id="appointId" class="form-control" disabled />

        <label for="fullname">Name: </label>
        <input type="text" id="fullname" class="form-control" disabled />

        <label for="appointmentData">Appointment Date: </label>
        <input type="text" id="appointmentData" class="form-control" disabled />
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="approve">Approve</button>
        <button type="submit" class="btn btn-success" id="done">Done</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>