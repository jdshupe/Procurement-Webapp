<!-- PHP  -->
  <?php
    $po = $_GET['po'];

    $select = "SELECT * FROM `eq_tracker_details`";
    $where = "WHERE `PO-number`='${po}'";

    $query = $select.$where;

    $result = mysqli_query($con, $query);  
  ?>
<!-- HTML -->
  <div class="rental-details-popup active">
    <div class="popup-content active">
      <form id="rental-details-form" method="POST" action="job-page.php?job=<?php echo $_GET['job'] ?>&report=Rental+Tracker">
        <?php
          while ($row = mysqli_fetch_array($result)) {
            $id = $row[0];
            $eq_num = $row[1];
            $start = $row[4];
            $duration = $row[5];
            $cycle = $row[6];
            $total = $row[7];
            $descrip = $row[9];
            $notes = $row[8];
            echo'

            <div id="po-input-div">
              <label for="po-input">PO Number:</label>
              <input type="text" name="po" id="po-input" value="'.$po.'"><br>
            </div>

            <div id="id-input-div">
              <label id="id-label" for="id-input">Record ID:</label>
              <input type="text" name="id" id="id-input" value="'.$id.'"><br>
            </div>
        
              <label for="eq-num-input">Equipment Number:</label>
              <input type="text" name="eq_num" id="eq-num-input" value="'.$eq_num.'"><br>
        
              <label for="start-date-input">Start Date:</label>
              <input type="date" name="start" id="start-date-input" value="'.$start.'"><br>
        
              <label for="duration-input">Duration:</label>
              <input type="text" name="duration" id="duration-input" value="'.$duration.'"><br>
        
              <label for="cycle-input">Cycle Length:</label>
              <input type="text" name="cycle" id="cycle-input" value="'.$cycle.'"><br>
        
              <label for="total-input">Total Cost:</label>
              <input type="text" name="total" id="total-input" value="'.number_format($total, 2).'"><br>
        
              <label for="descrip-input">Desctiption:</label>
              <input type="text" name="descrip" id="descrip-input" value="'.$descrip.'"> <br>     
              
              <textarea form="rental-details-form" cols="40" rows="5">'.$notes.'</textarea> <br>  
            ';
          }        
        ?>
        <input class="close" type="submit" value="Submit">
      </form>
    </div>
  </div>