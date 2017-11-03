@extends('layouts.masterEmployeeLayout')

@section('title')
 Company Details
@endsection

@section('style-content')
<style media="screen">
  .form-control{
    background-color: #d3d3d3;
  }
</style>
@endsection

@section('body-content')
<div class="col-md-10">
<div class="card bg-white animated slideInRight">
    <div class="card-header bg-primary-light text-white">
      Company Details | Set Up
    </div>
    <div class="card-block">
      <div class="row">
        <div class="col-sm-12">
           <form action="/saveSettings" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}

            <div class="row">
                <div class="form-group">
                  <label class="control-label col-sm-2"><strong>Company Logo :</strong></label>
                   <input type="file" name="company_logo" id="file" onchange="loadFile(event)" required>
                      @if ($errors->has('image'))
                          <span class="help-block">
                              <strong>{{ $errors->first('image') }}</strong>
                          </span>
                      @endif
                      <span class="text-small text-danger">Nearly 160 px x 70 px</span>
                </div>

                <div class="col-sm-2 col-xs-12 pull-right" style="margin-top: 0px"><img id="output"
                  src="{{asset(isset($detail)?'storage/app/'.$detail->logo:'')}}"></div>
              </div>

              <div class="row">
                <div class="form-group">
                  <label class="control-label col-sm-3"><strong>Company Name :</strong></label>
                  <input type="text" class="form-control col-sm-9" name="company_name" required="" value="{{isset($detail)?$detail->name:''}}">
                </div>
              </div>

              <div class="row">
                <div class="form-group">
                  <label class="control-label col-sm-3"><strong>Company Email :</strong></label>
                  <input type="email" class="form-control col-sm-9" name="company_mail" required="" value="{{isset($detail)?$detail->email:''}}">
                </div>
              </div>

              <div class="row">
                <div class="form-group">
                  <label class="control-label col-sm-3"><strong>Contact No. :</strong></label>
                  <input type="text" class="form-control col-sm-9" name="company_phone" required="" value="{{isset($detail)?$detail->phone:''}}" pattern=".{10,15}">
                </div>
              </div>

              <div class="row"><br></div>
              <div class="row" id="login">
                <div class="cs-checkbox m-b">
                    <input type="checkbox" id="l1" name="" value="yes" onchange="docheck(this)">
                    <label for="l1" id="pass_label"><strong>GST Registered ?</strong></label>
                </div>
              </div>

              <div class="row" id="pass">
                <div class="form-group">
                  <label class="control-label col-sm-3"><strong>GST Number :</strong></label>
                  <input type="text" class="form-control col-sm-9" name="gst_no" required="" pattern="^([0][1-9]|[1-2][0-9]|[3][0-5])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$" value="{{isset($detail)?$detail->gst:''}}">
                </div>
              </div><br>
              {{-- <div class="row"><br></div> --}}
              <div class="row">
              <div class="col-sm-3">
              <label class="control-label"><strong>Company State :</strong></label>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <select data-placeholder="Select" required="" id="states" name="states" class="state form-control col-xs-12 col-md-6" style="width: 100%;">
                    @foreach($states as $state)
                    <option value="{{$state->state_name}}" {{isset($detail)?$detail->state==$state->state_name?'selected':'':''}}>
                      {{$state->state_name}}
                    </option>
                    @endforeach
                  </select>
                </div>
              </div>
              </div>
              {{-- <div class="row"><br></div> --}}
              <div class="row">
                <div class="form-group">
                  <label class="control-label col-sm-3"><strong>Address :</strong></label>
                  <textarea  class="form-control" name="company_address" placeholder="Enter Company Address..." required="required" rows="3">{{isset($detail)?$detail->address:''}}</textarea>
                </div>
              </div>

              <div class="row"><br></div>

              <button type="reset" class="btn btn-danger reset"><i class="fa fa-refresh"></i> RESET</button>
              <button type="submit" class="btn btn-success save"><i class="fa fa-check"></i> SAVE</button>
           </form>
        </div>

      </div>
    </div>
</div>
</div>

@endsection


@section('script-content')
<script src="{{ URL::asset('vendor/summernote/dist/summernote.min.js') }}"></script>
<script src="{{ URL::asset('scripts/forms/wysiwyg.js') }}"></script>

<script type="text/javascript">

  $(function(){

    $('[name=gst_no]').removeAttr('required');
    $(".state").select2();

    if("{{isset($detail)?$detail->gst:''}}"!='')
    {
      if("{{isset($detail->gst)?$detail->gst:''}}"!=null){
        $('#pass_label').click();
        $('#pass').show(500);
      }
    }
    else{
      $('#pass').hide();
    }
  })
  function docheck(ischeck)
  {
    if (ischeck.checked) {
    $('#pass').show(500);
    $('[name=gst_no]').attr('required','required');
    }
   else{
      $('#pass').hide(500);
      $('[name=gst_no]').removeAttr('required');
    }
  }

  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
  };

</script>

@endsection
