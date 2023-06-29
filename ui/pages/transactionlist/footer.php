<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/6/14
 * Time: 2:42 AM
 */

?>

  <script>
    $(document).ready(function() {
            //get_transactions
      var dtdraw =    $('#datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
           "url":"main/ajax_call"
           ,"type": "GET"
           ,"data":{
              action:"get_transactions",
              data : ""
            }
           }
        ,"pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
        }

      });
      // $('#datatable').DataTable({
      //   "pagingType": "full_numbers",
      //   "lengthMenu": [
      //     [10, 25, 50, -1],
      //     [10, 25, 50, "All"]
      //   ],
      //   responsive: true,
      //   language: {
      //     search: "_INPUT_",
      //     searchPlaceholder: "Search records",
      //   }

      // });

      // var table = $('#datatable').DataTable();
    });
  </script>