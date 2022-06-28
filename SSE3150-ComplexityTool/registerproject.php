<?php
require_once "pdo.php";
session_start();
if(isset($_POST['project_name']) && isset($_POST['mode'])){
  if(strlen($_POST['project_name']) < 1 || strlen($_POST['mode']) < 1 ){
    $_SESSION['error'] = "Project name and mode are required";
    header('Location:manager.php');
    return;
  }else{
    $sql1 = "INSERT INTO project (Project_Name, Mode, User_ID) VALUES (:project_name, :mode, :user_id)";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1 -> execute(array(
      ':project_name' => $_POST['project_name'],
      ':mode' => $_POST['mode'],
      ':user_id' => $_SESSION['id']));
      $stmt2 = $pdo->prepare("SELECT Project_ID FROM Project where Project_Name = :project_name AND Mode = :mode AND User_ID = :user_id");
      $stmt2->execute(array(
        ':project_name' => $_POST['project_name'],
        ':mode' => $_POST['mode'],
        ':user_id' => $_SESSION['id']));
        $row = $stmt2 ->fetch(PDO::FETCH_ASSOC);
        $_SESSION['project_id'] = $row['Project_ID'];

      $_SESSION['success']='Project Added';
      header('Location:manager.php');
      return;
  }
}
 ?>
<!doctype html>
<html lang="en" style="height: 100%;">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title> Register Project </title>
  <link type = "text/css" rel="stylesheet" href="bg.css">
</head>
<body style="background: linear-gradient(45deg, #49a09d, #5f2c82);height: 100%;margin: 0;">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-6 col-lg-7 col-xl-5">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Project Registration</h3>
            <form method = "post">

              <div class="form-input">
                <label class="form-label select-label">Project Name:</label><br>
                <input type="text" id="project_name" name="project_name"class="form-control form-control-lg" placeholder="Project Name" tabindex="10" required/>
              </div>

              <div class="row">
                <div class="form-group">
                  <label class="form-label select-label">Mode:</label><br>
                  <select name = "mode" class="select form-control-lg">
                    <option value="0" disabled>-Choose option-</option>
                    <option value="Insource">Insource</option>
                    <option value="Outsource">Outsource</option>
                    <option value="Co-source">Co-source</option>
                    <option value="Unspecified">Unspecified</option>
                  </select>
                </div>
              </div>

              <div class="mt-4 pt-2">
                <input class="btn btn-primary btn-lg" type="submit" value="Confirm" />
                <a href= "manager.php"><input class="btn btn-danger btn-lg" type="button" value="Cancel" /></a>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
