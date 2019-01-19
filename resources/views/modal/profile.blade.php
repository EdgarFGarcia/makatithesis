<!-- Modal -->
<div class="modal fade" id="profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Profile Of: {{Auth::User()->username}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="user_id" value="{{Auth::User()->id}}"/>
        <label>Username: {{Auth::User()->username}}</label><br/>
        <label>Fullname: {{Auth::User()->lastname}}, {{Auth::User()->firstname}} {{Auth::User()->middlename}}</label><br/>
        <label>Landline Number: {{Auth::User()->phonenumber}}</label><br/>
        <label>Mobile Number: {{Auth::User()->mobilenumber}}</label><br/>
        <label for="password">Change Password</label>
        <input type="password" class="form-control" id="passwordchange"/>
        <label></label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="changepassword">Save changes</button>
      </div>
    </div>
  </div>
</div>