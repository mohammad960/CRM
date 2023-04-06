@extends('employees.home.app')
  <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>

    <style>
    #search_bar input{
        top:-20px !important;
        width: 234px !important;
        left: 77% !important;
    }
    #search_btn{
        margin-left:5.5%;
    }

    .task-list table thead th{
    position: sticky !important;
    top: 0px !important;
    z-index:100;
    
    }
    .task-list {
        height: 330px;
        overflow-y:auto;
    }
    
    </style>
@section('topnav')
<header class="dash-toolbar">

    <div class="main-label">
	{{$project->project_name}}
       <div class="duedate-progress">
        <div class="progress" style="height: 6.34px; border-radius: 5px; width: 177px;">
            <div class="progress-bar bg-{{$project->style}}" role="progressbar" style="width: {{$project->remaining}}% ;border-radius: 5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>

        </div>
        <span class="duedatelabel">
            Due Date {{$project->end_date}}
        </span>
       </div>
    </div>
    <div class="tools">
        @include('notification')
		@include('employees.home.header')
    </div>
</header>
@endsection
@section('main')
				<div class="collegues">
				@foreach ($project->employees as $e)
				<i><img class="" src="/storage/employee/{{$e->image}}" style="width:24px; height:24px; " alt="profile"></i>
				@endforeach
                </div>
                <div id="search_bar">
                    <form action="" method="get">
                        <input type="text" class="" placeholder="Search">
                    </form>
                    <button type="submit" id="search_btn">
                        <i><img class="" src="{{asset('icons/search_icon.svg')}}" style="width:17px; height:17px; " alt=""></i>
                    </button>
                </div>


                <div class="tltbl" >
                    <table class="tl-table" width="100%">
                        <thead style="width: 1078px; height: 40px;">
                            <th width="664px">Timeline</th>
                            <th width="269px">Working Hours</th>
                            <th width="265px">Backup Hours</th>
                        </thead>
                        <tbody >
                            <tr>
                                <td>
                                     <span class="tlprog_enddate">{{$project->info->hours}}/{{$project->info->expected_hours}}</span>
                                    <center>
                                    <div class="progress tlprogress" style="height: 6.34px; border-radius: 5px;">
                                        <div class="progress-bar bg-{{$project->info->style}}" role="progressbar" style="width: {{$project->info->remaining}}% ;border-radius: 5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div> </center>
                                </td>
                                <td><span class="tl-text">{{$project->info->hours}}/{{$project->info->expected_hours}}</span></td>
                                <td><span class="tl-text">{{$project->info->back_work_hours}}/{{$project->info->backup_hours}}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="task-list" style="">

                    <table class="tasks-table" style="width: 100%; " >
                        <thead  style="width: 100%; height: 40px;">
                            <tr>
                            <th width="660px">List of My Tasks</th>
                            <th width="120px">Start Date</th>
                            <th width="112px">End Date</th>
                            <th width="108px">Start Time</th>
                            <th width="108px">End Time</th>
							 <th width="108px">Hours </th>
                        </tr>
                        <tr style="height: 16px;"></tr>
                        </thead>
                        <tbody>
						@foreach ($tasks as $t)
                            <tr>
                                <td>
								{{$t->description}}
                                </td>
                                <td>
								{{explode(" ",$t->start_date)[0]}}
                                </td>
								
                                <td>
								@if($t->end_date)
                                   {{explode(" ",$t->end_date)[0]}}
							    @endif
                                </td>
							  
                                <td>
                                   {{explode(" ",$t->start_date)[1]}}
                                </td>
                                <td>
								@if($t->end_date)
									{{explode(" ",$t->end_date)[1]}}
								@endif
                                </td>
							   <td>
							   <?php
							   echo intval(($t->hours/60)).' H :'.($t->hours%60)." m"
							   ?>
							   </td>
                            </tr>
						@endforeach
                          
                        </tbody>
                    </table>
                </div>
				@if(count($in_task) ==0  && $project->remaining!=100 && !$employee->have_task)
				<div class="rect-black">
					</div>

					<div class="task-box">

						<div class="task-box-text">
						   <input type="text" style="width:100%" id="description" placeholder="Your Task ...">
						   <span id="description_err"></span>
						</div>

						<div class="task-box-btn">

							<button id="add_new_btn">
								<i><img src="{{asset('icons/okmark.svg')}}" style="width:20px; height:20px;"/></i> Create Task
							   </button>

						</div>

					</div>
				 @endif 
@if(count($in_task) !=0 && $project->remaining!=100)
@include('reminder', ['c' => 1,'id'=>$in_task[0]->id,'description'=>$in_task[0]->description,'date'=>$in_task[0]->start_date])
 @endif 
 @if($project->remaining==100)
@include('reminderw', ['c' => 0,'description'=>'Time For project finished'])
 @endif 
  @if($employee->have_task)
@include('reminderw', ['c' => 0,'description'=>$employee->message_task])
 @endif 
@endsection

<script>
$(document).on('click','#add_new_btn',function(event){
      event.preventDefault();

      let project_id = "{{$project->id}}";
	  let description =document.getElementById('description').value;
	  if(description ==""){
		   document.getElementById('description_err').style.color="red";
		  document.getElementById('description_err').innerHTML="Enter Description Here.....";
		 
		  return 0;
	  }
      let _token   = $('meta[name="csrf-token"]').attr('content');
		console.log(_token);
      $.ajax({
        url: "{{route('task.store')}}",
        type:"post",
        data:{
          project_id:project_id,
		  description:description,

          _token: _token
        },
        success:function(response){
          console.log(response);
          if(response) {
			
			window.location.href = "{{URL::to('/project/tasks/')}}"+"/"+"{{$project->id}}";
          }
        },
        error: function(error) {
         console.log(error);
        
        }
       });
  });
</script>