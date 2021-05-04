<?php
// Include config file
include_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password =  "";
$username_err = $password_err = $confirm_password_err =  "";
// Processing form data when form is submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Validate username
  if (empty(trim($_POST['uname']))) {
    $username_err = "Please enter a username.";
  } else {
    // Prepare a select statement
    $sql = "SELECT username FROM users WHERE username = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_username);

      // Set parameters
      $param_username = trim($_POST['uname']);

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        /* store result */
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
          $username = trim($_POST['uname']);
        } else {
          $username_err = "There is no account with that username";
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }
  }

  // Validate password
  $password = $_POST['psw'];
  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $number    = preg_match('@[0-9]@', $password);
  $specialChars = preg_match('@[^\w]@', $password);
  if (empty($password)) {
    $password_err = "Please enter a password.";
  } elseif (strlen(trim($_POST['psw'])) < 8) {
    $password_err = "Password must have atleast 8 characters.";
  } elseif (!$uppercase) {
    $password_err = "Password should contain 1 upper case.";
  } elseif (!$lowercase) {
    $password_err = "Password should contain 1 lower case.";
  } elseif (!$number) {
    $password_err = "Password should contain 1 number.";
  } elseif (!$specialChars) {
    $password_err = "Password should contain 1 special character.";
  } else {
    $password = trim($_POST['psw']);
  }

  // Validate confirm password
  if (empty(trim($_POST['psw-repeat']))) {
    $confirm_password_err = "Please enter confirm password.";
  } else {
    $confirm_password = trim($_POST['psw-repeat']);
    if (empty($password_err) && ($password != $confirm_password)) {
      $confirm_password_err = "Password did not match.";
    }
  }

  // Check input errors before inserting in database
  if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

    // Prepare an update statement
    $sql = "UPDATE users SET password = ? WHERE username = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_username);

      // Set parameters
      $param_password = md5($password); // Creates a password hash
      $param_username = $username;

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {

        // prepare and bind
        $stmt1 = $link->prepare("INSERT INTO activity_log (activity, username) VALUES (?, ?)");
        $stmt1->bind_param("ss", $activity, $username);

        // // set parameters and execute
        $activity = "Reset a Password";

        $stmt1->execute();
        $stmt1->close();

        // Redirect to login page
        header("location: index.php");
      } else {
        echo "Something went wrong. Please try again later.";
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

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <style>
    body {
      background-image: url(bg1.jpg);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 90vh;
    }

    * {
      font-family: sans-serif;
      box-sizing: border-box;
    }

    .container {
      padding: 20px;
      background-color: white;
      border: 2px solid #ccc;
      border-radius: 15px;
      width: 500px;
    }

    .pswcontainer {
      padding: 16px;
      background-color: #f7eb7e;
    }

    input[type=text],
    input[type=password],
    input[type=email] {
      font-size: 13px;
      display: block;
      border: 2px solid #ccc;
      padding: 10px;
      width: 95%;
      margin: 5px;
      border-radius: 5px;
    }

    input[type=text]:focus,
    input[type=password]:focus,
    input[type=email]:focus {
      background-color: #f6fcf7;
    }

    span {
      padding-left: 10px;
    }

    label {
      color: #444;
      font-size: 18px;
      padding-left: 10px;
    }

    h2 {
      font-size: 30px;
      text-align: left;
      padding-left: 10px;
      margin-bottom: 40px;
    }

    .registerbtn {
      background: #599fc7;
      padding: 10px;
      margin-top: 10px;
      color: #fff;
      border-radius: 5px;
      margin-right: 10px;
      border: none;
    }

    .registerbtn:hover {
      opacity: .7;
    }

    .ca {
      font-size: 14px;
      display: inline-block;
      padding: 5px;
      text-decoration: none;
      color: #444;
      margin-bottom: 0px;

    }

    .ca:hover {
      text-decoration: underline;
      color: #444;
    }

    .signin {
      background-color: #f1f1f1;
      text-align: center;
    }
  </style>
</head>

<body>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="container">
      <h2><b>Reset Password</b></h2>
      
      <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
        <label for="uname">Username</label>
        <input type="text" placeholder="Enter Username" name="uname" id="uname" class="form-control" value="<?php echo $username; ?>">
        <span class="help-block">
          <?php echo $username_err; ?>
        </span>
      </div>

      <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
        <label for="psw">New Password</label>
        <input type="password" placeholder="Enter Password" name="psw" id="psw" class="form-control" value="<?php echo $password; ?>">
        <span class="help-block"><?php echo $password_err; ?></span>
      </div>

      <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
        <label for="psw-repeat">Repeat Password</label>
        <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" class="form-control" value="<?php echo $confirm_password; ?>">
        <span class="help-block"><?php echo $confirm_password_err; ?> </span>
        <br>
        <center><button type="submit" name="submit" class="registerbtn">Reset Password</button></center>
        <center> <a href="index.php" class="ca">Already have an account? Sign in</a> </center>
      </div>
      <!--  <div class="container signin">
      <p>Already have an account? <a href="index.php">Sign in</a>.</p>
    </div>
 -->
  </form>

</body>

</html>