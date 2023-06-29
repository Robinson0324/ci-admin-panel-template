
 
 <!--   Core JS Files   -->
 <script src="<?php echo $data['theme_url'];?>/assets//js/core/jquery.min.js"></script>
  <script src="<?php echo $data['theme_url'];?>/assets//js/core/popper.min.js"></script>
  <script src="<?php echo $data['theme_url'];?>/assets//js/core/bootstrap.min.js"></script>
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/moment.min.js"></script>
  <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/bootstrap-switch.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/sweetalert2.min.js"></script>
  <!--  Plugin for Sorting Tables -->
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/jquery.tablesorter.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/jquery.validate.min.js"></script>
  <!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/bootstrap-datetimepicker.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/jquery.dataTables.min.js"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/fullcalendar/fullcalendar.min.js"></script>
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/fullcalendar/daygrid.min.js"></script>
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/fullcalendar/timegrid.min.js"></script>
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/fullcalendar/interaction.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/nouislider.min.js"></script>
  <!--  Google Maps Plugin    -->
  <!-- Place this tag in your head or just before your close body tag. -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGat1sgDZ-3y6fFe6HD7QUziVC6jlJNog"></script>
  <!-- Chart JS -->
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="<?php echo $data['theme_url'];?>/assets//js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo $data['theme_url'];?>/assets//js/black-dashboard.min.js?v=1.1.1"></script>
  <!-- Black Dashboard DEMO methods, don't include it in your project! -->
  <script src="<?php echo $data['theme_url'];?>/assets//demo/demo.js"></script>
  <!-- Sharrre libray -->
  <script src="<?php echo $data['theme_url'];?>/assets//demo/jquery.sharrre.js"></script>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<!--  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-46172202-12"></script>-->

      <?php
        if(!empty($data['page'])){
            require_once FCPATH."/ui/pages/".$data['page']."/footer.php";
        }
        ?>
   
<!--      <footer class="footer">-->
<!--        <div class="container-fluid">-->
<!--          <ul class="nav">-->
<!--            <li class="nav-item">-->
<!--              <a href="javascript:void(0)" class="nav-link">-->
<!--                Creative Tim-->
<!--              </a>-->
<!--            </li>-->
<!--            <li class="nav-item">-->
<!--              <a href="javascript:void(0)" class="nav-link">-->
<!--                About Us-->
<!--              </a>-->
<!--            </li>-->
<!--            <li class="nav-item">-->
<!--              <a href="javascript:void(0)" class="nav-link">-->
<!--                Blog-->
<!--              </a>-->
<!--            </li>-->
<!--          </ul>-->
<!--          <div class="copyright">-->
<!--            ©-->
<!--            <script>-->
<!--              document.write(new Date().getFullYear())-->
<!--            </script> made with <i class="tim-icons icon-heart-2"></i> by-->
<!--            <a href="javascript:void(0)" target="_blank">Creative Tim</a> for a better web.-->
<!--          </div>-->
<!--        </div>-->
<!--      </footer>-->
  </div>
</body>
</html>