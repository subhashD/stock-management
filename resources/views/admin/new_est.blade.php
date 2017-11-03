@extends('layouts.master')

@section('title')
  Create Estimate
@endsection

@section('style-content')
<link rel="stylesheet" href="{{ URL::asset('vendor/summernote/dist/summernote.css') }}">
@endsection

@section('body-content')


<div class="card bg-white animated slideInRight">
  	<div class="card-header bg-info text-white">
    	New Estimate
  	</div>
  	<div class="card-block">
  	
  	<form class="form-horizontal" role="form" action="/saveEstimate" method="POST" id="quoteForm">
  	{{ csrf_field() }}
  	<div class="row m-a-0">
       <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-3 control-label">Client Name:</label>
                <div class="col-sm-9">
                  <input name="client_name" id="client_name" type="text" class="form-control" placeholder="" value="{{$client->fullname}}" readonly>
                  <input type="hidden" name="client_id" value="{{$client->id}}">
                  <input type="hidden" name="estimate_id" value="{{isset($estimate)?$estimate->id:''}}">
                </div>
              </div>
            </div> 
          </div>

  		    <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-3 control-label">estimate #</label>
                <div class="col-sm-9">
                  <input name="est_no" id="est_no" type="text" class="form-control" placeholder="estimate number." value="{{isset($estimate)?$estimate->estimate_no:$estimate_no}}" readonly>
                </div>
              </div>
            </div> 

            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-3 control-label">Place of Service :</label>
                <div class="col-sm-9">
                  <select data-placeholder="Select" required="" id="states" name="states" class="place form-control" style="width: 100%;" onchange="refreshCost()">
                @foreach($states as $state)
                <option value="{{$state->state_name}}" @if($state->state_name==$client->state) selected @endif>{{$state->state_name}}</option>
                @endforeach
               </select>
                </div>
              </div>
            </div>          
          </div>
         

          <div class="row"><br/></div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-3 control-label">estimate Date :</label>
                <div class="col-sm-9">
                  <input type="text" name="estimate_date" id="estimate_date" class="form-control m-b" data-provide="datepicker" id="startDatePicker" placeholder="estimate Date" value="{{isset($estimate)?date('m/d/Y',strtotime($estimate->estimate_date)):''}}" required>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-3 control-label">Due Date :</label>
                <div class="col-sm-9">
                  <input type="text" name="expiry_date" id="expiry_date" class="form-control m-b" data-provide="datepicker" id="endDatePicker" placeholder="Due Date" value="{{isset($estimate)?date('m/d/Y',strtotime($estimate->expiry_date)):''}}" required>
                </div>
              </div>
            </div>
          </div>

          <hr/>

          <div>
          <div class="row">
            <div class="col-xs-12">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#servicesModal"><i class="fa fa-plus"></i> Add More Service</button>
             <div class="table-responsive">
                
                <table class="table table-bordered table-striped m-b-0">
                  <thead class="bg-default-light">
                    
                      <th>Service Details</th>
                      <th>Quantity</th>
                      <th>Rate</th>
                      @if($client->tax=='yes')
                      <th>Tax (%) </th>
                      @endif
                      <th>Amount</th>
                    
                  </thead>
                  <tbody class="addItems">
                  @if(isset($estimate))
                    @for($i=0;$i<count($item_name);$i++)
                    <tr>
                      <td class="col-xs-4"><div class="search-box"><input name="item_name[]" id="item_name" type="text" class="form-control col-xs-4 item-search" placeholder="Type a item name" required="" value="{{$item_name[$i]}}"><textarea class="form-control" placeholder="Description" name="descriptions[]">{{$description[$i]}}</textarea>
                      </td>
                      <td><input name="item_qty[]" type="text" class="form-control p-a-1 qty" value="{{$qtys[$i]}}" onchange="refreshCost()" required>
                      </td>
                      <td><input name="item_rate[]" type="text" class="form-control p-a-1 rate" placeholder="" value="{{$price[$i]}}" onchange="refreshCost()" required>
                      </td>
                      @if($client->tax == 'yes')
                      <td><input name="item_tax[]" type="text" class="form-control p-a-1 tax" placeholder="" value="{{$item_tax[$i]}}" onchange="refreshCost()" required>
                      </td>
                      @else
                      <input name="item_tax[]" type="hidden" class="form-control p-a-1 tax" placeholder="" onchange="refreshCost()" value="0">
                      @endif
                      <td>
                      <label name="amount" class="amount"></label>
                      </td>
                      <td class="bg-white" style="border:1px solid #fff;"><a class="removeRow" href="javascript:;"><i class="icon-close fa-lg text-danger"></i></a>
                      </td>
                    </tr>
                    @endfor
	                @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          </div>
          <br/>
         
         <div class="row">
            <div class="col-md-7">
	            <div class="row" >
		             <button class="btn btn-link" type="button" id="addMoreRow">
		               <i class="fa fa-plus"></i> Add another field
		             </button>   
	             </div>          
            </div>
            <div class="col-md-5 pull-right">
              <div class="row">
                <div class="col-sm-4">
                  Sub total
                </div>
                <div class="col-sm-6">
                  <strong class="pull-right"><span id="subTotal">0</span> /-</strong>
                </div>
              </div> 
               
              <hr/>

              <div id="nogst">
              <div id="in_state">
                <div class="row">
                  <div class="col-sm-4">
                    CGST
                  </div>
                  <div class="col-sm-6 pull-right">
                    <div class="col-sm-8 input-group m-b">
                      <input type="text" class="form-control cgst" name="cgst" readonly="">
                      <span class="input-group-addon">
                        <i class="fa fa-inr" aria-hidden="true"></i>
                      </span>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-4">
                    SGST
                  </div>
                  <div class="col-sm-6 pull-right">
                    <div class="col-sm-8 input-group m-b">
                        <input type="text" class="form-control sgst" name="sgst" readonly="">
                        <span class="input-group-addon">
                          <i class="fa fa-inr" aria-hidden="true"></i>
                        </span>
                      </div>
                  </div>
                </div>
              </div>
              <input type="hidden" name="gst" id="gst" value="">
              <div id="out_state">
                <div class="row">
                  <div class="col-sm-4">
                    IGST
                  </div>
                  <div class="col-sm-6 pull-right">
                    <div class="col-sm-8 input-group m-b">
                      <input type="text" class="form-control igst" name="igst" id="igst" readonly="">
                      <span class="input-group-addon">
                        <i class="fa fa-inr" aria-hidden="true"></i>
                      </span>
                    </div>
                  </div>
                </div>
              </div> 
              </div>
              <div class="row">
                <div class="col-sm-4">
                  Discount
                </div>
                <div class="col-sm-6 pull-right">
                  <div class="col-sm-8 input-group m-b">
                    <input type="text" id="discount" name="discount" class="form-control" onchange="refreshCost()" value="{{isset($estimate)?$estimate->discount:''}}">
                    <span class="input-group-addon">
                      <i class="fa fa-percent" aria-hidden="true"></i>
                    </span>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="adjustment[]" value="{{isset($estimate)?$adjustment[0]:'Adjustment'}}">
                </div>
                
                <div class="col-sm-6 pull-right">
                    <div class="input-group m-b">
                    <span class="input-group-addon">
                      <i class="fa fa-minus text-danger" aria-hidden="true"></i>
                    </span>
                      <input type="text" class="form-control" name="adjustment[]" id="adjustment" min="0" onchange="refreshCost()" value="{{isset($estimate)?$adjustment[1]:''}}">
                    </div>
                </div>
              </div> 

              <hr>
              <div class="row bg-default-light p-a">
                <div class="col-sm-4">
                  <strong><span>Total Amount ( <i class="fa fa-inr"></i> )</span></strong>
                </div>
                <div class="col-sm-6 pull-right">
                  <div class="input-group m-b">
                  <input type="text" readonly="" class="form-control" readonly name="total_amount" id="total_amount">
                      <span class="input-group-addon">
                        <i class="fa fa-inr" aria-hidden="true"></i>
                      </span>
                    </div>
                </div>
              </div>
             
            </div>
          </div>
          <hr/>
          <div class="row">
               <div class="col-md-12 m-a-1">
                    
               <span data-toggle="collapse" data-target="#terms_cond" class="terms text-primary">Terms & Conditions <i class="fa fa-plus" id="terms_icon"></i></span>
                    
                    <div id="terms_cond" class="collapse">
                      <textarea class="summernote" name="terms" rows="10" placeholder="Enter Some text ...">{{isset($estimate)?$estimate->terms_condition:''}}</textarea>
                    </div> 

               </div>
           </div>
          <div class="row">
            <input type="submit" name="Preview" value="Save" class="btn btn-primary" onclick="$('form').attr('target', '');">
            <input type="submit" name="Preview" class="btn btn-info" target="_blank" value="Preview" onclick="$('form').attr('target', '_blank');">
            <button type="reset" class="btn btn-default">
              Reset
            </button>
          </div>      

          </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div id="servicesModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
   <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">List Of services</h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive" style="max-height: 400px;overflow-y: scroll;">
            <table class="table table-striped table-condensed table-bordered">
              <thead>
                <th>Select</th>
                <th>Name</th>
                <th>Price</th>
                @if($client->tax== 'yes')
                <th>Tax(%)</th>
                @endif
              </thead>
              <tbody>
                @foreach($items as $item)
                  <tr>
                    <td class="col-md-1">
                      <input type="checkbox" class="form-control col-xs-1 check">
                    </td>
                    <td class="col-md-8">
                      <input type="text" class="form-control col-xs-8 service_name" readonly="" value="{{$item->name}}">
                    </td>
                   <td>
                      <input type="text" class="form-control service_qty" readonly="" value="{{$item->qty_avail}}">
                    </td>
                    <td class="col-md-2">
                      <input type="text" class="form-control col-xs-2 service_price" readonly="" value="{{$item->price}}">
                    </td>
                    @if($client->tax=='yes')
                    <td class="col-md-1">
                      <input type="text" class="form-control col-xs-1 service_tax" readonly="" value="{{$item->tax}}">
                    </td>
                    @endif
                  </tr>
                @endforeach
              </tbody>
            </table>
            <input type="hidden" id="items_length" value="{{count($items)}}">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" id="addService"><i class="fa fa-plus"></i> Add Selected Service</button>
      </div>
    </div>


