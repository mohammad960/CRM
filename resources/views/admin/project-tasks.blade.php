
             
<div id="ptasks" class="modal">

    <div id="ptasksModal" class="modal-content">
        <div class="modal_title">
            Details
        </div>
                <div class="task-list" style="margin-left:5%;">

                    <table class="tasks-table" id="tsktbl" style="width: 100%;">
                        <thead  style=" height: 40px;">
                            <tr>
                            <th width="453px">List of Tasks</th>
                            <th width="120px">Start Date</th>
                            <th width="122px">End Date</th>
                            <th width="96px">Start Time</th>
                            <th width="108px">End Time</th>
							<th width="108px">Hours </th>
                        </tr>
                        <tr style="height: 16px;"></tr>
                        </thead>
                        <tbody id="task_body">
                        <?php /*
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
							   echo intval(($t->hours/60)).':'.($t->hours%60)
							   ?>
							   </td>
                            </tr>
						@endforeach
                        */ ?>
                        </tbody>
                    </table>
                </div>
        </div>
</div>
<script>
$(document).ready(function(){
       
});
</script>

