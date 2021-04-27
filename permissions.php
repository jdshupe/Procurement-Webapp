<!-- Setup php -->
<?php
  include('php/config.php');

  // makes sure a user is logged in before navigating farther into the app
  if (is_null($_SESSION['user_id'])) [
    header("Location: index.php")                                                                           // redirects back to login page
  ];

  $myPost = array_values($_POST);

  if (isset($myPost[0])) {
    $query = "DELETE FROM permissions WHERE userID = (SELECT ID FROM users WHERE username='".$myPost[0]."')";
    mysqli_query($con, $query);
    for ($i=1; $i < count($myPost); $i++) {
      $query = "INSERT INTO permissions(ID, userID, jobID) VALUES ('',(SELECT ID FROM users WHERE username='".$myPost[0]."'),'".$myPost[$i]."')";
      mysqli_query($con, $query);
    }
  }
?>

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
        echo '<link rel="stylesheet" href="css/light-theme/permissions.css">';
      } elseif ($_SESSION['theme'] == "dark") { // dark styling
        echo '<link rel="stylesheet" href="css/dark-theme/main.css">';
        echo '<link rel="stylesheet" href="css/dark-theme/permissions.css">';
      }
    ?>
  <!-- link to amteck logo for tab -->
  <link rel="icon" href="img/amtecklogo.PNG">
  <!-- link for google fonts TODO: move into the main .css -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

  <title>Amteck Procurement</title>
</head>

<body>
  <?php include 'php/header.php'; ?>

  <main>
    <div class="content-container" id="user-permissions-editor">
      <?php include 'php/permissions/user-permissions-editor.php' ?>
    </div>
    <?php include('php/footer.php') ?>
  </main>
</body>