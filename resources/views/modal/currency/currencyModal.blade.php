<div id="currencyModal" class="modal">

    <div id="currencModal" class="modal-content">
        <div class="modal_title">
            Update Currency
        </div>
         <form action="{{route('currency.store')}}" method="post">
          @csrf
            <div class="modal_inputs">
             
					<div class="row">
                        <div class="col-md-5" style="">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="us_value" id="pname" placeholder="USD Value">
                                <label for="pname">USD Value</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                             =
                        </div>
                     <div class="col-md-6" style="">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="sp_value" id="pname" placeholder="SP Value" >
                            <label for="pname">SP Value</label>
                        </div>
                    </div>
                </div>
			</div>
				<div class="modal_btns">
					<a id="modal_cancel" class="modal_btn close"><i><img src="{{asset('icons/x.svg')}}" style="width:12px; height:12px;"/></i> cancel</a>
					<button id="modal_save" class="modal_btn btnsave"><i><img src="{{asset('icons/update.svg')}}" style="width:20px; height:20px;"/></i> Update </button>
				</div>
			
        </form>




 </div>
 </div>

