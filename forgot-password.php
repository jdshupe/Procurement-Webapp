<?php
  include 'php/config.php';

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    if ($_SESSION['theme'] == "light") {
        echo '<link rel="stylesheet" href="css/light-theme/main.css">';
        echo '<link rel="stylesheet" href="css/light-theme/index.css">';
      } elseif ($_SESSION['theme'] == "dark") {
        echo '<link rel="stylesheet" href="css/dark-theme/main.css">';
        echo '<link rel="stylesheet" href="css/dark-theme/index.css">';
      }
    ?>
    <link rel="icon" href="img/amtecklogo.PNG">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"> 

    <title>Amteck Procurement</title>
  </head>


  <body>
    <header class="top-nav">
      <a class="home-link" href="index.php">Amteck Procurement</a>
      <a class="link" href="index.php">Home</a>
      <a class="link" href="#news">News</a>
      <a class="link" href="#contact">Contact</a>
      <a class="link" href="#about">About</a>
    </header>


    <main>
      <div>
        <h2>Forgot Password</h2>
        <input type="text" name="email" id="email" placeholder="Account Email">
        <input type="text" name="last-name" id="last-name" placeholder="Last Name">
        <input id="login-button" type="button" value="Submit" onclick="">
    </div>
    </main>

    <?php include('php/footer.php') ?>
  </body>
</html>