<!DOCTYPE html>
<html lang="en">
<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>Invoice</title>
  
<style type="text/css" media="print">

@media print {
  body {    
    -webkit-print-color-adjust: exact; 
  }
}

</style>

 </head>
  <body class="container clearfix">

    <header style="width: 100%;position: relative;min-height: 1px;
    float: left;">
      <div style="float: left;width: 50%;">
        @if($company->logo)
        <div>
        <img src="{{asset('storage/app/'.$company->logo)}}" id="output" style="height: 70px;width: 180px" />
        </div>
        @endif
        <strong style="font-size: 18px;">{{$company->name}}</strong>
        {{'',$company_addr = explode(',',$company->address)}}
        <address>
          @foreach($company_addr as $addr)
          {{$addr}}<br>
          @endforeach
          {{$company->state}}<br>
          @if($company->gst != null)
          GST No: <strong>{{$company->gst}}</strong>
          @endif
        </address>  
      </div>    
      
      <div style="float: right;width: 19%">
        <div style="float: right">
          <h1 style="text-transform: uppercase;text-align: right;">Invoice</h1>
          <h3 style="text-transform: uppercase;text-align: right;">#{{$client->tax=='yes'?$invoice->tax_invoice:$invoice->notax_invoice}}</h3>
          {{--<h5 style="text-align: left;padding: 8px 5px;">Balance Due</h5>
          <h5 style="text-align: right;">{{$invoice->total - $invoice->payment->sum(amount)}}</h5>
          <br/>--}}
        </div>
        </div>
      </div>
    </header>
    @for($i=0;$i<count($company_addr);$i++)
     <br/><br>
    @endfor
    <br><br>
    <div style="width: 100%;position: relative;min-height: 1px;
    float: left;">
      <div style="float:left;width: 50%;">
        <p style="text-align: left">Bill To <br/>
        {{ $client->fullname}}<br/>
        {{isset($client->gst_no)?$client->gst_no:''}}</p>
        <p style="text-align: left">Place of supply: {{$invoice->state}}</p>
      </div> 
      <div style="float: right;width: 30%;">
        <div style="float: right;">
          <table style="width: 80%;border-collapse: collapse;border-spacing: 0;">
            <tr style="text-align: right">
              <td style="padding: 8px 5px;">Dated: </td>
              <td >{{date('d M,Y',strtotime($invoice->invoice_date))}}</td>
              <!-- <tr style="text-align: right">
                <td style="padding: 8px 5px;">Terms: </td>
                <td class="date">Custom</td>
              </tr> -->
              <tr style="text-align: right">
                <td style="padding: 8px 5px;">Due Date: </td>
                <td class="date">{{date('d M,Y',strtotime($invoice->due_date))}}</td>
              </tr>
            </tr>
          </table>
        </div>
      </div>    
    </div>
