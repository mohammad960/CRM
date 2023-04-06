@extends('employees.home.app')
  <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>
    
@section('topnav')
<header class="dash-toolbar">
    <style>
      .pbig_circle{
        display:flex;
        justify-content:center;
        align-items:center;
        margin-top:6%;
      }
      .abig_circle{
        display:flex;
        justify-content:center;
        align-items:center;
        margin-top:6%;
      }
      @media (max-width:800px){
        .abig_circle{
          margin-top:20% !important;
        }
        .pbig_circle{
          margin-top:20% !important;
        }
        .current-projects{
          margin-top:10%;
        }
      }
      @media (max-width:600px){
        .abig_circle{
          margin-top:35% !important;
        }
        .pbig_circle{
          margin-top:35% !important;
        }
        .current-projects{
          margin-top:20%;
        }
      }
    </style>

    <div class="main-label">
       Home
    </div>
    <div class="tools">

     @include('notification')
     @include('employees.home.header')
        

    </div>
</header>
@endsection

@section('main')
				<div id="start" style="display:{{$new_attend}}">
					<p class="p1">Attendance</p>
          <div class="pbig_circle">
            <div class="present-circle">
              <i><img src="icons/Ellipse 18.svg"/>  </i>
            </div>
            <div class="present-circle2">
              <i><img src="icons/Ellipse 19.svg"/>  </i><span id="presentText">I'm Present Now</span>
            </div>
          </div> 
				</div>
					<div id="finish" style="display:{{$old_attend}};">
					<p class="p1">Attendance</p>
					<p class="p2">You Are In Since {{$hour}}</p>
          <div class="abig_circle">
            <div class="finished-circle">
              <i><img src="icons/fEllipse 18.svg"/>  </i>
            </div>
            <div class="finished-circle2">
            
              <i><img src="icons/fEllipse 19.svg"/>  </i><span id="finishedText">I'm Finished</span>
            </div>
          </div>
				</div>
                <div class="current-projects">
                    <span id="pcurrent">Current Projects You Are In</span>

                    <table class="pro-table" style="width:100%">
                        <thead>
                            <th width="303px">Project Name</th>
                            <th width="277px">Timeline</th>
                            <th width="186px">Working Hours</th>
                            <th width="168px">Backup Hours</th>
                        
                        </thead>
                        <tbody>
						@foreach ($employee->projects as $p)
							@if($p->status=="In Progress")
                            <tr>
                                <td > <i class="project_name"><img src='/storage/quotation/{{$p->image}}' /></i> <a href="/project/tasks/{{$p->id}}" class="project_text">{{$p->project_name}}</a></td>
                                <td>
                                    <span class="prog_startdate">{{$p->start_date}}</span> <span class="prog_enddate">{{$p->end_date}}</span>
                                    <center>
                                    <div class="progress" style="height: 6.34px; border-radius: 5px; width:90%">
                                    <div class="progress-bar bg-{{$p->style}}" role="progressbar" style="width: {{$p->remaining}}% ;border-radius: 5px;" aria-valuenow="{{$p->remaining}}" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div> </center>
                                </td>
                                <td class="text-{{$p->info->hours_style}}">{{$p->info->hours}}/{{$p->info->expected_hours}}</td>
                                <td class="text-{{$p->info->over_style}}">{{$p->info->back_work_hours}}/{{$p->info->backup_hours}}</td>
                              </tr>
							  @endif
						@endforeach
                            
                        </tbody>
                    </table>

                </div>

                <div class="time-balert row" style="margin-bottom:-1%;">
                  <div class="col-md-6">
                      Your total hours this month
                  </div>
                  <div class="col-md-3">
                      Working Hours: {{$employee->my_work}} H 
                  </div>
                  <div class="col-md-3">
                      <span class="text-success"> Overtime Hours: {{$employee->over_work}} H  </span>
                  </div>
                </div>

  
        
</div>
@endsection
<script>

  $(document).on('click','#finishedText',function(event){
      event.preventDefault();

      let id = "{{$id}}";
      let _token   = $('meta[name="csrf-token"]').attr('content');
		console.log(_token);
      $.ajax({
        url: "{{route('attendance.update',$id)}}",
        type:"post",
        data:{
          id:id,
          _token: _token
        },
        success:function(response){
          console.log(response);
          if(response) {
			window.location.href = "{{URL::to('attendance')}}"
          }
        },
        error: function(error) {
         console.log(error);
        
        }
       });
  });
  $(document).on('click','#presentText',function(event){
      event.preventDefault();

      let id = "{{$id}}";
      let _token   = $('meta[name="csrf-token"]').attr('content');
console.log(_token);
      $.ajax({
        url: "{{route('attendance.store')}}",
        type:"post",
        data:{
          id:id,
          _token: _token
        },
        success:function(response){
          console.log(response);
          if(response) {
           window.location.href = "{{URL::to('attendance')}}"
          }
        },
        error: function(error) {
         console.log(error);
        
        }
       });
  });
</script>