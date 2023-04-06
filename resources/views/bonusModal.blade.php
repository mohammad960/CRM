<div id="BonusModal" class="modal" >
    <div id="bonusModal" class="modal-content">
        <div class="modal_title">
            Add Bonus/Deduction 
        </div>
         <form action="{{route('bonus.store')}}" method="post">
          @csrf
            <div class="modal_inputs">
                <div class="row" style="margin-bottom:24px;">
                
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" value="+" id="type1" checked>
							
                            <label class="form-check-label" for="type1">
                                Bonus
                            </label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" value="-" id="type2" >
                            <label class="form-check-label" for="type2">
                                Deduction
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
						 <input type="text" class="form-control" placeholder="Bonus Value" name="id_v" hidden id="id_v" style="width:809px; padding-bottom:20px"/>
                            <input type="number" class="form-control" name="bonus" id="bonus" style="width:809px; padding-bottom:20px"/>
                            <label for="pname">Bonus Value</label>
                        </div>
                    </div>
                </div>
			</div>
			<div class="row" style="position:relative; left:450px; padding-bottom:10px;">
                <div class="col-md-4">
                    <a id="modal_cancel" class="modal_btn close"><i><img src="{{asset('icons/x.svg')}}" style="width:12px; height:12px;"/></i> cancel</a>
                </div>
                <div class="col-md-4">
                    <button id="modal_save" class="modal_btn btnsave"><i><img src="{{asset('icons/okmark.svg')}}" style="width:20px; height:20px;"/></i> Save </button>
                </div>
			</div>
			
        </form>

 </div>

 </div>

