/**
 * Calendar app page
 */
(function ($) {
  'use strict';
  var events=[];
  $.ajax({
  method:'get',
  url:'loadCalenderEvents',
  success:function(res){
   //alert("server request "+res);
    var temp=res.split("--");
    var names=[];
    var phones=[];
    var dates=[];
    var ids=[];
    var address=[];
    var services=[];
    var payAmounts=[];
  //  var alt_phones=[];
    
    for(var j=0;j<temp.length;j++){
      temp[j]=temp[j].replace("\"","").replace("[","").replace("]","").replace(",","");
    }
   // alert(temp);
    var t=0;
    if(temp!=""){
        for(var j=0;j<temp.length;j++){
          switch(t){
            case 0:
            ids.push(temp[j]);
            t=1;
            break;

            case 1:
            names.push(temp[j].substr(1,temp[j].length));
            t=2;
            break;

            case 2:
            dates.push(temp[j].substr(1,temp[j].length));
            t=3;
            break;

            // case 5:
            // services.push(temp[j].substr(1,temp[j].length));
            // t=6;
            // break;

            case 3:
            phones.push(temp[j].substr(2,temp[j].length));
            t=4;
            break;

            case 4:
            address.push(temp[j].substr(1,temp[j].length));
            t=5;
            break;

            case 5:
            payAmounts.push(temp[j].substr(1,temp[j].length));
            t=0;
            break;

            // case 6:
            // alt_phones.push(temp[j].substr(1,temp[j].length));
            // t=0;
            // break;
        }
      }  
    }
  //  alert(payAmounts);
//alert(names);alert(dates);alert(phones);alert(address);
    var event=[];
    for(var i=0;i<names.length;i++){
      event['ids']=ids[i];
      event['title']=names[i];
      event['start']=dates[i];
      event['className']="event-success";
      event['phone']=phones[i];
      event['service']=services[i];
      event['date']=dates[i];
      event['address']=address[i];
      event['payAmount']=payAmounts[i];
      events.push(event);
      event=[];
    }
   loadPayment();
   // loadCalender();
  }
});

  function loadPayment (){
    //Payment modal ajax
   $.ajax({
  method:'get',
  url:'changeServiceDate',
  success:function(res){
   // alert("server request "+res);
    var temp=res.split("--");
    var p_names=[];
    var p_phones=[];
    var p_dates=[];
    var p_ids=[];
    var p_address=[];
    var p_services=[];
   
    for(var j=0;j<temp.length;j++){
      temp[j]=temp[j].replace("\"","").replace("[","").replace("]","").replace(",","");
    }
   
    var t=0;
    if(temp!=""){
        for(var j=0;j<temp.length;j++){
          switch(t){
            case 0:
            p_ids.push(temp[j]);
            t=1;
            break;

            case 1:
            p_names.push(temp[j].substr(1,temp[j].length));
            t=2;
            break;

            case 2:
            p_phones.push(temp[j].substr(1,temp[j].length));
            t=3;
            break;

            case 3:          
            p_address.push(temp[j].substr(1,temp[j].length));
            t=4;
            break;

            case 4:
            p_services.push(temp[j].substr(1,temp[j].length));
            t=5;
            break;

            case 5:
            p_dates.push(temp[j].substr(1,temp[j].length));
           
            t=0;
            break;

            // case 6:
            // p_alt_phones.push(temp[j].substr(1,temp[j].length));
            // t=0;
            // break;
        }
      }  
    }
    // alert(p_dates);
    var event=[];
    for(var i=0;i<p_names.length;i++){
      event['p_ids']=p_ids[i];
      event['title']=p_names[i];
      event['start']=(p_dates[i]);
      event['className']="event-info";
      event['p_phone']=p_phones[i];
      event['p_service']=p_services[i];
      event['p_date']=p_dates[i];
      event['p_address']=p_address[i];
      event['type']='service';
      events.push(event);
      event=[];
    }
    // loadCalender();
    loadLeadDetail();
  }
});

}

  function loadLeadDetail (){
    //Payment modal ajax
   $.ajax({
  method:'get',
  url:'getLeadDate',
  success:function(res){
   // alert("server request "+res);
    var temp=res.split("--");
    var l_names=[];
    var l_phones=[];
    var l_dates=[];
    var l_ids=[];
    var l_status=[];
    var l_comment=[];
    var l_time=[];
   
    for(var j=0;j<temp.length;j++){
      temp[j]=temp[j].replace("\"","").replace("[","").replace("]","").replace(",","");
    }
   
    var t=0;
    if(temp!=""){
      // alert(temp);
        for(var j=0;j<temp.length;j++){
          switch(t){
            case 0:
            l_ids.push(temp[j]);
            t=1;
            break;

            case 1:
            l_names.push(temp[j].substr(1,temp[j].length));
            t=2;
            break;

            case 2:
            l_phones.push(temp[j].substr(1,temp[j].length));
            t=3;
            break;

            case 3:          
            l_status.push(temp[j].substr(1,temp[j].length));
            t=4;
            break;

            case 4:
            l_comment.push(temp[j].substr(1,temp[j].length));
            t=5;
            break;

            case 5:
            l_dates.push(temp[j].substr(1,temp[j].length));
            t=6;
            break;

            case 6:
            l_time.push(temp[j].substr(1,temp[j].length));
            t=0;
            break;
        }
      }  
    }
    // alert(p_dates);
    var event=[];
    for(var i=0;i<l_names.length;i++){
      event['l_ids']=l_ids[i];
      event['title']=l_names[i];
      event['start']=(l_dates[i]);
      event['className']="event-danger";
      event['l_phone']=l_phones[i];
      event['l_status']=l_status[i];
      event['l_date']=l_dates[i];
      event['l_comment']=l_comment[i];
      event['l_time']=l_time[i];
      event['type']='lead';
      events.push(event);
      event=[];
    }
    loadCalender();
  }
});

}

  // function externalEvents(elm) {
  //   var eventObject = {
  //     title: $.trim(elm.text()),
  //     className: elm.data('class')
  //   };
  //   elm.data('eventObject', eventObject);
  //   elm.draggable({
  //     zIndex: 999,
  //     revert: true,
  //     revertDuration: 0
  //   });
  // }

  // $('.add-event').click(function (e) {
  //   var markup = $('<div class=\'external-event event-primary\' data-class=\'event-primary\'>New event</div>');
  //   $('.external-events').append(markup);
  //   externalEvents(markup);
  //   e.preventDefault();
  //   e.stopPropagation();
  // });

  // $('#external-events div.external-event').each(function () {
  //   externalEvents($(this));
  // });

function loadCalender(){
      $('.fullcalendar').fullCalendar({
      height: $(window).height() - $('.header').height() - $('.content-footer').height() - 25,
      editable: true,
      defaultView: 'month',
      header: {
        left: 'today prev,next',
        right: 'title month,agendaWeek,agendaDay'
      },
      droppable: true,
      axisFormat: 'h:mm',
      columnFormat: {
        month: 'dddd',
        week: 'ddd M/D',
        day: 'dddd M/d',
        agendaDay: 'dddd D'
      },
      allDaySlot: false,
      drop: function (date) {
        var originalEventObject = $(this).data('eventObject');
        var copiedEventObject = $.extend({}, originalEventObject);
        copiedEventObject.start = date;
        $('.fullcalendar').fullCalendar('renderEvent', copiedEventObject, true);
        if ($('#drop-remove').is(':checked')) {
          $(this).remove();
        }
      },
      defaultDate: moment().format('YYYY-MM-DD'),
      viewRender: function (view, element) {
        if (!$('.fc-toolbar .fc-left .fc-t-events').length) {
          $('.fc-toolbar .fc-left').prepend($('<button type="button" class="fc-button fc-state-default fc-corner-left fc-corner-right fc-t-events"><i class="icon-list"></i></button>').on('click', function () {
            $('.events-sidebar').toggleClass('hide');
          }));
        }
      },
    //   dayClick: function(date, jsEvent, view, resourceObj) {

    //     alert('Date: ' + date.format());
    //     alert('Resource ID: ' + json_encode(jsEvent));

    // },
     eventClick: function(calEvent, jsEvent, view) {
//alert(calEvent.type);
      if(calEvent.type=="service"){
        $("[name='serve_id']").val(calEvent.p_ids);
        $("#p_name").html(calEvent.title);
        $("#p_phone").html(calEvent.p_phone);
        // $("#p_alt_phone").hide();
        $("#p_address").html(calEvent.p_address);
        $("#p_date").html(calEvent.p_date);
        $("#p_services").html(calEvent.p_service);
        $("#serve").click();
      }
      else if(calEvent.type=="lead"){
        $("#lead_id").val(calEvent.l_ids);
        $("#l_name").html(calEvent.title);
        $("#l_phone").html(calEvent.l_phone);
        $("#l_status").val(calEvent.l_status);
        $("#l_comment").val(calEvent.l_comment);
        $("#l_date").html(calEvent.l_date);
        $("#l_time").val(calEvent.l_time);
        $("#leads").click();
      }
      else{
        $("[name='job_id']").val(calEvent.ids);
        $("#name").html(calEvent.title);
        $("#phone").html(calEvent.phone);
        $("#alt").hide();
        $("#address").html(calEvent.address);
        $("#dateold").html(calEvent.date);
        $("#services").html(calEvent.service);
        $("#Amount").html(calEvent.payAmount);
        $("#open").click();
      }
    },
      events: events
    });
  }
})(jQuery);
