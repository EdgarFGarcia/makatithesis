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
        <label id="username">Username: {{Auth::User()->username}}</label>
        <input type="text" id="username" class="form-control" placeholder="{{Auth::User()->username}}" />

        <label for="firstname">First Name: {{Auth::User()->firstname}}</label>
        <input type="text" class="form-control" id="firstname" placeholder="{{Auth::User()->firstname}}" />

        <label for="middlename">Middle Name: {{Auth::User()->middlename}}</label>
        <input type="text" class="form-control" id="middlename" placeholder="{{Auth::User()->middlename}}">

        <label for="lastname">Last Name: {{Auth::User()->lastname}}</label>
        <input type="text" id="lastname" class="form-control" placeholder="{{Auth::User()->lastname}}">

        <label for="bday">Birth Date:{{ Auth::User()->bday }}</label>
        <div class="input-group birthdateinner" id="bday" data-target-input="nearest">
            <input type="text" class="form-control datetimepicker-input" id="bdayProfile" data-target="#bday"/>
            <div class="input-group-append" data-target="#bday" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>

        <label id="mobilenumber">Mobile Number: {{Auth::User()->mobilenumber}}</label>
        <input type="number" id="mobilenumber" class="form-control" placeholder="{{Auth::User()->mobilenumber}}" />
        
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