<?php
require_once('pdo.php');
session_start();
$project_id = $_SESSION['project_id']; //to make it applicable in query
$stmt = $pdo->query("SELECT rating_section1, rating_section2, rating_section3, rating_section4, rating_section5, rating_section6, rating_section7
FROM project_risk
WHERE project_id = $project_id ");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
$rating = array();
for($i = 1; $i <= 7; $i++){
    array_push($rating,$row['rating_section' . $i]);
}
}

?>



<!DOCTYPE html>
<html>
<meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

    <head><link type="text/css" rel="stylesheet" href="sections.css"></head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<body>

<canvas id="myChart" style="width:100%;max-width:800px"></canvas>

<?php

?>
<script>
var xValues = ["Project Characteristic", "Strategic Management Risks", "Procurement Risks", "Human Resource Risks", "Business Risks","Project Management Integration Risks","Project Requirements Risks"];
var yValues = <?php echo json_encode($rating); ?>;
var barColors = ["red", "green","blue","orange","brown", "yellow", "grey"];

new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Complexity and Risk Level"
    }
  }
});
</script>

<div>
    <?php
    $stmt = $pdo->query("SELECT c.crl_name, c.crl_definition, p.total_rating
    FROM project_risk p
    JOIN complexityrisklevel c
    ON c.crl_id = p.crl_id
    WHERE p.project_id = $project_id");

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo('<div>Total Score: ');
        echo(htmlentities($row['total_rating']));
        echo("</div>");
        echo('<div>Complexity and Risk Level: ');
        echo(htmlentities($row['crl_name']));
        echo("</div>");


    }

    ?>
</div>
<a href='manager.php'><button type="button" class="btn btn-light">Home</button></a>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
