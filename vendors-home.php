<!-- PHP  -->
 <?php
    include('php/config.php'); // app wide config settings
  ?>
<!-- HTML -->
  <!DOCTYPE html>
  <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <?php
          if ($_SESSION['theme'] == "light") { // light styling
            echo '<link rel="stylesheet" href="css/light-theme/main.css">';
            echo '<link rel="stylesheet" href="css/light-theme/vendors-home.css">';
          } elseif ($_SESSION['theme'] == "dark") { // dark styling
            echo '<link rel="stylesheet" href="css/dark-theme/main.css">';
            echo '<link rel="stylesheet" href="css/dark-theme/vendors-home.css">';
          }
          ?>
      <link rel="icon" href="img/amtecklogo.PNG">
      <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
      
      <title>Amteck Procurement</title>
    </head>
    <body>
      <?php include('php/header.php'); ?> <!-- header bar at top of page with nav settings -->
      
      <main>
        <div id="vendor-select" class="content-container"></div>
        
        <div id="map" class="content-container"></div>
        
      </main>
      
      <?php include('php/footer.php') ?>
    </body>
  </html>