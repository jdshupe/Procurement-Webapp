<!-- PHP  -->
  <?php
    include('php/config.php');

    if (isset($_POST['register'])) {
      $username = $_POST['username'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $password_hash = password_hash($password, PASSWORD_BCRYPT);

      $query = $connection->prepare("SELECT * FROM users WHERE email=:email");
      $query->bindParam("email", $email, PDO::PARAM_STR);
      $query->execute();

      if ($query->rowCount() > 0) {
        echo '<p class="error">The email address is already registered!</p>';
      }

      if ($query->rowCount() == 0) {
        $query = $connection->prepare("INSERT INTO users(username,password,email) VALUES (:username,:password_hash,:email)");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $result = $query->execute();

        if ($result) {
          echo '<p class="success">Your registration was successful!</p>';
        } else {
          echo '<p class="error">Something went wrong!</p>';
        }
      }
    }

  ?> 
<!-- HTML -->
  <!DOCTYPE html>
  <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
      <?php
      if ($_SESSION['theme'] == "light") {
          echo '<link rel="stylesheet" href="css/light-theme/main.css">';
          echo '<link rel="stylesheet" href="css/light-theme/register.css">';
        } elseif ($_SESSION['theme'] == "dark") {
          echo '<link rel="stylesheet" href="css/dark-theme/main.css">';
          echo '<link rel="stylesheet" href="css/dark-theme/register.css">';
        }
      ?>
      <link rel="icon" href="img/amtecklogo.PNG">
      <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"> 

      <title>Amteck Procurement - Sign Up</title>
    </head>


    <body>
      <header class="top-nav">
        <a class="home-link" href="index.php">Amteck Procurement</a>
        <a class="link" href="index.php">Home</a>
        <a class="link" href="#news">News</a>
        <a class="link" href="#contact">Contact</a>
        <a class="link" href="#about">About</a>
      </header>


      <main class="register-form">
        <div>
          <form action="" method="post" name="signup-form">
            <div class="form-header">
              <h2>Register</h2>
            </div>
            <div class="form-element">
              <input type="text" name="username" placeholder="username"/>
            </div>
            <div class="form-element">
              <input type="email" name="email" placeholder="email"/>
            </div>
            <div class="form-element">
              <input type="password" name="password" placeholder="password">
            </div>
            <button type="submit" name="register" value="register">Submit</button>
          </form>
      </div>
      </main>

      <?php include('php/footer.php') ?>
    </body>
  </html>