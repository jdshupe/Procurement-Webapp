<!-- PHP  -->
  <?php
  $jobid = $_GET['job'];

  $select = 'SELECT
      description,
      `equipment-number`,
      `PO-number`,
      `start-date`,
      DATE_ADD( 
        `start-date`,
        INTERVAL (duration * `cycle-length`) DAY
      ) AS "finish date",
      `duration`,
      `cycle-length`,
      `total-cost`,
      `total-cost` / duration AS "cycle rent" ';
  $from = 'FROM `eq_tracker_details` A ';
  $where = 'WHERE jobID = "'.$jobid.'" AND complete = 0 ';
  $order_by = 'ORDER BY `PO-number`';

  $query = $select.$from.$where.$order_by;

  $result = mysqli_query($con, $query);
  ?>
<!-- HTML -->
  <table class="sortable">
    <thead class="non-clickable">
      <tr>
        <th class="anchor-top">Equipment Description</th>
        <th class="anchor-top">Equipment #</th>
        <th class="anchor-top">PO Number</th>
        <th class="anchor-top">Start Date</th>
        <th class="anchor-top">Finish Date</th>
        <th class="anchor-top">Duration</th>
        <th class="anchor-top">Cycle Length</th>
        <th class="anchor-top">Total Cost</th>
        <th class="anchor-top">Cycle Rent</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($row = mysqli_fetch_array($result)) {
        $description = $row['description'     ];
        $eqnum       = $row['equipment-number'];
        $ponum       = $row['PO-number'       ];
        $duration    = $row['duration'        ];
        $cyclelength = $row['cycle-length'    ];
        $totalcost   = $row['total-cost'      ];
        $cyclerent   = $row['cycle rent'      ];
        $startdate   = date_create($row['start-date' ]);
        $finishdate  = date_create($row['finish date']);
        echo"
        <tr id='".$ponum."' class='rental-line'>
          <td class='monospace' style='padding-left: 10px'>".$description."</td>
          <td class='monospace' style='text-align: center'>".$eqnum      ."</td>
          <td class='monospace' style='text-align: center'>".$ponum      ."</td>
          <td class='monospace' style='text-align: center'>"            .date_format($startdate, "M d, Y")."</td>
          <td class='finish-date monospace' style='text-align: center'>".date_format($finishdate,"M d, Y")."</td>
          <td class='monospace' style='text-align: center'>".$duration     ."</td>
          <td class='monospace' style='text-align: center'>".$cyclelength  ."</td>
          <td class='text-right monospace' >$".number_format($totalcost, 2)."</td>
          <td class='text-right monospace' style='padding-right: 10px'>$".number_format($cyclerent, 2)."</td>
        </tr>
        ";
      }
      ?>
    </tbody>
  </table>

