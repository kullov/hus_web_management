<?php
  // Include config file
  require_once "../../config.php";

  // Define variables and initialize with empty values
  $username = $first_name = $last_name = $class_name = $join_date = $phone = $email = $address = $date_of_birth = $password = $confirm_password = $avatar = "";
  $username_err = $first_name_err = $last_name_err = $class_name_err = $join_date_err = $phone_err = $email_err = $address_err = $date_of_birth_err = $password_err = $confirm_password_err = $avatar_err = "";

  // Processing form data when form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
      $username_err = "Please enter a username.";
    } else {
      // Prepare a select statement
      $sql = "SELECT id FROM intern_profile WHERE code = ?";

      if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_username);

        // Set parameters
        $param_username = trim($_POST["username"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
          /* store result */
          mysqli_stmt_store_result($stmt);

          if (mysqli_stmt_num_rows($stmt) == 1) {
            $username_err = "This student id is already taken.";
          } else {
            $username = trim($_POST["username"]);
          }
        } else {
          echo "Oops! Something went wrong. Please try again later.";
        }
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
      $password_err = "Please enter a password!";
    } elseif (strlen(trim($_POST["password"])) < 6) {
      $password_err = "Password must have atleast 6 characters.";
    } else {
      $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
      $confirm_password_err = "Please confirm password!";
    } else {
      $confirm_password = trim($_POST["confirm_password"]);
      if (empty($password_err) && ($password != $confirm_password)) {
        $confirm_password_err = "Password did not match!";
      }
    }

    // Validate phone
    if (empty(trim($_POST["phone"]))) {
      $phone_err = "Please enter your phone number!";
    } elseif (strlen(trim($_POST["phone"])) < 6) {
      $phone_err = "Your phone number is incorrect!";
    } else {
      $phone = trim($_POST["phone"]);
    }
    
    // Validate first name
    if (empty(trim($_POST["first_name"]))) {
      $first_name_err = "Please enter your first name!";
    } else {
      $first_name = trim($_POST["first_name"]);
    }

    // Validate last name
    if (empty(trim($_POST["last_name"]))) {
      $last_name_err = "Please enter your last name!";
    } else {
      $last_name = trim($_POST["last_name"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
      $email_err = "Please enter your email!";
    } else {
      $email = trim($_POST["email"]);
    }

    // Validate class_name
    if (empty(trim($_POST["class_name"]))) {
      $class_name_err = "Please enter your class name!";
    } else {
      $class_name = trim($_POST["class_name"]);
    }

    // Validate address
    // if (empty(trim($_POST["address"]))) {
    //   $address_err = "Please enter your address!";
    // } else {
    //   $address = trim($_POST["address"]);
    // }

    // Validate birth_day
    if (empty(trim($_POST["date_of_birth"]))) {
      $date_of_birth_err = "Please enter your birthday!";
    } else {
      $date_of_birth = trim($_POST["date_of_birth"]);
    }

    // Validate join_date
    if (empty(trim($_POST["join_date"]))) {
      $join_date_err = "Please enter your join date!";
    } else {
      $join_date = trim($_POST["join_date"]);
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

      // Prepare an insert statement
      $sql = "INSERT INTO intern_profile (code, password, first_name, last_name, phone, email, date_of_birth, join_date, class_name, avatar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

      if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ssssssssss", $param_username, $param_password, $first_name, $last_name, $phone, $email, $date_of_birth, $join_date, $class_name, $avatar);

        // Set parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
          // Redirect to login page
          header("location: ../login/student.php");
        } else {
          echo "Something went wrong. Please try again later.";
        }
      }

      // Close statement
      // mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
  }

  if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    $_SESSION["role"] = "";
  }
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src='https://kit.fontawesome.com/a076d05399.js'></script>
  <title>Register</title>
  <style>
    *, *:before, *:after {
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      width: 100%;
      overflow: hidden;
    }
    .container_1 {
      padding: 1px 0;
      height: 100%;
      width: 100%;
      background-image: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/226578/campnou(optimized).jpg");
      background-size: cover;
      color: #fff;
      font-family: "Comfortaa", "Helvetica", sans-serif;
    }
    .login {
      max-width: 990px;
      min-height: 600px;
      margin: 15px auto;
      background-color: rgba(10,10,10,.60);
    }
    .login-icon-field {
      height: 120px;
      width: 100%;
    }
    .login-icon {
      margin: 35px 65px;
    }
    .login-form {
      padding: 10px 0px 5px;
      height: 120px;
      width: 900px;
    }
    input {
      position: absolute;
      width: 250px;
      height: 40px;
      margin: 10px 0;
      background: transparent;
      color: rgba(255,255,255,.4);
      border: none;
      border-bottom: 1px solid white;
      border-color: white;   
    }
    button {
         
    }
    button:hover {
      background-color: #26d69a;
    }
    button:active {
      background-color: #1eaa7a;
    }
    p {
      display: inline-block;
      width: 300px;
      margin: 0 20px;
      font-size: 17px;
      color: rgba(255,255,255,.4);
    }
    @-webkit-keyframes dash {
      to {
        stroke-dashoffset: 0;
      }
    }
    @keyframes dash {
      to {
        stroke-dashoffset: 0;
      }
    }
    .btn-register {
      /* margin: 30px 0px 10px; */
      margin: 20px 10px;
      display: block;
      width: 400px;
      height: 40px;
      padding: 0;
      font-weight: 700;
      background-color: #22c08a;
      border: none;
      border-radius: 20px;  
    }
    .row-btn {
      width: 150px;
      border-radius: 10px;
    }
    .btn-register {
      margin-left: 246px;
    }
    .btn-button {
      /* margin: 30px 101px 10px; */
      margin-left: 233px;
    }
    .btn-button-2 {
      margin-right: 245px;
      height: 41px;
    }
    .note {
      margin-left: -28px;
    }
  </style>