<br/><br><br><br><br><br/><br/>
    <div style="width: 100%;position: relative;min-height: 1px;
    float: left;">
      <table style="width: 100%; border-bottom: 1px solid #1e1e1e;">
        <thead>
          <tr>
            <th style="padding: 8px 5px;background-color: #1e1e1e;color: #ffffff;border-bottom: 1px solid #C1CED9;white-space: nowrap;font-weight: normal;text-align: left;">#</th>
            <th style="padding: 8px 5px;background-color: #1e1e1e;color: #ffffff;border-bottom: 1px solid #C1CED9;white-space: nowrap;font-weight: normal;text-align: left;">Item & Description</th>
            <th style="padding: 8px 5px;background-color: #1e1e1e;color: #ffffff;border-bottom: 1px solid #C1CED9;white-space: nowrap;font-weight: normal;text-align: left;">Qty</th>
            <th style="padding: 8px 5px;background-color: #1e1e1e;color: #ffffff;border-bottom: 1px solid #C1CED9;white-space: nowrap;font-weight: normal;text-align: left;">Rate</th>
            @if($client->tax=='yes')
            <th style="padding: 8px 5px;background-color: #1e1e1e;color: #ffffff;border-bottom: 1px solid #C1CED9;white-space: nowrap;font-weight: normal;text-align: left;">Tax</th>
            @endif
            <th style="padding: 8px 5px;background-color: #1e1e1e;color: #ffffff;border-bottom: 1px solid #C1CED9;white-space: nowrap;font-weight: normal;text-align: left;">Amount</th>
          </tr>
        </thead>
        <tbody>
          {{'',$count=1,$subtotal=0}}
          @for($i=0;$i<count($item_name);$i++)
            <tr>
              <td style="text-align: center;">{{$count++}}</td>
              <td style="text-align: center;">{{$item_name[$i]}}<br>
              <span style="text-align: left;">{{$description[$i]}}</span></td>
              <td style="text-align: center;">{{$qtys[$i]}}</td>
              <td style="text-align: center;">{{$price[$i]}}</td>
              @if($client->tax=='yes')
              <td style="text-align: center;">{{$item_tax[$i]}}</td>
              @endif
              <td style="text-align: center;">{{$price[$i]}}</td>
            </tr>  
            {{'',$subtotal = $subtotal + ($price[$i] * 1)}}  
          @endfor
        </tbody>
      </table>
    </div>
<br/><br><br><br>
  @for($i=0;$i<count($item_name);$i++)
  <br/>
  @endfor
    <div style="width: 25%;position: relative;min-height: 1px;
    float: right;">
   
        <div style="float: right">
          <br/>
          <table>
            <tr style="text-align: right;">
              <td style=" padding: 8px;">Sub Total</td>
              <td style=" padding: 8px;">{{$subtotal}}</td>
            </tr>
            @if($client->tax=='yes')
              @if($invoice->state == $company->state)
              <tr style="text-align: right;">
                <td style=" padding: 8px;">CGST</td>
                <td style=" padding: 8px;">{{(int)($invoice->gst)/2}}</td>
              </tr>
              <tr style="text-align: right;">
                <td style=" padding: 8px;">SGST</td>
                <td style=" padding: 8px;">{{(int)($invoice->gst)/2}}</td>
              </tr>
              @else
              <tr style="text-align: right;">
                <td style=" padding: 8px;">IGST</td>
                <td style=" padding: 8px;">{{$invoice->gst}}</td>
              </tr>
              @endif
            @endif
            <tr style="text-align: right;">
              <td style=" padding: 8px;">Discount</td>
              <td style=" padding: 8px;">{{isset($invoice->discount)?$invoice->discount ."%":"--"}}</td>
            </tr><tr style="text-align: right;">
              <td style=" padding: 8px;">{{$adjustment[0]}}</td>
              <td style=" padding: 8px;">{{$adjustment[1]==""?"--":$adjustment[1]}}</td>
            </tr>
            <tr style="text-align: right;">
              <td style=" padding: 8px;">Total</td>
              <td style=" padding: 8px;">{{$invoice->total}}</td>
            </tr>
            <tr style="text-align: right;background: #F5F5F5;">
              <td style=" padding: 8px;">Balance Due</td>
              <td style=" padding: 8px;">{{$invoice->status!='paid'?$invoice->total:'PAID'}}</td>
            </tr>
          </table>
          <!-- <p class="text-capitalize">Total in words:
          <span class="text-capitalize text-bold">rupees twenty-on thousan two  hundere forty</span></p> -->
        </div>
    
    </div>
    <br/><br><br><br><br/><br><br><br><br/><br><br/><br/><br/>
    <div style="width: 100%;position: relative;min-height: 1px;
    float: left;">
      <div style="float: left;width: 70%;">
        <h3 style="padding: 0;margin: 0">Notes</h3>
        <p>{{$company->notes}}</span></p>

        <h3 style="padding: 0;margin: 0">Terms & Conditions</h3>
        <p>{!!$company->description!!}</p>
      <br/>
        <h3 style="padding: 0;margin: 0">Authorized Signature:____________________________</h3>
      </div>      
    </div> 
  </body>
</html>