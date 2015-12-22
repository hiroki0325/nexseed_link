<?php 
    $url = 'http://192.168.33.10/nexseed_link/views/onlineEnglish/reserve/json-events.php';
    $json = file_get_contents($url);
    $eventsData = json_decode($json,true);
    var_dump($eventsData);
 ?>

<script language="JavaScript">
$(document).ready(function() {
  $('#calendar').fullCalendar({
    //日付を英語表示にする
    monthNames: ['January','February','March','April','May','June','July','August','September','October','November','December'],
    monthNamesShort: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
    dayNames: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
    dayNamesShort: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
    timeFormat: { // for event elements
      '': 'H:mm' // default
    },
    slotDuration:'00:30:00',
    //時間の表記を見やすくする
    axisFormat: 'H:mm',
      timeFormat: {
        agenda: 'H:mm{ - H:mm}'
    },
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,basicWeek,basicDay'
    },
    events: 'http://192.168.33.10/nexseed_link/views/onlineEnglish/reserve/json-events.php'
    // events: [
    //             {
    //                 title: 'All Day Event',
    //                 start: '2015-12-01'
    //             },
    //             {
    //                 title: 'Long Event',
    //                 start: '2015-12-07',
    //                 end: '2015-12-10'
    //             },
    //             {
    //                 id: 999,
    //                 title: 'Repeating Event',
    //                 start: '2015-12-09T16:00:00'
    //             },
    //             {
    //                 id: 999,
    //                 title: 'Repeating Event',
    //                 start: '2015-12-16T16:00:00'
    //             },
    //             {
    //                 title: 'Conference',
    //                 start: '2015-12-11',
    //                 end: '2015-12-13'
    //             },
    //             {
    //                 title: 'Meeting',
    //                 start: '2015-12-12T10:30:00',
    //                 end: '2015-12-12T12:30:00'
    //             },
    //             {
    //                 title: 'Lunch',
    //                 start: '2015-12-12T12:00:00'
    //             },
    //             {
    //                 title: 'Meeting',
    //                 start: '2015-12-12T14:30:00'
    //             },
    //             {
    //                 title: 'Happy Hour',
    //                 start: '2015-12-12T17:30:00'
    //             },
    //             {
    //                 title: 'Dinner',
    //                 start: '2015-12-12T20:00:00'
    //             },
    //             {
    //                 title: 'Birthday Party',
    //                 start: '2015-12-13T07:00:00'
    //             },
    //             {
    //                 title: 'Click for Google',
    //                 url: 'http://google.com/',
    //                 start: '2015-12-28'
    //             }
    //         ]




  });
});
</script>

<div id="calendar" class="container"></div>
