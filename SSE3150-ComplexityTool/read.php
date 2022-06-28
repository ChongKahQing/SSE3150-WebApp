<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include pdo file
    require_once "pdo.php";

    // Prepare a select statement
    $sql = "SELECT p.Rating_Section1, p.Rating_Section2, p.Rating_Section3, p.Rating_Section4, p.Rating_Section5, p.Rating_Section6, p.Rating_Section7, p.Total_Rating, c.CRL_Name FROM project_risk p JOIN complexityrisklevel c on p.CRL_ID = c.CRL_ID WHERE Project_ID = :id";

    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Retrieve individual field value
                $section1 = $row["Rating_Section1"];
                $section2 = $row["Rating_Section2"];
                $section3 = $row["Rating_Section3"];
                $section4 = $row["Rating_Section4"];
                $section5 = $row["Rating_Section5"];
                $section6 = $row["Rating_Section6"];
                $section7 = $row["Rating_Section7"];
                $total = $row["Total_Rating"];
                $risk = $row["CRL_Name"];

            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }

        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    unset($stmt);

    // Close connection
    unset($pdo);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link type = "text/css" rel="stylesheet" href="bg.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body style="background: linear-gradient(45deg, #49a09d, #5f2c82);height: 100%;margin: 0;">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-6 col-lg-7 col-xl-5">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
          <div class="card-body p-4 p-md-5">
                    <h1 class="mb-3">View Result</h1>

                    <div class="form-group">
                        <label>Section 1: Project Characteristics</label>
                        <p><b><?php echo htmlentities("$section1"); ?></b>/90</p>
                    </div>
                    <div class="form-group">
                        <label>Section 2: Strategic Management Risks</label>
                        <p><b><?php echo htmlentities("$section2"); ?></b>/30</p>
                    </div>
                    <div class="form-group">
                        <label>Section 3: Procurement Risks</label>
                        <p><b><?php echo htmlentities("$section3"); ?></b>/45</p>
                    </div>
                    <div class="form-group">
                        <label>Section 4: Human Resource Risks</label>
                        <p><b><?php echo htmlentities("$section4"); ?></b>/25</p>
                    </div>
                    <div class="form-group">
                        <label>Section 5: Business Risks</label>
                        <p><b><?php echo htmlentities("$section5"); ?></b>/25</p>
                    </div>
                    <div class="form-group">
                        <label>Section 6: Project Management Integration Risks</label>
                        <p><b><?php echo htmlentities("$section6"); ?></b>/30</p>
                    </div>

                    <div class="form-group">
                        <label>Section 7: Project Requirements Risks</label>
                        <p><b><?php echo htmlentities("$section7"); ?></b>/75</p>
                    </div>
                    <div class="form-group">
                        <label>Total Score:</label>
                        <p><b><?php echo htmlentities("$total"); ?></b>/320</p>
                    </div>

                    <div class="form-group">
                        <label>Complexity and Risk Level:</label>
                        <p><b><?php echo htmlentities("$risk"); ?></b></p>
                    </div>
                    <br>
                    <p><a href="manager.php" class="btn btn-primary">Back</a></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
</body>
</html>