</head>

<body>
  <div class="container_1 ">
    <div id="login" class="login ">
      <div class="login-icon-field w3-center">
        <div><i class="fa fa-users w3-jumbo login-icon w3-center"></i></div>
      </div>
      <div class="login-form container">
        <form class="login-html" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <h2 for="" class="text-white w3-center" style="font-family: Poppins-Medium;">REGISTER STUDENT</h2>
          <div class="login-form w3-row ">
            <div class="w3-col s4">
              <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label for="username" class=" mt-3 pr-2" style="font-family: Poppins-Medium;"><i class="	fa fa-user w3-large w3-left"></i></label>
                <input class="mb-4" type="text" placeholder="Enter username" name="username" value="<?php echo $username; ?>" required>
              </div>
              <span class="w3-text-red"><?php echo $username_err; ?></span>
              <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label for="password" class="mt-3 pr-2 text-white" style="font-family: Poppins-Medium;"><i class="fa fa-key w3-large w3-left"></i></label>
                <input class="" placeholder="Enter your password"  type="password" name="password" class="form-control" value="<?php echo $password; ?>" required>              
              </div>
              <span class="w3-text-red"><?php echo $password_err; ?></span>
              <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label for="confirm_password" class=" mt-3 pr-2" style="font-family: Poppins-Medium;"><i class="fa fa-plane w3-large w3-left"></i></label>
                <input class="" placeholder="Enter Confirm Password"  type="password" name="confirm_password" value="<?php echo $confirm_password; ?>" required>             
              </div>
              <span class="w3-text-red"><?php echo $confirm_password_err; ?></span>
              <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label for="email" class=" mt-3 pr-2" style="font-family: Poppins-Medium;"><i class="far fa-envelope w3-xlarge w3-left "></i></label>
                <input class="" type="text" placeholder="Enter your email" name="email" value="<?php echo $email; ?>">             
              </div>
              <span class="w3-text-red"><?php echo $email_err; ?></span>
            </div>

            
            
            <div class="w3-col s4">
              <div class="form-group <?php echo (!empty($join_date_err)) ? 'has-error' : ''; ?>">
                <label for="join_date" class="mt-3 pr-2 text-white" style="font-family: Poppins-Medium;"><i class="far fa-calendar-alt w3-large w3-left"></i></label>
                <input class="" placeholder="Enter join date"  type="date" name="join_date" class="form-control" value="<?php echo $join_date; ?>" required>              
              </div>
              <span class="w3-text-red"><?php echo $join_date_err; ?></span>
              <div class="form-group <?php echo (!empty($class_name_err)) ? 'has-error' : ''; ?>">
                <label for="class_name" class=" mt-3 pr-2" style="font-family: Poppins-Medium;"><i class="far fa-id-card w3-large w3-left"></i></label>
                <input class="" placeholder="Enter your class name"  type="password" name="class_name" value="<?php echo $class_name; ?>" required>             
              </div>
              <span class="w3-text-red"><?php echo $class_name_err; ?></span>
              <div class="form-group <?php echo (!empty($avatar_err)) ? 'has-error' : ''; ?>">
                <label for="avatar" class=" mt-3 pr-2" style="font-family: Poppins-Medium;"><i class="fas fa-images w3-large w3-left"></i></label>
                <input class="" type="text" placeholder="Enter your link photo" name="avatar" value="<?php echo $avatar; ?>">
              </div>
              <span class="w3-text-red"><?php echo $avatar_err; ?></span>
            </div>

            <div class="w3-col s4">
              <div class="form-group <?php echo (!empty($last_name_err)) ? 'has-error' : ''; ?>">
                <label for="last_name" class=" mt-3 pr-2" style="font-family: Poppins-Medium;"><i class="fa fa-male w3-large w3-left "></i></label>
                <input class="" type="text" placeholder="Enter your last name" name="last_name" value="<?php echo $last_name; ?>">             
              </div>
              <span class="w3-text-red"><?php echo $last_name_err; ?></span>
              <div class="form-group <?php echo (!empty($first_name_err)) ? 'has-error' : ''; ?>">
                <label for="first_name" class=" mt-3 pr-2" style="font-family: Poppins-Medium;"><i class="fa fa-male w3-large w3-left"></i></label>
                <input class="" type="text" placeholder="Enter your first name" name="first_name" value="<?php echo $first_name; ?>">
              </div>
              <span class="w3-text-red"><?php echo $first_name_err; ?></span>
              <div class="form-group <?php echo (!empty($date_of_birth_err)) ? 'has-error' : ''; ?>">
                <label for="date_of_birth" class=" mt-3 pr-2" style="font-family: Poppins-Medium;"><i class="far fa-calendar-alt w3-large w3-left"></i></label>
                <input class="" type="date" placeholder="Enter your birth day" name="date_of_birth" value="<?php echo $date_of_birth; ?>">
              </div>
              <span class="w3-text-red"><?php echo $date_of_birth_err; ?></span>
              <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <label for="phone" class=" mt-3 pr-2" style="font-family: Poppins-Medium;"><i class="fa fa-phone w3-large w3-left"></i></label>
                <input class="" type="text" placeholder="Enter your phone number" name="phone" value="<?php echo $phone; ?>">
              </div>
              <span class="w3-text-red"><?php echo $phone_err; ?></span>
            </div>
          </div>
          <div class="w3-row ">
            <div class="btn-register ">
              <button id="login-button" type="submit" class="btn-register w3-center ml-3 mb-1">Register</button>
            </div>
            <div class=" ">
              <p>
                <button type="reset" class=" w3-button w3-red btn-button row-btn btn-button">Reset</button>             
              </p>
              <button type="button" onclick="window.location.href='../../'" class="w3-blue-gray w3-right w3-button row-btn btn-button-2">Cancel</button>
              <p></p>
              <p class="text-white w3-center note mt-2" style="font-family: Poppins-Medium;">Already have an account? <a class="w3-text-blue" href="../login/teacher.php">Login here</a>.</p>
            </div>	
          </div>
          
        </form>
      </div> 
    </div>
  </div>
  <script>
    // Get the modal
    var modal = document.getElementById('dialog');
    // When the user clicks anywhere outside of the modal, close it
    // window.onclick = function(event) {
    //   if (event.target == modal) {
    //     modal.style.display = "none";
    //   }
    // }
    document.getElementById('dialog').style.display='block';
  </script>
</body>

</html>