@endsection

@section('script-content')
<script src="{{ URL::asset('vendor/summernote/dist/summernote.min.js') }}"></script>
<script src="{{ URL::asset('scripts/forms/wysiwyg.js') }}"></script>
<script src="{{ URL::asset('vendor/chosen_v1.4.0/chosen.jquery.min.js')}}"></script>
<script src="{{ URL::asset('vendor/jquery.tagsinput/src/jquery.tagsinput.js')}}"></script>
<script src="{{ URL::asset('vendor/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script>
<script src="{{ URL::asset('vendor/clockpicker/dist/jquery-clockpicker.min.js')}}"></script>
<script src="{{ URL::asset('vendor/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{ URL::asset('scripts/forms/plugins.js')}}"></script>


<script type="text/javascript">
var company_state = $('#company_state').val();
var company_gst = $('#company_gst').val();

$(function(){
    $('.place').select2();
    $('.terms').click();
    $('.qty').trigger('change');
    $("#nogst").hide(500);
    refreshCost();
});

$(".removeRow").on('click',function(){
    $(this).parent().parent().remove();
    refreshCost();
});


//calculation

  $('#addService').click(function(){
    var items_length={{count($items)}};
    var new_type='';
    var field=$('.addItems');
  
    for(var i=0;i<items_length;i++){
      if($(".check").eq(i).is(':checked')){
           new_type = '<tr id=""><td class="col-xs-4"><input name="item_name[]" id="item_name" type="text" class="form-control col-xs-4" placeholder="Type a item name" value="'+$(".service_name").eq(i).val()+'"><textarea class="form-control" placeholder="Description" name="descriptions[]"></textarea></td><td><input name="item_qty[]" type="text" class="form-control p-a-1 qty" placeholder="" onchange="refreshCost()" value="1"></td><td><input name="item_rate[]" type="text" class="form-control p-a-1 rate" placeholder="" onchange="refreshCost()" value="'+$(".service_price").eq(i).val()+'"></td>@if($client->tax== 'yes')<td><input name="item_tax[]" type="text" class="form-control p-a-1 tax" placeholder="tax" onchange="refreshCost()" value="'+$(".service_tax").eq(i).val()+'"></td>@else<input name="item_tax[]" type="hidden" class="form-control p-a-1 tax" placeholder="" onchange="refreshCost()" value="0">@endif<td><label name="amount" class="amount">'+$(".service_price").eq(i).val()+'</label></td><td class="bg-white" style="border:1px solid #fff;"><a class="removeRow" href="javascript:;"><i class="icon-close fa-lg text-danger"></i></a></td></tr>';
           field.append(new_type);
      }
    }
    $(".removeRow").on('click',function(){
        $(this).parent().parent().remove();
        refreshCost();
    });
    $(".qty").eq(0).trigger("change");
  });

  $('#addMoreRow').click(function(){
      $('.addItems').append('<tr><td class="col-xs-4"><div class="search-box"><input name="item_name[]" id="item_name" type="text" class="form-control col-xs-4 item-search" placeholder="Type a item name" required=""><textarea class="form-control" placeholder="Description" name="descriptions[]"></textarea></td><td><input name="item_qty[]" type="text" class="form-control p-a-1 qty" value="1" onchange="refreshCost()" required></td><td><input name="item_rate[]" type="text" class="form-control p-a-1 rate" placeholder="" onchange="refreshCost()" required></td>@if($client->tax== 'yes')<td><input name="item_tax[]" type="text" class="form-control p-a-1 tax" placeholder="" onchange="refreshCost()" required></td>@else<input name="item_tax[]" type="hidden" class="form-control p-a-1 tax" placeholder="" onchange="refreshCost()" value="0">@endif<td><label name="amount" class="amount"></label></td><td class="bg-white" style="border:1px solid #fff;"><a class="removeRow" href="javascript:;"><i class="icon-close fa-lg text-danger"></i></a></td></tr>');
    
      $(".removeRow").on('click',function(){
          $(this).parent().parent().remove();
          refreshCost();
      });
  });

  $(".removeRow").on('click',function(){
          $(this).parent().parent().remove();
          refreshCost();
      });

  function refreshCost(){

    var gst=0;
    var total=0;
    var subTotal=0;
    var i=0;
    var st_name = $("#states").val();
    
    while(true){
        if($(".qty").eq(i).val()!='' && $(".rate").eq(i).val()){
          
          var qt = parseInt($(".qty").eq(i).val());
          var rate = parseInt($(".rate").eq(i).val());
          var tax=0;
          if('{{$client->tax}}' == 'yes')
          {
            tax = parseInt($(".tax").eq(i).val())/2; 
          }
          else
          {
            tax=0;
          }
          // alert(tax);
          $(".amount").eq(i).html((qt*rate));
          gst += Math.ceil((qt*rate*tax)/100);
          subTotal += Math.ceil(qt*rate);
          $("#subTotal").html(subTotal);

          var cost =subTotal + gst*2;
          if(gst==0)
           {
            $("#nogst").hide(500);
           }
           else
           {
            $("#nogst").show();
           }
         // alert(cost);
         // cost += gst*2;// cgst + sgst
         if(st_name == "MAHARASHTRA")
         {
          $("#in_state").show();
          $("#out_state").hide();
          $('.cgst').val(Math.ceil(gst));
          $('.sgst').val(Math.ceil(gst));
          $('#gst').val(Math.ceil(gst*2));
         }
         else
         {
          $("#in_state").hide();
          $("#out_state").show();
          $('#igst').val(Math.ceil(gst*2));
          $('#gst').val(Math.ceil(gst*2));
         }
          var discount=0;
          if($("#discount").val()!=''){
            discount = Math.ceil(cost) * parseInt($("#discount").val())/100;
          }

          var total = cost - discount;
          // alert(total);
          if($('#adjustment').val()!=""){
              total = total - parseInt($('#adjustment').val());
          }

          $("#total_amount").val(Math.ceil(total));

          var add_id = $("#address_id").val();
          i++;
        }else{
          break;
        }
    }
    if(i==0){
      $("#total_amount").val('');
      $('#adjustment').val('');
      $('.cgst').val('');
      $('.sgst').val('');
      $("#subTotal").html(0);
    }
  }

  $('#quoteForm').on('submit',function(){
      
        if(new Date($("#estimate_date").val()).getTime() >= new Date($("#expiry_date").val()).getTime()){
          alert('Error! Due date cannot be same or less than Estimate Date');
        }
        else{
              if($('.qty').eq(0).val()){
              return true;
            }
            else{
              alert('Please, Add Atleast 1 service to proceed');
              }
        }
        return false;
      
  });

</script>


@endsection
