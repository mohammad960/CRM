

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
		
  
        
  
</div>
