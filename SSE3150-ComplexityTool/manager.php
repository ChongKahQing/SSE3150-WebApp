<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" style="height: 100%;">

<head>
  <title>Project Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="main.css">
  <style>

      body{
        background: linear-gradient(45deg, #49a09d, #5f2c82);
        height: 100%;
      }
      table tr td:last-child{
          width: 120px;

      }
      table th, td {
	       padding: 15px;
         border: 1px solid black;
         }

      table th {
	       text-align: left;
      }

      table td{
        background: #edebeb;
      }
      thead th {
		     background-color: #080808;
         color: #fff;
	    }

  </style>
  <script>
      $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();
      });
  </script>
</head>

<body>
<nav class="navbar navbar-expand-md">
  <a class="navbar-brand" href="manager.php">Project</a>

  <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-
  target="#main-navigation">
  <span class="navbar-toggler-icon"></span></button>
  <div class="collapse navbar-collapse" id="main-navigation">
    <ul class="navbar-nav"> <li class="nav-item">
      <a class="nav-link" href="#home">Home</a> </li>

      <li class="nav-item">
        <a class="nav-link" href="information.php">Information</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="registerproject.php">Register</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>

<header class="page-header header container-fluid" id="home">
<div class="wrapper">
<div class="container-fluid">
<div class="row">
  <div class="col-md-12"></div>
  <div class="mt-5 mb-3 clearfix">
    <br><h2 class="text-center" style="color:white;">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1><br>
  </div>
  <?php
  // Include pdo file
  require_once "pdo.php";

  if(isset($_SESSION['error'])){
    echo '<p style ="color:red">'. $_SESSION['error']. "</p>\n";
    unset($_SESSION['error']);
  }
  if(isset($_SESSION['success'])){
    echo '<p style ="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
  }

  // Attempt select query execution
  $sql = "SELECT Project_ID, Project_Name, Financial_Funds, Project_Duration, Mode FROM project WHERE User_id = '".$_SESSION['id']."'";
  if($result = $pdo->query($sql)){
      if($result->rowCount() > 0){
          echo '<table class="table table-bordered table-striped style="background-color:white;"">';
              echo "<thead>";
                  echo "<tr>";
                      echo "<th>Project Name</th>";
                      echo "<th>Financial/Funds</th>";
                      echo "<th>Project Duration</th>";
                      echo "<th>Mode</th>";
                      echo "<th>Action</th>";
                  echo "</tr>";
              echo "</thead>";
              echo "<tbody>";
              while($row = $result->fetch()){
                  echo "<tr>";
                      echo "<td>" . $row['Project_Name'] . "</td>";
                      echo "<td>" . $row['Financial_Funds'] . "</td>";
                      echo "<td>" . $row['Project_Duration'] . "</td>";
                      echo "<td>" . $row['Mode'] . "</td>";
                      echo "<td>";
                          echo '<a href="read.php?id='. $row['Project_ID'] .'" class="mr-3" title="View Record" data-toggle="tooltip">
                          <span class="fa fa-eye"></span></a>';
                          echo '<a href="section1.php?id='. $row['Project_ID'] .'" class="mr-3" title="Update Record" data-toggle="tooltip">
                          <span class="fa fa-pencil"></span></a>';
                          echo '<a href="delete.php?id='. $row['Project_ID'] .'" title="Delete Record" data-toggle="tooltip">
                          <span class="fa fa-trash"></span></a>';
                      echo "</td>";
                  echo "</tr>";
              }
              echo "</tbody>";
          echo "</table>";
          // Free result set
          unset($result);
      } else{
          echo '<div class="alert alert-danger"><em>No records were found. Please register new project.</em></div>';
      }
  } else{
      echo "Oops! Something went wrong. Please try again later.";
  }

  // Close connection
  unset($pdo);
  ?>
</div>
</div>
</div>
</div>
</div>
</header>
</body>

</html>
