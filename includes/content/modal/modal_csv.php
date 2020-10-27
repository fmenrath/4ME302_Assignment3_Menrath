 <!-- Display the csv data if required (Modal window) -->
<?php
//Get Filename variable (for heading)
$filename = $_GET["filename"];
?>

<div class="modal-content">
  <div class="modal-top">
    <p id="modal-heading"><?php echo $filename?></p>
    <i class="fas fa-times" id="modal-close"></i>
  </div>
  <div class="modal-csv-table">
    <script>
    //-----------Create a csv table for the selected data-file
      //Read the csv document
      $.ajax({
          url: $filename, //Currently selected option in the dropdown
          dataType:"text",
          //Build the html table below it
          success:function(data){
              var employee_data = data.split(/\r?\n|\r/);
              var table_data = '<table class="table table-bordered table-striped">';
              for(var count = 0; count<employee_data.length; count++){
                  var cell_data = employee_data[count].split(",");
                  table_data += '<tr>';
                  for(var cell_count=0; cell_count<cell_data.length; cell_count++){
                      if(count === 0){
                          table_data += '<th>'+cell_data[cell_count]+'</th>';
                      }
                      else{
                          table_data += '<td>'+cell_data[cell_count]+'</td>';
                      }
                  }
                  table_data += '</tr>';
                  }
              table_data += '</table>';
              $('.modal-csv-table').html(table_data);
              }
          });
    </script>
  </div>
</div>
