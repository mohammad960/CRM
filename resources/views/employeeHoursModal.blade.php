<div id="employeeHModal" class="modal">

    <div id="empHModal" class="modal-content" style="height:auto;">
        <div class="modal_title">
            Total Hours
        </div>
    
            <div class="modal_inputs" style="padding-left:20px;">
                <div class="row">
                    <div class="col-md-1">
                           <i><img src="" id="img_all" style="width:21px; height:21px;margin-right:8px;"/></i>
                    </div>
                    <div class="col-md-3" style="margin-left:-40px;">
                           <span id="all_name" style="font-family: 'Cairo';font-size: 16px; line-height: 26px; color: #051626;"> Mohamad Njeeb Shbib </span>
                    </div>
                    <div class="col-md-5"></div>
                   <div id="position_all" class="col-md-3" style=" right: -12%;">
                           
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" required value="0" class="form-control" name="exp_hours" id="exp_hours" style="width:251px;" placeholder="Expected Hours">
                            <label for="exp_hours">Expected Hours</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" class="form-control" name="back_hours" id="back_hours" required value="0" style="width:251px;" placeholder="Search Employee">
                            <label for="back_hours">Backup Hours</label>
                        </div>
                    </div>
                </div>

            
                <span id="emp_id" hidden></span>
				<span id="cost_hour" hidden></span>
				<span id="over_hour" hidden></span>
            </div>
            <div class="modal_btns" style="">
                <button id="modal_save" class="modal_btn btnsave" style="margin-top: -24px; margin-left: 90%;"><i><img src="{{asset('icons/okmark.svg')}}" style="width:20px; height:20px; "/></i> Accept </button>
            </div>



    </div>

  </div>
<script>
function getWeeksDiff(startDate, endDate) {
  const msInWeek = 1000 * 60 * 60 * 24 * 7;

  return Math.round(Math.abs(endDate - startDate) / msInWeek);
}
$( "#currency_id" ).change(function() {
	var select = document.getElementById('currency_id');
	var currency = select.options[select.selectedIndex].id;
	var cost=parseInt(document.getElementById("spvalue").innerHTML);
	document.getElementById("all_cost").innerHTML=parseInt(parseInt(cost)/parseInt(currency));
	document.getElementById("price").value=parseInt(parseInt(cost)/parseInt(currency));
});
$( "#modal_save" ).click(function() {
		var exp_hours=document.getElementById("exp_hours").value;
		var back_hours=document.getElementById("back_hours").value;
		var cost_hour=document.getElementById("cost_hour").innerHTML;
		var over_hour=document.getElementById("over_hour").innerHTML;
		if(document.getElementById("exp_hours").value==""){
			exp_hours=0;
		}
		if(document.getElementById("back_hours").value==""){
			back_hours=0;
		}
		var all_name=document.getElementById("all_name").innerHTML;
		
		var image=document.getElementById("img_all").src;
		var id=document.getElementById("emp_id").innerHTML;;
		hours.push(exp_hours);
		back.push(back_hours);
		employees.push(id);
		
		var cost=(parseInt(over_hour)*parseInt(exp_hours))+(parseInt(over_hour)*parseInt(back_hours));
		var select = document.getElementById('currency_id');
		var currency = select.options[select.selectedIndex].id;
		document.getElementById("spvalue").innerHTML=parseInt(document.getElementById("spvalue").innerHTML)+cost;
		cost=parseInt(cost/parseInt(currency));
		let sum_hours = 0;
		for (let x in hours) {
			
		  sum_hours = parseInt(sum_hours)+parseInt(hours[x]);
		}
		
		for (let x in back) {
		  sum_hours =parseInt(sum_hours)+ parseInt(back[x]);
		}
		document.getElementById("expected_hours").value=sum_hours;
		var start_date = new Date(document.getElementById("start_date").value);
		try{
			var dt = new Date(document.getElementById("start_date").value);
			var start_date = new Date(document.getElementById("start_date").value);
		}
		catch{
			dt= new Date();
			var start_date = new Date(document.getElementById("start_date").value);
		}
		var numOfHours = (sum_hours/8)*24+sum_hours%8; /// 8 hours full time
		var old_dt=dt;
		dt.setTime(dt.getTime() + numOfHours * 60 * 60 * 1000);
		var newdate=dt.getFullYear()+"/"+(dt.getMonth()+1)+"/"+dt.getDate();
		var fridy=getWeeksDiff(
				start_date, new Date(newdate)
			  );
		dt.setTime(dt.getTime() + fridy*24* 60 * 60 * 1000);
		
		newdate=dt.getFullYear()+"/"+(dt.getMonth()+1)+"/"+dt.getDate();
		document.getElementById("end_date").value=newdate;
		
        document.getElementById("time_until").innerHTML=newdate+" ("+parseInt(sum_hours/8)+" work day  and "+sum_hours%8+" hours)";
		document.getElementById("all_cost").innerHTML=parseInt(document.getElementById("all_cost").innerHTML)+parseInt(cost);
		document.getElementById("price").value=parseInt(document.getElementById("all_cost").innerHTML);
	
		document.getElementById("colleage2").innerHTML = document.getElementById("colleage2").innerHTML + "  <i><img class='' src='"+image+"' style='width:24px; height:24px; ' alt=profile></i>";
    
		
		$('#emptbl').DataTable().row.add([
  "<i><img class='' src='"+image+"' style='' alt='profile'></i><span class='td_empname'> "+all_name+" </span>"
  , "<span class='empprog_enddate'>0</span><center><div class='progress empprogress' style='height: 6.34px; border-radius: 5px;'><div class='progress-bar bg-warning' role='progressbar' style='width: 0% ;border-radius: 5px;' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div></div> </center>",
  "<span class='tl-text'>0/"+exp_hours+"</span>",
  "<span class='tl-text'>0/"+back_hours+"</span>"
]).draw();

        modal2.style.display = "none";
});

</script>