<?php
  if (isset($_GET['job'])) {
    $job = $_GET['job'];
  }
  if (isset($_GET['job_name'])) {
    $job_name = $_GET['job_name'];
  }
  if (isset($_GET['code'])) {
    $code = $_GET['code'];
  }
  if (isset($_GET['description'])) {
    $description = $_GET['description'];
    $description = strtoupper($description);
  }

// Set order Variable
// Budgeted Query
  $select = "CREATE OR REPLACE VIEW budgeted AS
    SELECT
      `procurement-web-app`.`budget-details`.`itemID`           AS `itemID`,
      MAX(`procurement-web-app`.`budget-details`.`description`) AS `descrip`,
      SUM(`procurement-web-app`.`budget-details`.`quantity`)    AS `quantity`,
      MAX(`procurement-web-app`.`budget-details`.`cost-unitID`) AS `unit`,
      AVG(`procurement-web-app`.`budget-details`.`unit-cost`)   AS `cost`
    FROM `procurement-web-app`.`budget-details` "
  ;
  if (isset($code) && $code != "Select Sort Code") {
    $where ="
      WHERE
        `procurement-web-app`.`budget-details`.`budgetID` IN (
          SELECT
            `procurement-web-app`.`budgets`.`ID`
          FROM
            `procurement-web-app`.`budgets`
          WHERE
            `procurement-web-app`.`budgets`.`jobID` = '".$job."' AND
            `budget-details`.`sort-codeID`=".$code."
        )"
    ;
  } else {
    $where = "
      WHERE
        `procurement-web-app`.`budget-details`.`budgetID` IN (
          SELECT
            `procurement-web-app`.`budgets`.`ID`
          FROM
            `procurement-web-app`.`budgets`
          WHERE
            `procurement-web-app`.`budgets`.`jobID` = '".$job."'
        )"
    ;
  }

// Run Budget Query
  $group_by = "GROUP BY `procurement-web-app`.`budget-details`.`itemID` ";
  $order_by = "ORDER BY SUM(`procurement-web-app`.`budget-details`.`quantity`) DESC";
  $query = $select.$where.$group_by.$order_by;
  mysqli_query($con, $query);

// Purchased Query Setup
  $select = "CREATE OR REPLACE VIEW purchased AS
    SELECT
      `procurement-web-app`.`purchase-details`.`itemID`           AS `itemID`,
      sum(`procurement-web-app`.`purchase-details`.`quantity`)    AS `quantity`,
      max(`procurement-web-app`.`purchase-details`.`cost-unitID`) AS `unit`,
      avg(`procurement-web-app`.`purchase-details`.`unit-cost`)   AS `cost`
    FROM
      `procurement-web-app`.`purchase-details`"
  ;

  if (isset($code) && $code != "Select Sort Code") {
    $where = "
      WHERE
        `procurement-web-app`.`purchase-details`.`jobID` = '".$job."' AND
        `purchase-details`.`sort-codeID` = ".$code." "
    ;
  } else {
    $where = "
      WHERE
        `procurement-web-app`.`purchase-details`.`jobID` = '".$job."' "
    ;
  }

// Run Purchased query
  $group_by = "GROUP BY `procurement-web-app`.`purchase-details`.`itemID`";
  $order_by = "ORDER BY sum(`procurement-web-app`.`purchase-details`.`quantity`) desc";
  $query = $select.$where.$group_by.$order_by;
  mysqli_query($con, $query);
// Final Query
  if (isset($description) && $description != "PARTIAL DESCRIPTION") {
    $query = "SELECT * FROM procurementreport WHERE name like '%".$description."%'";
  } else {
    $query = "SELECT * FROM procurementreport";
  }
  $result = mysqli_query($con, $query);
// Loop to show data
  while ($row = mysqli_fetch_array($result)) {
    $name = $row['name'];
    $budqty = $row['budqty'];
    $budcost = $row['budcost'];
    $budunit = $row['budunit'];
    $budtotal = $row['budtotal'];
    $poqty = $row['poqty'];
    $pocost = $row['pocost'];
    $pounit = $row['pounit'];
    $pototal = $row['pototal'];
    $variance = $row['variance'];
    $variance2 = $row['variance2'];

    echo "
      <tr>
        <td class='item-name monospace'>".$name."</td>
        <td class='bud-quantity monospace text-right'>".number_format($budqty)."</td>
        <td class='dollars monospace'>$</td>
        <td class='bud-cost monospace text-right'>".number_format($budcost,2)."/".$budunit."</td>
        <td class='dollars monospace'>$</td>
        <td class='bud-total monospace text-right'>".number_format($budtotal, 2)."</td>";

    echo ($poqty == 0)  ?"<td class='po-quantity monospace'></td>" :"<td class='po-quantity monospace text-right'>".number_format($poqty)."</td>";

    echo "<td class='dollars monospace'>$</td>";

    echo ($pocost == 0) ?"<td class='po-cost monospace'></td>"     :"<td class='po-cost monospace text-right'>".number_format($pocost,2) ."/". $pounit."</td>";

    echo "<td class='dollars monospace'>$</td>";

    echo ($pototal == 0)?"<td class='po-total monospace'></td>"    :"<td class='po-total monospace text-right'>".number_format($pototal,2) ."</td>";

    // color positive variance as normal
    if ($budqty != 0 && $poqty/$budqty < .95){
      echo "
        <td class='var-quantity monospace text-right'>".number_format($variance)."</td>"      ;
    // color negative variance red
    } elseif ($budqty != 0 && $poqty/$budqty > .95 && $poqty/$budqty < 1) {
      echo "
        <td class='var-quantity monospace text-right' style='color:orange'>".number_format(abs($variance))."</td>";
    } elseif ($variance < 0) {
      echo "
        <td class='var-quantity monospace text-right' style='color:red'>".number_format(abs($variance))."</td>";
    } else {
      echo "
      <td class='var-quantity monospace'></td>";
    }

    echo "<td class='dollars monospace'>$</td>";

    if (($budtotal - $pototal) > 0){
      echo "
        <td class='var-total monospace text-right'>".number_format($variance2, 2)."</td>"      ;
    // color negative variance red
    } elseif (($budtotal - $pototal) < 0) {
      echo "
        <td class='var-total monospace text-right' style='color:red'>".number_format(abs($variance2), 2)."</td>";
    } else {
      echo "
      <td class='var-total monospace'></td>";
    }

    echo '</tr>';
  }
?>