<div id="Details" class="modal">

    <div id="detailsModal" class="modal-content">
        <div class="modal_title">
            Details
        </div>

            <div class="modal_inputs" style="padding-left:20px;">
                
                
                <div class="row">
                    <div class="col-md-3">
                        <i><img class="" src="" style="" alt=""></i>
                        <span class="text-16" id="employee_name" ></span>
                    </div>
                    <div class="col-md-3">
                        
                    </div>
                    <div class="col-md-3">
                        
                    </div>
                    <div class="col-md-3">
                        <span class="text-16" >Target Hours: <span id="target_hours"></span> Hours</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-12" >Completed Hours</span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-12" >Overtime Hours</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-16" id="all_hours"></span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-16" id="over_hours"></span>
                    </div>
                </div>
	
                <div class="tltbl" id="modaltable">
                    <table class="tl-table" id="emptbl" style="width:100%; margin-top:10%; margin-left:1%;">
                        <thead style="width:800px; height: 40px;">
                            <th width="400px">Assigned Projects</th>
                            <th width="200px">Working Hours</th>
                            <th width="200px">Overtime Hours</th>
                            
                        </thead>
                        <tbody id="body_project">
                       
                            <tr>
                                <td>
                                    <i><img class="" src="" style="" alt=""></i>
                                    <span class="td_empname" ><a href="/admin/project/1/tasks"> Box To Go Team</a></p> </span>
                                </td>
                                <td>
                                    <span class="text-16" >60 Hour</span>
                                </td>
                                <td>
                                    <span class="text-16 text-danger" >20 hours</span>
                                </td>
                            </tr>
                 
                        </tbody>
                    </table>
                </div>

            
            </div>
			</br>
            <div class="modal_btns" style="display:block">
			
                <a id="modal_cancel" class="modal_btn close" style=""><i><img src="{{asset('icons/x.svg')}}" style="width:12px; height:12px;"/></i> cancel</a>
            </div>



    </div>

  </div>
  <script>
    
  </script>
