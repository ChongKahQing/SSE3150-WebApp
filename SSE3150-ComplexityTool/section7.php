<?php
require_once "pdo.php";
session_start();

$project_id = $_SESSION['project_id'];

if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red; margin-top:30px;">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
    }


//check all question got answer
$stmt = $pdo->query("SELECT count(*) as total
FROM question
WHERE  section_id= 7");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $totalQues = $row['total'];
}
$POSTtocheck = array();
for ($i = 1; $i <= $totalQues; $i++) {
    array_push($POSTtocheck, 'rate' . $i);
}
$checkButton = true;
foreach ($POSTtocheck as $key) {
    if (isset($_POST[$key])) {
        $checkButton = true;
    }
    else {
        $checkButton = false;
        break;
    }
}

//if all button is checked
if ($checkButton) {
    $_SESSION['section7'] = calcScore($totalQues); //section 7 result

 $total = $_SESSION['section1'] + $_SESSION['section2'] + $_SESSION['section3'] + $_SESSION['section4'] +
 $_SESSION['section5'] + $_SESSION['section6'] + $_SESSION['section7'];//calculate total

 if($total < 45){   //check crl
    $crl = 1;
}else if(45 <= $total && $total <= 63){
    $crl = 2;
}else if(64 <= $total && $total <= 82){
    $crl = 3;
}else {
    $crl = 4;
}

$stmt = $pdo->query("SELECT *
            FROM project_risk
            WHERE project_id = $project_id"); //check if row exist

$numOfRow = 0; //increment will become 0

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $numOfRow ++;
}
 //insert new row in project_risk if first time assessment
 if($numOfRow == 0){
    $sql = "INSERT INTO project_risk (total_rating, rating_section1, rating_section2, rating_section3, rating_section4, rating_section5, rating_section6,
    rating_section7, crl_id, project_id)
    values (:total, :section1,:section2, :section3, :section4, :section5, :section6, :section7, :crl_id, :id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
    ':total' => $total,
    ':section1' => $_SESSION['section1'],
    ':section2' => $_SESSION['section2'],
    ':section3' => $_SESSION['section3'],
    ':section4' => $_SESSION['section4'],
    ':section5' => $_SESSION['section5'],
    ':section6' => $_SESSION['section6'],
    ':section7' => $_SESSION['section7'],
    ':crl_id' => $crl,
    ':id' => $_SESSION['project_id'],
    ));

    header('location: result.php');
    exit();
 }else{ //if retest project
    $sql = "UPDATE project_risk SET total_rating = :total,
    rating_section1 = :section1,
    rating_section2 = :section2,
    rating_section3 = :section3,
    rating_section4 = :section4,
    rating_section5 = :section5,
    rating_section6 = :section6,
    rating_section7 = :section7,
    crl_id = :crl_id
    WHERE project_id = $project_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':total' => $total,
        ':section1' => $_SESSION['section1'],
        ':section2' => $_SESSION['section2'],
        ':section3' => $_SESSION['section3'],
        ':section4' => $_SESSION['section4'],
        ':section5' => $_SESSION['section5'],
        ':section6' => $_SESSION['section6'],
        ':section7' => $_SESSION['section7'],
        ':crl_id' => $crl,
        ));
    header('location: result.php');
    exit();

 }

}else{
    $_SESSION['error'] = "Please answer all the questions!";
}
?>

<html >
 <head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

 <link type="text/css" rel="stylesheet" href="sections.css">


        <?php
function showQuestion(PDO $pdo, $start, $end)
{
    $stmt = $pdo->query("SELECT q.ques_id, q.ques_description, r.rating_id, r.rating1, r.rating2, r.rating3, r.rating4, r.rating5
            FROM question q
            JOIN rating r
            ON q.rating_id = r.rating_id
            WHERE q.ques_id BETWEEN $start and $end");

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $x = $GLOBALS['x'];
        echo(nl2br(htmlentities($row['ques_id'])) . ". ");
        echo(nl2br(htmlentities($row['ques_description'])) . "<br>");
        for ($i = 1; $i <= 5; $i++) {
            if ($row['rating' . $i] != null) {
                echo('<label class="container">');
                echo(htmlentities($row['rating' . $i]));
                echo("<input type='radio' style='margin-right:5px;'name='rate$x' value='$i'/>");
                echo('<span class="checkmark"></span></label>');
            }
        }
        echo("<br>");
        $GLOBALS['x']++;
    }
}

function calcScore($totalQues)
{
    $total = 0;
    for ($x = 1; $x <= $totalQues; $x++) {
        $total += $_POST['rate' . $x];
    }
    return $total;
}


?>

    </head>
    <body>

        <h1>Project Requirements Risks</h1>

        <h2>Scope</h2>
        <form method="post">
        <?php
$GLOBALS['x'] = 1;
showQuestion($pdo, 50, 57);
?>

<h2>Investment portfolio management</h2>
        <?php
showQuestion($pdo, 58,59);
?>

<h2>Scope</h2>
        <?php
showQuestion($pdo, 60,64);
?>
        <input type="submit" class="btn btn-light btn-lg" name="dopost" value="Submit"/>
        </form>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    </body>
</html>
