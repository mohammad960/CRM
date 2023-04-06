

<div class="{{ ($c)?'rect-success': 'rect-warning' }}">
</div>

<div class="{{ ($c)?'time-salert':'time-walert'}}">

    <div class="{{ ($c)?'time-success-text':'time-warning-text'}}">
       <b> {{$description}} </b>
    </div>
	<div class="timer">
		<i><img class="timer_icon" src="{{asset('icons/belt.svg')}} " style="width:25px; height:25px;"> </i>
	</div>
	<div id ="time_dur" class="left-time-wtext">
			<!--i><img class="timer" src="{{asset('icons/warning.svg')}} " style="width:39.72px; height:37.19px; " alt="profile"> </i-->
	</div>
			<form action="{{route('task.update',$id)}}" id="formId" method="post">
								 {{ csrf_field() }}
								{{ method_field('PATCH') }}
								<div class="ok-mark">
									<i><img class="timer_icon" onclick="submitDetailsForm()" src="{{asset('icons/ok-mark.svg')}} " style="width:30px; height:30px;"> </i>
								</div>
			</form>
  
        
</div>
<script>

setInterval(function () {
		var current = new Date();
		const s = "{{$date}}";
		const d = new Date(s);
		var tim_dur="";
		var dif = parseInt(( current.getTime() - d.getTime() ) / 1000);
		console.log(current);
		console.log(d);
		console.log(dif);
		if(dif < 60){
			tim_dur="0h : 0m : "+dif+"s";
		}
		if(dif > 60){
			hour=parseInt(dif/3600);
			min=parseInt((dif-(3600*hour))/60);
			seconds=dif-(3600*hour)-(min*60);
			tim_dur=hour+"h : "+min +"m : "+seconds+"s";
		}
	
	document.getElementById('time_dur').innerHTML = tim_dur
	}, 1000);
 function submitDetailsForm() {
       $("#formId").submit();
    }
</script>