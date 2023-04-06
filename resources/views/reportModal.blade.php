<div id="reportModal" class="modal" >
    <div id="reportsModal" class="modal-content">
        <div class="modal_title">
            Create New Projects Reports
        </div>
         <form action="{{route('project.report')}}" method="post">
          @csrf
            <div class="modal_inputs">

                <div class="row" style="margin-bottom:0px;">
                    <div class="col-md-6">
                        <div class="sform-floating">
                            <select class="form-select" id="project_namei" name="project_id" aria-label="client" style="height: 40px;">
                            @foreach ($all_projects as $e)
							    
								<option id="{{$e->id}}" value="{{$e->id}}">
								{{$e->project_name}}
								</option>
					
                            @endforeach
                            </select>
                        <label class="select_label" for="project_id">Project Name</label>
                       </div> 
                        
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" id="report_type" name="type" aria-label="report_type" style="height: 40px;">
                              <option selected value="0">All Details</option>
							    <option value="1">Technical</option>
                                <option value="2">Financial</option>
                        </select>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-2">
                        <div class="form-check">
                            <label class="form-check-label" for="">
                                Status:
                            </label>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="type1" >
                            <label class="form-check-label" for="type1">
                                By date
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="type2" checked>
                            <label class="form-check-label" for="type2">
                                Whole project
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row" id="dates" style="display:none">
                    <div class="col-md-6">
                    <i class="calendar2"> <img src="{{ asset('icons/calendar.svg') }}"></i>
                        <div class="form-floating">
                                <input type="text" class="form-control" name="start_date" id="due_date" placeholder="" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label class="date_label" id="fdue_date" for="due_date">
                                {{__('From Date of')}}
                                </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                    <i class="calendar2"> <img src="{{ asset('icons/calendar.svg') }}"></i>
                        <div class="form-floating">
                                <input type="text" class="form-control" name="end_date" id="due_date" placeholder="" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label class="date_label" id="fdue_date" for="due_date">{{__('To Date')}}</label>
                        </div>
                    </div>
                </div>
			</div>
			<div class="row" style="position:relative; float:right; left:40px; padding-bottom:15px; margin-top:-20px;">
                <div class="col-md-4">
                    <a id="modal_cancel" class="modal_btn close"><i><img src="{{asset('icons/x.svg')}}" style="width:12px; height:12px;"/></i> Cancel</a>
                </div>
                <div class="col-md-4">
                    <button id="modal_save" class="modal_btn btnsave"><i><img src="{{asset('icons/okmark.svg')}}" style="width:20px; height:20px;"/></i> Save </button>
                </div>
			</div>
			
        </form>

 </div>

 </div>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

 <script>
    $( function() {
    var availableTags = @json($auto_projects);
    console.log(availableTags);
    $( "#project_namei" ).autocomplete({
      source: availableTags
    });

     var bydate = $(".form-check-input");
    $(".form-check-input").on('change', function(){
    $("#dates").toggle();
 });
  } );
 </script>


