<?php
$query = "SELECT name FROM jobs ORDER BY ID ASC";
$results_jobs = mysqli_query($con, $query);
?>

<table>
  <thead>
    <tr>
      <th style="vertical-align: bottom;">User</th>
      <?php    
      while ($row = mysqli_fetch_array($results_jobs)) {
        $id = $row['name'];

        echo '<th class="monospace rotate"><div><span>'.substr($id, 0, 15).'</span></div></th>';
      }
      ?>
      <th id="spacer-column"></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $query = "SELECT username FROM users";
    $results = mysqli_query($con, $query);

    while ($row = mysqli_fetch_array($results)) {
      $username = $row['username'];

      echo '
        <tr><form method="POST">
          <td style="padding:5px 10px">'.$username.'</th>';

      $query = "SELECT
          jobs.ID,
          A.userID
        FROM 
          jobs
        LEFT JOIN (
          SELECT
            jobs.ID AS jobID,
            permissions.userID as userID
          FROM
            jobs
          LEFT JOIN permissions on jobs.ID = permissions.jobID
          WHERE permissions.userID IN (
            SELECT
              ID
            FROM
              users
            WHERE
              username = '".$username."'
          )
        ) A ON A.jobID = jobs.ID 
        ORDER BY jobs.ID ASC";
      $results_jobs = mysqli_query($con, $query);

      while ($row_jobs = mysqli_fetch_array($results_jobs)) {
        switch ($row_jobs['userID']) {
          case '':
            echo '<td><input type="checkbox" name='.$row_jobs['ID'].' value='.$row_jobs['ID'].'></td>';
            break;
          
          default:
            echo '<td><input checked type="checkbox" name='.$row_jobs['ID'].' value='.$row_jobs['ID'].'></td>';
            break;
        }        
      }

       echo '
        <td><input type="submit" value="Update"></td>
        <input type="checkbox" name="user" value="'.$username.'" hidden checked>
        </form></tr>';


    }
    ?>
    
  </tbody>
</table>