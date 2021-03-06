<?php
  // Initialize the session
  session_start();
  // Check if the user is already logged in, if yes then redirect him to welcome page
  if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../../");
    exit;
  }
  // Include config file
  require_once "../../config.php";
  // Define variables and initialize with empty values
  $email_teacher = $password = $name_teacher = $address_teacher = $phone_number = "";
  $email_teacher_err = $password_err = "";
  // Processing form data when form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username is empty
    if (empty(trim($_POST["email_teacher"]))) {
      $email_teacher_err = "Please enter your email!";
    } else {
      $email_teacher = trim($_POST["email_teacher"]);
    }
    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
      $password_err = "Please enter your password.";
    } else {
      $password = trim($_POST["password"]);
    }
    // Validate credentials
    if (empty($email_teacher_err) && empty($password_err)) {
      // Prepare a select statement
      $sql = "SELECT id, contact, email, password, name, address FROM teacher_profile WHERE email = ?";
      if ($stmt = mysqli_prepare($link, $sql)) {
        
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_email_teacher);
        // Set parameters
        $param_email_teacher = $email_teacher;
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
          // Store result
          mysqli_stmt_store_result($stmt);
          // Check if username exists, if yes then verify password
          if (mysqli_stmt_num_rows($stmt) == 1) {
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $id, $phone_number, $email_teacher, $hashed_password, $name_teacher, $address_teacher);
            if (mysqli_stmt_fetch($stmt)) {
              if (password_verify($password, $hashed_password)) {
                // Password is correct, so start a new session
                session_start();
                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                // $_SESSION["address_teacher"] = $address_teacher;
                $_SESSION["name"] = $name_teacher;
                // $_SESSION["phone_teacher"] = $phone_number;
                // $_SESSION["email_teacher"] = $email_teacher;
                $_SESSION["role"] = "teacher";
               // $_SESSION["first_name"] = $first_name;
                // Redirect user to scr_1003 page
                header("location: ../../scr_100x/scr_1003/scr_1003.php");
              } else {
                // Display an error message if password is not valid
                $password_err = "The password you entered was not valid.";
              }
            }
          } else {
            // Display an error message if username doesn't exist
            $email_teacher_err = "No account found with that your email!";
          }
        } else {
          echo "Oops! Something went wrong. Please try again later.";
        }
        // Close statement
        mysqli_stmt_close($stmt);
      }
    }
    // Close connection
    mysqli_close($link);
  }
?>

<!DOCTYPE html>
<html>

<!-- Head -->
<head>

<title>LOGIN | TEACHER</title>

<!-- Meta-Tags -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
<script type="application/x-javascript">
addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
function hideURLbar(){ 
  window.scrollTo(0,1); 
}

</script>
<!-- //Meta-Tags -->

<link href="../../css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />

<!-- Style --> <link rel="stylesheet" href="../../css/style.css" type="text/css" media="all">

<!-- Fonts -->
<!-- //Fonts -->

</head>
<!-- //Head -->

<!-- Body -->
<body>

	<h1>TEACHER</h1>

	<div class="w3layoutscontaineragileits">
	<h2>Login here</h2>
		<form class="login-html" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="<?php echo (!empty($email_teacher_err)) ? 'has-error' : ''; ?>">
        <input type="text" placeholder="Enter your email" name="email_teacher" value="<?php echo $email_teacher; ?>" required>
          <p class="w3-text-red w3-center"><?php echo $email_teacher_err; ?></p>
          <p class="w3-text-red"><?php echo $password_err; ?></p>
      </div>
      <div class="<?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
        <input type="password" placeholder="Enter Password" name="password" required>
      </div>
			<ul class="agileinfotickwthree">
				<li>
					<input type="checkbox" id="brand1" value="">
					<label for="brand1"><span></span>Remember me</label>
					<a href="#">Forgot password?</a>
        </li>
			</ul>
			<div class="aitssendbuttonw3ls">
				<input type="submit" value="LOGIN">
				<p> To register new account <span>→</span> <a href="../register/teacher.php"> Click Here</a></p>
				<p><a href="../../">Cancel</a></p>
			</div>
		</form>
	</div>
	
	
	<div class="w3footeragile">
		<p> &copy; 2019 Login Form. All Rights Reserved | Design by <a href="../../" target="_blank">ORIGEN</a></p>
	</div>

	
	<script type="text/javascript" src="../../js/jquery-2.1.4.min.js"></script>

	<!-- pop-up-box-js-file -->  
		<script src="../../js/jquery.magnific-popup.js" type="text/javascript"></script>
	<!--//pop-up-box-js-file -->
	<script>
		$(document).ready(function() {
		$('.w3_play_icon,.w3_play_icon1,.w3_play_icon2').magnificPopup({
			type: 'inline',
			fixedContentPos: false,
			fixedBgPos: true,
			overflowY: 'auto',
			closeBtnInside: true,
			preloader: false,
			midClick: true,
			removalDelay: 300,
			mainClass: 'my-mfp-zoom-in'
		});
																		
		});
	</script>

</body>
</html>