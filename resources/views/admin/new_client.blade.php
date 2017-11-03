@extends('layouts.master')

@section('title')
Dashboard | Pest Control
@endsection

@section('body-content')

<div class="page-title">
  <div class="title">New Order</div>
</div>

<form class="form-horizontal" role="form" action="/saveCustomer" method="POST" id="orderForm">
  {{csrf_field()}}
  <input type="hidden" name="client_id" value="{{isset($client->id)?$client->id:''}}">
   <div class="card bg-white animated slideInLeft">
    <div class="card-header bg-info text-white">
      Customer Details
    </div>
    <div class="card-block">
      <div class="row m-a-0">
        <div class="col-lg-12">

        <div id="company">
          <div class="row">
              <div class="form-group">
              <input type="hidden" name="c_type" value="company">
                <label class="col-md-2 control-label">Full Name :</label>
                <div class="col-md-10">
                  <input name="fullname" type="text" class="form-control company" placeholder="example ABC" value="{{isset($client->fullname)?$client->fullname:''}}">
                </div>
              </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-3 control-label">Phone :</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="contact_no" placeholder="Phone Number" pattern=".{10,15}" value="{{isset($client->contact_no)?$client->contact_no:''}}">
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-3 control-label">Alt Phone :</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="alt_contact" placeholder="Alternate Phone" pattern=".{10,15}" value="{{isset($client->alt_contact)?$client->alt_contact:''}}">
                </div>
              </div>
            </div>
          </div>

          {{-- <div class="row addPerson">
            <button type="button" class="pull-right fa fa-plus btn-default" id="addMoreRow"></button>
            <br>
          </div> --}}

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-3 control-label">Email :</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" name="email" placeholder="doe@example.com" value="{{isset($client->email)?$client->email:''}}">
                </div>
              </div>
            </div>
            @if(isset($CompanyDetail->gst) != null)
             <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-3 control-label">Tax :</label>
                <div class="col-sm-8">
                    <div class="cs-radio form-group" style="align-items: center;" >
                    <div class="col-sm-1">&nbsp;</div>
                        <input type="radio" id="tax1" name="cust_tax" value="yes">
                        <label for="tax1" >Yes</label>

                        <input type="radio" id="tax2" name="cust_tax" checked=""  value="no">
                        <label for="tax2" >No</label>
                    </div>
                </div>
              </div>
            </div>
            @else
            <input type="hidden" name="cust_tax" value="no">
            @endif

          </div>

          <div class="row" id="gst">
          	<div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-3 control-label">GST NO. </label>
                <div class="col-sm-9">
                 <input type="text" name="gst_no" class="form-control" placeholder="GST No." pattern="^([0][1-9]|[1-2][0-9]|[3][0-5])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$" value="">
                </div>
              </div>
             </div>
          </div>
          <div class="row">
            <h2 class="background double"><span>Address Details</span></h2>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-3 control-label">Address</label>
                <div class="col-sm-9">
                  <textarea class="form-control" name="street" rows=4  placeholder="Street Address">{{isset($client->street)?$client->street:''}}</textarea>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
              <label class="col-sm-3 control-label">State</label>
                  <div class="col-md-9">
                   <select class="form-control state" name="state">
                   @foreach($states as $state)
                   	<option value="{{$state->state_name}}" 
                   	{{isset($client->state)?($client->state==$state->state_name?'selected':''):''}}
                   	>{{$state->state_name}}
                   	</option>
                   @endforeach
                   </select>
                  </div>
              </div>

              <div class="form-group">
              <label class="col-sm-3 control-label">City</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="city" placeholder="e.g Mumbai" value="{{isset($client->city)?$client->city:''}}">
                  </div>
              </div>

              <div class="form-group">
               <label class="col-sm-3 control-label">Pin Code</label>
                  <div class="col-md-9">
                    <input type="text" name="pincode" pattern=".{6,6}" class="form-control company" placeholder="e.g 400086" value="{{isset($client->pincode)?$client->pincode:''}}">
                  </div>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  

  <div class="row">
    <div class="col-xs-6">
      <a href="javascript:;"><button type="reset" class="btn btn-info btn-block"><i class="fa fa-reset"></i> Reset</button></a>
    </div>
    <div class="col-xs-6">
      <button type="submit" class="btn btn-success btn-block"><i class="fa fa-paper-plane"></i> SUBMIT</button>

    </div>
  </div>
</form>


@endsection

@section('script-content')

<script type="text/javascript">

$('#addMoreRow').click(function(){
      $('.addPerson').append('<div class="row"><div class="col-md-6"><div class="form-group"><label class="col-sm-3 control-label">Contact Person :</label><div class="col-sm-9"><input name="contact_person[]"  type="text" class="form-control company" placeholder="example Joe"></div></div></div><div class="col-md-5"><div class="form-group"><label class="col-sm-3 control-label">Phone :</label><div class="col-sm-9"><input type="text" class="form-control company" name="company_alt_phone[]" placeholder="Phone Number" pattern=".{10,15}" ></div></div></div><div class="col-md-1 pull-right"><a href="javascript:;" class="fa fa-minus btn-default btn-sm removeRow"></a></div></div>');
    
      $(".removeRow").on('click',function(){
          $(this).parent().parent().remove();
      });
  });

$(function(){
  if ("{{$client}}" != "") 
  {
  	$('#orderForm').attr('action','/updateClient');
  }
  else
  {
  	$('#orderForm').attr('action','/saveCustomer');
  }
  $("#gst").hide();
  if ("{{isset($client->tax)?$client->tax:''}}"=="yes") 
  {
  	$("[name=cust_tax]").click();
  	$("#tax1").prop("checked",true);
  	$("[name=gst_no]").val("{{isset($client->gst_no)?$client->gst_no:''}}");
  }
  
  $('.state').select2();
});

$("[name=cust_tax]").click(function(){
    if($("#tax1").is(':checked'))
    {
      $("#gst").show(500);
    }
    else
    {
      $("#gst").hide(500);
      $("[name=gst_no]").removeAttr("required");
    }
  });

</script>

@endsection
