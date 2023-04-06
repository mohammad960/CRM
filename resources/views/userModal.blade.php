
<div id="userModal" class="modal">

    <div id="usersModal" class="modal-content">
        <div class="modal_title">
            Add New User
        </div>
        <form action="{{route('user.store')}}" method="post" enctype="multipart/form-data">
		@csrf

            <div class="modal_inputs" style="">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="first_name" id="fname" placeholder="First Name" required>
                            <label for="fname">First Name</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="last_name" id="lname" placeholder="Last Name" required>
                            <label for="lname">Last Name</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                    <div class="sform-floating">
                        <select class="form-select" id="department" name="department_id" aria-label="department" style="height: 40px;">
							  @foreach ($departments as $d)
                              <option value="{{$d->id}}">{{$d->name}}</option>
                             @endforeach
                            </select>
                        <label class="select_label" for="department">Department</label>
                   </div>        
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="sform-floating">
                            <select class="form-select" id="position" name="position_id" aria-label="position" style="height: 40px;">
                            @foreach ($positions as $p)
                                <option value="{{$p->id}}">{{$p->part_project}}</option>
                            @endforeach
                            </select>
                        </select>
                            <label class="select_label" for="position">Position</label>
                        </div>
                        

                     </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="hour_cost" id="hour_cost" placeholder="Hour Cost">
                            <label for="hour_cost" required>Hour Cost (s.p)</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="target_hours" id="target_hours" placeholder="Target Hours">
                            <label for="target_hours" required>Target Hours</label>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="date" class="form-control" name="start_job" id="start_date" placeholder="" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" required>
                            <label id="fstart_date" for="start_date">Start Working Date</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="user_name" id="uusername" placeholder="Username" required>
                            <label for="username">Username</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="password" class="form-control" name="password" id="upassword" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="over_price" id="overtime_price" placeholder="Overtime Hour Price" required>
                            <label for="overtime_price">Overtime Hour Price (s.p)</label>
                        </div>
                    </div>
                    <div class="col-md-6" style="padding-top:10px;">
                        Role:
                            <input class="form-check-input" type="radio" name="role_id"  value="2" id="role1" style="margin-left: 92px;" checked>
                            <label class="form-check-label" for="role1" style="margin-left: 122px;">
                              Employees
                            </label>

                            <input class="form-check-input" type="radio" name="role_id" value="1" id="role2" style="margin-left: 42px;" >
                            <label class="form-check-label" for="role2" style="margin-left: 72px;">
                              Admin
                            </label>

                    </div>
                    
                </div>
                <div class="row" id="checks_admin" style="display:none;">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6" style="padding-top:10px;margin-left:8%;">
                        Notification:
                            <input class="form-check-input" type="radio" name="notification"  value="fin" id="not1" style="margin-left: 42px;">
                            <label class="form-check-label" for="not1" style="margin-left: 72px;">
                              Finance
                            </label>

                            <input class="form-check-input" type="radio" name="notification" value="tech" id="not2" style="margin-left: 62px;" >
                            <label class="form-check-label" for="not2" style="margin-left: 92px;">
                              Technical
                            </label>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="responsibilities" name="responsibilities" style=" width:80%; height:79px; border-radius:8px; padding:1%;"></textarea>
                            <label for="responsibilities">Responsibilities </label>
                          </div>
                    </div>
                </div>
			</br>
				   <div class="row">
                    <div class="col-md-4">
                                <label for="file-upload" class="custom-file-upload">
                                    <i><img src="{{asset('icons/attach.svg')}}" style="width:20px; height:20px;"/></i>
                                     Attach User Image
                                </label>
                                <input class="" name="image" id="file-upload" type="file"/>
                        </div>
                    
                </div>
            </div>
            <div class="modal_btns">
                <a id="modal_cancel" class="modal_btn close"><i><img src="{{asset('icons/x.svg')}}" style="width:12px; height:12px;"/></i> Cancel</a>
                <button id="modal_save" class="modal_btn btnsave"><i><img src="{{asset('icons/okmark.svg')}}" style="width:20px; height:20px;"/></i> Save </button>
            </div>

        </form>


    </div>

  </div>
  <script>
      $("#start_date").on("focus", function(){
        var start = document.getElementById("start_date");
        start.type = 'date';
      });

      $("#role1").on('click', function(){
        $("#checks_admin").toggle();
      });
      $("#role2").on('click', function(){
        $("#checks_admin").toggle();
      });
  </script>
