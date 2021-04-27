<!-- PHP  -->
  <?php
    include('php/config.php'); // app wide php config

    $job = $_GET['job'];

    if (is_null($_SESSION['user_id'])) {
      header("Location: index.php");
    }

    // Update PO details if set
    if (isset($_POST['po'])) {

      $po = $_POST['po'];
      $id = $_POST['id'];
      $eq_num = $_POST['eq_num'];
      $start = $_POST['start'];
      $duration = $_POST['duration'];
      $cycle = $_POST['cycle'];
      $total = $_POST['total'];
      $descrip = $_POST['descrip'];

      $query = 'UPDATE `eq_tracker_details`
        SET
            `equipment-number`="'.$eq_num.'",
            `PO-number`="'.$po.'",
            `start-date`="'.$start.'",
            `duration`='.$duration.',
            `cycle-length`='.$cycle.',
            `total-cost`="'.$total.'",
            `description`="'.$descrip.'"
        WHERE equipmentID='.$id
      ;

      $result = mysqli_query($con, $query);
    }

    function createButton($name, $job) {
      echo"
        <tr id='$name'>
          <td class='report-button'>
            <form action='job-page.php' method='get'>
              <input type='hidden' name='job'    value='$job'>
              <input type='submit' name='report' value='$name'>
            </form>
          </td>
        </tr>";
    }
  ?>
<!-- HTML -->
  <!DOCTYPE html>
  <html lang="en">
    <head>
      <!-- assign meta values -->
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- php to switch between light and dark styles -->
      <?php
          if ($_SESSION['theme'] == "light") { // light styling
            echo '<link rel="stylesheet" href="css/light-theme/main.css">';
            echo '<link rel="stylesheet" href="css/light-theme/job-page.css">';
          } elseif ($_SESSION['theme'] == "dark") { // dark styling
            echo '<link rel="stylesheet" href="css/dark-theme/main.css">';
            echo '<link rel="stylesheet" href="css/dark-theme/job-page.css">';
          }
        ?>
      <!-- link to amteck logo for tab -->
      <link rel="icon" href="img/amtecklogo.PNG">

      <!-- link for google fonts TODO: move into the main .css -->
      <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
      <script src="//ajax.aspnetcdn.com/ajax/4.0/1/MicrosoftAjax.js" type="text/javascript"></script>

      <title>Amteck Procurement</title>
    </head>
    <body>
      <?php include('php/header.php'); ?>
      <main class="main-area">
        <div class="content-container" id="report-selection">
          <table>
            <thead>
              <tr>
                <th id="job-title"><?php echo $_GET['job']?></th>
              </tr>
            </thead>
            <tbody>
              <?php createButton("Budgeted Amounts",  $job) ?>
              <?php createButton("Purchased Amounts", $job) ?>
              <?php createButton("Rental Tracker",    $job) ?>
              <?php createButton("Test Report",       $job) ?>
            </tbody>
          </table>
        </div>
        <div class="content-container" id="report-display">
          <?php
          switch($_GET['report']) {
            case "Budgeted Amounts" :
              include('php/job-page/budgeted-amounts-query.php');
            break;

            case "Purchased Amounts" :
              include('php/job-page/purchased-amounts-query.php');
            break;

            case "Rental Tracker" :
              include('php/job-page/rental-tracker-query.php');
            break;

            case "Test Report" :
              include('php/job-page/test-report-query.php');
            break;
          }
          ?>
        </div>
        <!-- Filter Inputs Underneath Data Container -->
        <div class="content-container" id="filter-bar">
          <form action="job-page.php" method="GET" id="filter-bar-form">
            <input type="hidden" name="job"    value="<?php echo $_GET["job"] ?>">
            <input type="hidden" name="report" value="<?php echo $_GET["report"] ?>">
            Code:           <input type="text" name="code"        <?php if (isset($_GET['code']))        {echo"placeholder='".$_GET['code']."'";}        ?> autofocus="autofocus" onfocus="this.select()" style="width:5ch">
            Description:    <input type="text" name="description" <?php if (isset($_GET['description'])) {echo"placeholder='".$_GET['description']."'";} ?> >
            Times Purchased:<input type="text" name="times"       <?php if (isset($_GET['times']))       {echo"placeholder='".$_GET['times']."'";}       ?> >
            Vendor:         <input type="text" name="vendor"      <?php if (isset($_GET['vendor']))      {echo"placeholder='".$_GET['vendor']."'";}      ?> >
            <input type="submit" value="Filter" id="submit">
          </form>
        </div>
      </main>
      <?php if (isset($_GET['po'])) { include("php/job-page/rental-details.php");} ?>
      <?php include('php/footer.php') ?>
      <script> document.getElementById("<?php echo $_GET['report'] ?>").style.backgroundColor = "gray" </script>
    </body>
  </html>