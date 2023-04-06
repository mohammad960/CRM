
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
<div id="projectModal" class="modal">

    <div id="projectsModal" class="modal-content">
        <div class="modal_title">
            Add New Project
        </div>
        <form action="{{route('project.store')}}" method="post" enctype="multipart/form-data">
          @csrf
            <div class="modal_inputs">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="project_name" id="pname" placeholder="Project Name">
                            <label for="pname">Project Name</label>

                        </div>
                    </div>


                    <div class="col-md-4">
                        <select class="form-select" id="client" name="client_id" aria-label="client" style="height: 40px;">
                          <option selected>Client</option>
                           @foreach ($clients as $c)
						      <option value="{{$c->id}}">{{$c->compnay_name}}</option>
						   @endforeach
                        </select>

                    </div>
                    <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="start_date" id="start_date" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label class="date_label" id="fstart_date" for="start_date">{{__('Start Date')}}</label>
                            </div>
                    </div>



                </div>
                <div class="row">
                    <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="end_date" id="due_date" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label class="date_label" id="fdue_date" for="due_date">{{__('Due Date')}}</label>
                            </div>
                        </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="price" id="price" placeholder="Price">
                            <label for="price">Price</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="currency" name="currency_id" aria-label="currency" style="height: 40px;">
                          <option selected> Currency</option>
                          @foreach ($currency as $c)
						      <option value="{{$c->id}}">{{$c->sp_value}} s.p -{{$c->us_value}} $</option>
						   @endforeach
                        </select>

                     </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="expected_hours" id="expected_hours" placeholder="Expected Hours">
                            <label for="expected_hours">Expected Hours</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="admin_hours" id="backup_hours" placeholder="Backup Hours">
                            <label for="backup_hours">Total Admin Hours</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="status" name="status" aria-label="status" style="height: 40px;">
                            <option selected> Status </option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select>
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
                <a id="modal_cancel" class="modal_btn close"><i><img src="{{asset('icons/x.svg')}}" style="width:12px; height:12px;"/></i> cancel</a>
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
