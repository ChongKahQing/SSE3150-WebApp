<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["login"]) && $_SESSION["login"] === true){

  if($_SESSION["position"]=="admin"){
    header("location: Admin_Menu.php");
    exit;
  }
  else{
    header("location: manager.php");
    exit;
  }
}

// Include config file
require_once "pdo.php";

// Define variables and initialize with empty values
$name = $username = $password = $position = "";
$name_err = $username_err = $password_err = $position_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if name is empty
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter your name.";
    } else{
        $name = trim($_POST["name"]);
    }

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    //Check if position is empty
    if($_POST["position"]=="0"){
        $position_err = "Please select your position.";
    } else{
        $position = trim($_POST["position"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err) && empty($name_err) && empty($position_err)){
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE name = :name AND username = :username AND position = :position";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":position", $param_position, PDO::PARAM_STR);
            // Set parameters
            $param_name = trim($_POST["name"]);
            $param_username = trim($_POST["username"]);
            $param_position = trim($_POST["position"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["username"];
                        $position = $row["position"];
                        $hashed_password = $row["password"];

                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["login"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $username;
                            $_SESSION["username"] = $username;
                            $_SESSION["position"] = $position;

                            if ($row["position"]=="admin"){
                              // Redirect user to admin page
                              header("location: Admin_Menu.php");
                            }
                            else{
                              // Redirect user to manager page
                              header("location: manager.php");
                            }
                        } else{

                            // Password is not valid, display a generic error message
                            $login_err = "Invalid name or username or position or password.";

                            if(!ISSET($_SESSION['attempt'])){
                              $_SESSION['attempt'] = 0;
                            }

                            $_SESSION['attempt'] += 1;

                            if($_SESSION['attempt'] === 3){
                              $_SESSION['msg'] = "disabled";
                              $_SESSION['attempt_again'] = time() + (5);
                            }

                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid name or username or position or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);
}

//check if can login again
if(isset($_SESSION['attempt_again'])){
  $now = time();
  if($now >= $_SESSION['attempt_again']){
    $_SESSION['msg'] = "enabled";
    unset($_SESSION['attempt']);
    unset($_SESSION['attempt_again']);
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</head>
<body style="background: linear-gradient(45deg, #49a09d, #5f2c82) !important;">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-lg-10 col-xl-9 card flex-row mx-auto px-0">
        <div class="img-left d-none d-md-flex"></div>

        <div class="card-body">
          <h4 class="title text-center mt-4">
            Login
          </h4>

          <?php
          if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
          }
          ?>

          <form class="form-box px-3" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="form-input">
              <span><i class="fa fa-user"></i></span>
              <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
              value="<?php echo $name; ?>" placeholder="Name" tabindex="10" required>
              <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>

            <div class="form-input">
              <span><i class="fa fa-user"></i></span>
              <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
              value="<?php echo $username; ?>" placeholder="Username" tabindex="10" required>
              <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>

            <div class="form-group">
            <select class="form-control <?php echo (!empty($position_err)) ? 'is-invalid' : ''; ?>"
            value="<?php echo $position; ?>" name="position">
              <option value="0" selected>-Select Position-</option>
              <option value="admin">System Admin</option>
              <option value="manager">Project Manager</option>
            </select>
            </div>

            <div class="form-input">
              <span><i class="fa fa-key"></i></span>
              <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
              value="<?php echo $password; ?>" placeholder="Password" required>
            </div>

            <div class="mb-3">
              <button type="submit" class="btn btn-block text-uppercase" name="login"
              <?php if(ISSET($_SESSION['msg'])){ echo $_SESSION['msg'];}?> style="background: #55608f;">
                Login
              </button>
            </div>

            <hr class="my-4">

            <div class="text-center mb-2">
              Don't have an account?
              <a href="register.php" class="register.php">
                Register here
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
