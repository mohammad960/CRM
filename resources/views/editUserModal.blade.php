<div id="editUserModal" class="modal" style="display:block;" >

    <div id="usersModal" class="modal-content">
        <div class="modal_title">
            Edit User
        </div>
        <form action="{{route('user.update',$user)}}" method="post" enctype="multipart/form-data">
		 {{ csrf_field() }}
			{{ method_field('PATCH') }}

            <div class="modal_inputs">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" value="{{$employee_user->first_name}}" name="first_name" id="fname" placeholder="First Name"  required>
                            <label for="fname">First Name</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" value="{{$employee_user->last_name}}" name="last_name" id="lname" placeholder="Last Name" required>
                            <label for="lname">Last Name</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                            <select class="form-select" id="department" name="department_id" aria-label="department" style="height: 40px;">
                              <option value="{{$employee_user->department_id}}">{{$user->department}}</option>
							  @foreach ($departments as $d)
                              <option value="{{$d->id}}">{{$d->name}}</option>
                             @endforeach
                            </select>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <select class="form-select" id="position" name="position_id" aria-label="position" style="height: 40px;">
                        
						   <option value="{{$employee_user->position_id}}">{{$user->position}}</option>
                           @foreach ($positions as $p)
                              <option value="{{$p->id}}">{{$p->part_project}}</option>
                             @endforeach
                            </select>
                        </select>

                     </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" value="{{$employee_user->hour_cost}}" name="hour_cost" id="hour_cost" placeholder="Hour Cost">
                            <label for="hour_cost" required>Hour Cost (s.p)</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" value="{{$employee_user->target_hours}}" name="target_hours" id="target_hours" placeholder="Target Hours">
                            <label for="target_hours" required>Target Hours</label>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" value="{{$employee_user->start_job}}" name="start_job" id="start_date" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" required>
                            <label id="fstart_date" for="start_date"  >Start Working Date</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" value="{{$user->user_name}}" name="user_name" id="uusername" placeholder="Username" required>
                            <label for="username"  >Username</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="password" class="form-control"  name="password" id="upassword" placeholder="Password" required>
                            <label for="password" >Password</label>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" value="{{$employee_user->over_price}}" name="over_price" id="overtime_price" placeholder="Overtime Hour Price" required>
                            <label for="overtime_price" >Overtime Hour Price (s.p)</label>
                        </div>
                    </div>
 
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="responsibilities" name="responsibilities" style="width:801px; height:79px;">{{$employee_user->responsibilities}}</textarea>
                            <label for="floatingTextarea">Responsibilities </label>
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
					</br>
                                <label for="file-upload" class="custom-file-upload">
                                    <i><img src="{{asset('icons/attach.svg')}}" style="width:20px; height:20px;"/></i>
                                     Attach User Image
                                </label>
                                <input class="" name="image" id="file-upload" type="file"/>
                        </div>
                    
                </div>

            </div>
            <div class="modal_btns">
                <button id="modal_cancel" class="modal_btn close"><i><img src="{{asset('icons/x.svg')}}" style="width:12px; height:12px;"/></i>Cancel</button>
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
  </script>
