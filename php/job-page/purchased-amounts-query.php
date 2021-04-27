<!-- PHP  -->
  <?php
    // Changing the purchased view to show appropriate data for job
    // Setting the SELECT statement
    $select = "CREATE or REPLACE VIEW  purchased as
      SELECT `procurement-web-app`.`purchase-details`.`itemID`         AS `itemID`,
        sum(`procurement-web-app`.`purchase-details`.`quantity`)       AS `quantity`,
        max(`procurement-web-app`.`purchase-details`.`cost-unitID`)    AS `unit`,
        avg(`procurement-web-app`.`purchase-details`.`unit-cost`)      AS `cost`,
        count(`procurement-web-app`.`purchase-details`.`itemID`)       AS `times_purchased`";

    // Setting the FROM statement
    $from = "
      from
        `procurement-web-app`.`purchase-details`";

    // Setting the WHERE statement, including filter if it has been set
    if (isset($_GET['code']) && $_GET['code'] != "") {
      $where = "
      where
        `procurement-web-app`.`purchase-details`.`jobID` = '".$_GET['job']."' and
        `procurement-web-app`.`purchase-details`.`sort-codeID` = '".$_GET['code']."'";
    } else {
      $where = "
      where
        `procurement-web-app`.`purchase-details`.`jobID` = '".$_GET['job']."'";
    }

    if (isset($_GET['vendor']) && $_GET['vendor'] != "") {
      $where = $where." and `procurement-web-app`.`purchase-details`.`vendorID` LIKE '%".$_GET['vendor']."%'";
    }  
    
    // Setting the GROUP BY statement
    $group_by = "
      group by
        `procurement-web-app`.`purchase-details`.`itemID`";

    // Setting the ORDER BY statement
    $order_by = "
      order by itemID "
    ;

    // Combining individual parts into the full query
    $query = $select.$from.$where.$group_by.$order_by;

    // Run the setup query
    mysqli_query($con, $query);

    // setup for the Query that Actually gets run

    // Setting the SELECT statement
    $select = "SELECT
        items.description as description,
        purchased.quantity as quantity,
        purchased.times_purchased as times_purchased,
        purchased.itemID as itemID,
        purchased.cost as cost, 
        purchased.unit as unit" 
    ;

    $from = "
      FROM
        `purchased`
      left join items on purchased.itemID = items.ID"
    ;

    if (isset($_GET['description']) && $_GET['description'] != "") {
      $where = "
      WHERE
        description like '%".$_GET['description']."%' and
        not description = ''"
      ;
    } else {
      $where = "
        WHERE not
          description = ''"
      ;
    }

    if (isset($_GET['times']) && $_GET['times'] != "") {
      $where = $where." and times_purchased > ".$_GET['times'];
    }   

    $query = $select.$from.$where;
    $result = mysqli_query($con, $query);
    
    $totalRowQuery = $select.$from;
    $totalRowResults = mysqli_query($con, $totalRowQuery);
  ?>
<!-- HTML -->
  <table id="domainsTable" class="tableSorter">
    <thead>
      <tr>
        <th class="anchor-top description">Description</th>
        <th class='anchor-top quantity'>Quantity</th>
        <th class='anchor-top times-purchased'>Times Purchased</th>
        <th class='anchor-top purchase-price'>Purchase Price</th>
        <th class='anchor-top vendor'>Vendor</th>
      </tr>
    </thead>
    <tbody class="non-clickable">
      <?php
        // Iterates through results and populates to table
        while ($row = mysqli_fetch_array($result)) {

          $id = $row['itemID'];
          $desc = $row['description'];
          $qty = $row['quantity'];
          $times = $row['times_purchased'];
          $cost = $row['cost'];
          $unit = $row['unit'];

          echo '
            <tr class="main-info">
              <td class="description     monospace">'.$desc.'</td>
              <td class="quantity        monospace" style="text-align:right">'. number_format($qty)       .'</td>
              <td class="times-purchased monospace" style="text-align:right">'. number_format($times).'</td>
              <td class="purchase-price  monospace" style="text-align:right">$'.number_format($cost, 2).'/'.$unit.'</td>
              <td class="vendor          monospace text-right"></td>
            </tr>'
          ;
          // query with specific item details
          $WHERE =  'WHERE itemID = "'.$id.'" and jobID = "'.$_GET['job'].'"';
          if (isset($_GET['vendor']) && $_GET['vendor'] != "") {
            $WHERE = $WHERE.' and vendorID LIKE "%'.$_GET['vendor'].'%"';
          }
          $query2 = 'SELECT jobID, `PO-number`, sum(quantity) as quantity, avg(`unit-cost`) as `unit-cost`, `cost-unitID` as unit, vendorID FROM `purchase-details`'.$WHERE.' GROUP BY `PO-number` ORDER BY `PO-number`';
          $result2 = mysqli_query($con, $query2);

          // adds in the po table
          include('PO-subtable.php');          
        }
      ?>
    </tbody>
  </table>