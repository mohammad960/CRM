<div id="assignEModal" class="modal">

    <div id="assignModal" class="modal-content">
        <div class="modal_title">
            Assign Employee for ERP Team Project
        </div>
        <form action="{{route('client.store')}}" method="post">
			@csrf
            <div class="modal_inputs" style="padding-left:20px;">
                
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text"  class="form-control" name="saerch" id="saerch" style="width:802px;" placeholder="Search Employee">
                            <label for="saerch"><i><img src="{{asset('icons/modalsearch.svg')}}" style="width:20px; height:20px;margin-right:8px;"/></i>Search employee</label>
                        </div>
                    </div>
                </div>
	
         
            <div id="searcharea">
            @foreach($employees as $e)
			
                    <div class="row" onclick="EHM({{$e->id}},'{{$e->image}}','{{$e->first_name}}','{{$e->last_name}}','{{$e->target_hours}}','{{$e->position}}','{{$e->hour_cost}}','{{$e->over_price}}')" >
                        <div class="col-md-1">
                            <i><img src="/storage/employee/{{$e->image}}" style="width:21px; height:21px;margin-right:8px;"/></i>
                        </div>
                        <div class="col-md-3 names">
                            <span style="font-family: 'Cairo';font-size: 16px; line-height: 26px; color: #051626;">{{$e->first_name}} {{$e->last_name}} </span>
                        </div>
                        <div class="col-md-3 positions">
                            {{$e->position}}
                        </div>
                        <div class="col-md-3 target">
                            {{$e->target_hours}} hours
                        </div>
                    </div>
					
                @endforeach
            </div>
            </div>


        </form>


    </div>

  </div>
  <script>
    var search = document.getElementById("saerch");
    var searcharea = document.getElementById("searcharea");
    const olddata = searcharea.children;
    search.addEventListener('keyup', function(){
        for(var i=0; i<olddata.length; i++){
            olddata[i].style.display = '';
            }
        var word = search.value;
        if(word == ''){
            
        }
        else{
            for(var i=0; i<olddata.length; i++){
                if(olddata[i].innerText.indexOf(word) == -1){
                    olddata[i].style.display = 'none';
                }
            }
        }
    });
  </script>
