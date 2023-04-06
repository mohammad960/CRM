<style>
.dash-toolbar{
 width: 100%;
 padding-left:0;
}
.dataTables_wrapper .dataTables_length select {
	 width: 50px;
	 height:30px;
	 padding:0px;
}
.dash-content{
 width: 100%;
}
#form{
    margin-left:25px;
    margin-top:5px;
}
#form-logout{
    margin-left:-10px;
    
}
#logout-btn{
    font-size:16px;
    color: #515151;
}
#emp_prof_menu{
    padding-top:10px;
}
</style>
<div class="dropdown tools-item">
            <span id="profile_username">
               {{Auth::user()->user_name}}
            </span>
         <i><img id="profile_pic" src="/storage/employee/{{$employee->image}}" style="width:32px; height:32px; border-radius:50%; border:1px solid black;" alt="profile"></i>
            <a href="#" class="" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i><img  id="emp_prof_menu" src="{{asset('icons/profile_menu.svg')}}" alt="profile"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1" style="height:120px;">
                <form action="{{route('user.image')}}" id="form" method="post" enctype="multipart/form-data">
				@csrf
                    <!--a class="dropdown-item" href="#!">Change profile pic</a-->
                    <label for="changeprofile" class="">
                            Change profile pic
                    </label>
                    <input class="" name="image" id="changeprofile" type="file" hidden/>
                </form>

                <center><hr style="width: 140px; padding: 0;margin: 0;"></center>
                	<form action="{{route('logout')}}" id="form-logout" method="post">
				   @csrf
                <button id="logout-btn"  type="submit" class="dropdown-item" href="/logout">Logout</button>
				</form>
            </div>

        </div>
<script>
document.getElementById("changeprofile").onchange = function() {
    document.getElementById("form").submit();
};
</script>