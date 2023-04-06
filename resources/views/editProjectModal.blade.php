
<style>

input[type="file"] {
    display: none;
    }
    .custom-file-upload {
        width:205px;
        height:40px;
        background: #4495F1;
        border-radius: 8px;
        border: 1px solid #4495F1 ;
        display: inline-block;
        padding: 4px 12px;
        cursor: pointer;
        margin-bottom:0px;
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 400;
        font-size: 17px;
        line-height: 32px;
        /* identical to box height */
        color: #FFFFFF;
    }
</style>
<div id="editProjectModal" class="modal" style="display:block;">

    <div id="projectsModal" class="modal-content">
        <div class="modal_title">
            Edit Project {{$project->project_name}}
        </div>
        <form action="{{route('project.update',$project)}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
			{{ method_field('PATCH') }}
            <div class="modal_inputs">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="project_name" value="{{$project->project_name}}" id="pname" placeholder="Project Name">
                            <label for="pname">Project Name</label>

                        </div>
                    </div>

                    <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" value="{{$project->start_date}}"  class="form-control" name="start_date" id="start_date" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label id="fstart_date" for="start_date">{{__('Start Date')}}</label>
                            </div>
                    </div>
					<div class="col-md-4">
                    <div class="sform-floating">
                        <select class="form-select" id="client" name="client_id" aria-label="client" style="height: 40px;">

                          <option value="{{$project->client->id}}" selected>{{$project->client->compnay_name}}</option>
                           @foreach ($clients as $c)
						    @if($c->id != $project->client->id)
						      <option value="{{$c->id}}">{{$c->compnay_name}}</option>
						   @endif
						   @endforeach
                        </select>
                        <label class="select_label" for="client_id">Client</label>
                   </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" value="{{$project->end_date}}"  class="form-control" name="end_date" id="due_date" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label id="fdue_date" for="due_date">{{__('Due Date')}}</label>
                            </div>
                        </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" value="{{$project->price}}"  name="price" id="price" placeholder="Price">
                            <label for="price">Price</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                    <div class="sform-floating">
                        <select class="form-select" id="currency" name="currency_id" aria-label="currency" style="height: 40px;">
                          <option value="{{$project->currency->id}}" selected> {{$project->currency->sp_value}} s.p -{{$project->currency->us_value}} $</option>
                          @foreach ($currencies as $c)
						     @if($c->id != $project->currency->id)
						      <option value="{{$c->id}}">{{$c->sp_value}} s.p -{{$c->us_value}} $</option>
						  @endif
						   @endforeach
                        </select>
                        <label class="select_label" for="currency_id">Currency</label>
                   </div>
                     </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" value="{{$project->expected_hours}}"  name="expected_hours" id="expected_hours" placeholder="Expected Hours">
                            <label for="expected_hours">Expected Hours</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" value="{{$project->admin_hours}}"  name="admin_hours" id="backup_hours" placeholder="Backup Hours">
                            <label for="backup_hours">Total Admin Hours</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                    <div class="sform-floating">
                        <select class="form-select" id="status"   name="status" aria-label="status" style="height: 40px;">
                            <option value="{{$project->status}}" selected> {{$project->status}} </option>
                            <option value="Not started">Not started</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Canceled">Canceled</option>
							   <option value="Done">Done</option>
                          </select>
                        <label class="select_label" for="status">Status</label>
                   </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4">

                                <label for="file-upload" class="custom-file-upload">
                                    <i><img src="{{asset('icons/attach.svg')}}" style="width:20px; height:20px;"/></i>
                                     Attach Project Image
                                </label>
                                <input class="" name="image" id="file-upload" type="file"/>
                        </div>

                </div>

            </div>
            <div class="modal_btns">
                <button id="modal_cancel" class="modal_btn close"><i><img src="{{asset('icons/x.svg')}}" style="width:12px; height:12px;"/></i> Cancel</button>
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
      $("#due_date").on("focus", function(){
        var start = document.getElementById("due_date");
        start.type = 'date';
      });
  </script>
