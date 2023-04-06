<div id="positionEdit" class="modal" style="display:block;">

    <div id="positionEdit" class="modal-content">
        <div class="modal_title">
            Edit Position
        </div>
         <form action="{{route('position.update',$position->id)}}" method="post">
          @csrf
		  	{{ method_field('PATCH') }}
            <div class="modal_inputs">
             
					<div class="row">
                      <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="part_project" id="pname" value="{{$position->part_project}}" placeholder="Position Name">
                            <label for="pname">Position</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" id="Department" name="department_id" aria-label="Department" style="height: 40px;">
                          <option value="{{$position->department_id}}">{{$position->dep_name}}</option>
                           @foreach ($departments as $d)
							@if($d->id != $position->department_id)
						      <option value="{{$d->id}}">{{$d->name}}</option>
						    @endif
						   @endforeach
                        </select>

                    </div>
                </div>
			</div>
				<div class="modal_btns">
					<a id="modal_cancel" href='/position/' class="modal_btn close"><i><img src="{{asset('icons/x.svg')}}" style="width:12px; height:12px;"/></i> Cancel</a>
					<button id="modal_save" class="modal_btn btnsave"><i><img src="{{asset('icons/okmark.svg')}}" style="width:20px; height:20px;"/></i> Save </button>
				</div>
			
        </form>




 </div>
 </div>

