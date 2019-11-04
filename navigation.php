
<?php
// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  $displayLogout = 'style="display: none"';
  $displayLogin = 'style="display: block"';
} else {
  $displayLogin = 'style="display: none"';
  $displayLogout = 'style="display: block"';
}
  $_SESSION["displayLogin"] = $displayLogin;
  $_SESSION["displayLogout"] = $displayLogout;
?>

<!DOCTYPE html>
<html lang="en">

<body>
  <div class="w3-top" style="z-index:4;">

    <div class="w3-container w3-bar w3-black w3-theme-d2 w3-left-align">
      <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-hover-white w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
      <a href="#" class=" w3-padding-16 w3-bar-item w3-button w3-teal"><i class="fa fa-home w3-margin-right"></i>Home</a>
      <a href="#team" class="w3-padding-16 w3-bar-item w3-button w3-hide-small w3-hover-white">Team</a>
      <a href="#work" class="w3-padding-16 w3-bar-item w3-button w3-hide-small w3-hover-white">Work</a>
      <a href="#contact" class="w3-padding-16 w3-bar-item w3-button w3-hide-small w3-hover-white">Contact</a>
      <!-- <div class="w3-dropdown-hover w3-mobile"> -->
        <!-- <button class="w3-button w3-padding-16">Type <i class="fa fa-caret-down"></i></button> -->
        <!-- <div class="w3-dropdown-content w3-bar-block w3-dark-grey" > -->
      <a href="/web_management/scr_100x/student/scr_1001.php" class="w3-bar-item w3-button w3-mobile w3-padding-16 <?php if (($_SESSION["role"]) !== "student") { ?> w3-hide <?php }?> " >Student</a>
          <a href="/web_management/scr_100x/organization/scr_1002.php" class="w3-bar-item w3-button w3-mobile w3-padding-16 <?php if (($_SESSION["role"]) !== "organization") { ?> w3-hide <?php }?> ">Company</a>
          <a href="/web_management/scr_100x/teacher/scr_1003.php" class="w3-bar-item w3-button w3-mobile w3-padding-16 <?php if (($_SESSION["role"]) !== "teacher") { ?> w3-hide <?php }?> ">Teacher</a>
        <!-- </div> -->
      <!-- </div> -->
      <div class="w3-dropdown-hover w3-mobile w3-light-grey w3-right" <?php echo($_SESSION["displayLogin"]); ?>>
        <button class="w3-button w3-padding-16">Login<i class="fa fa-caret-down"></i></button>
        <div class="w3-dropdown-content w3-bar-block w3-light-grey">
          <a href="/web_management/scr_100/login/student.php" class="w3-bar-item w3-button w3-mobile w3-padding-16">Student</a>
          <a href="/web_management/scr_100/login/organization.php" class="w3-bar-item w3-button w3-mobile w3-padding-16">Company</a>
          <a href="/web_management/scr_100/login/teacher.php" class="w3-bar-item w3-button w3-mobile w3-padding-16">Teacher</a>
        </div>
      </div>
      <a href="/web_management/scr_100/logout/logout.php" class="w3-bar-item w3-button w3-mobile w3-light-grey w3-padding-16 w3-right" <?php echo($_SESSION["displayLogout"]); ?> >Logout</i></a>
    </div>
  </div>
</body>
</html>