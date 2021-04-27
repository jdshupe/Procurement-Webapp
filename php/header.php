<header class="top-nav">
  <a class="home-link" href="index.php">Amteck Procurement</a>

  <div class="dropdown" style="float:right;">
    <a href="user-page.php" class="dropbtn"><?php echo $_SESSION['user_name']?></a>
    <div class="dropdown-content">
      <a href="index.php">Logout</a>
      <a href="#">Link 2</a>
      <a href="#">Link 3</a>
    </div>
  </div>

  <?php
  if ($_SESSION['is_admin']) {
    echo '
    <div class="dropdown" style="float:right;">
      <a href="#" class="dropbtn">Admin</a>
      <div class="dropdown-content">
        <a href="#">Add User</a>
        <a href="permissions.php">Permissions</a>
        <a href="#">Link 3</a>
      </div>
    </div>';
    echo '
    <div class="dropdown" style="float:right;">
      <a href="#" class="dropbtn">Pages</a>
      <div class="dropdown-content">
        <a href="vendors-home.php">Vendors</a>
        <a href="user-page.php">Jobs</a>
      </div>
    </div>';
  }
  ?>
</header>