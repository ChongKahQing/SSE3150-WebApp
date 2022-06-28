<html style="width: 100%;">
<head>
<title>Information Page</title>
<link type = "text/css" rel="stylesheet" href="table.css">
<style>
    .header{
        background-image: url(images.jpeg);
        background-size: 100%;
        background-attachment: fixed;

    }
    .container-fluid{
      margin-left: 120px;
      margin-right: 120px;
      margin-top:50px;
      margin-bottom: 50px;
    }

</style>

</head>
<body style ="color: white;" class="header">

  <div class="container-fluid">
<h1 style ="color: white;">Project Complexity and Risk Assessment Tool</h1>
<p>The assessment is divided into seven sections or categories of questions.</p>
<h2>Description of the sections</h2>
<?php
require_once "pdo.php";
session_start();

$sql = "SELECT section.Section_ID as id, section.Section_Name as name, section.Section_Description as description,
count(question.Ques_ID) as num FROM section join question on section.Section_ID = question.Section_ID group by question.Section_ID";
if($result = $pdo->query($sql)){
    if($result->rowCount() > 0){
      echo '<table class ="responstable">';
      echo '<col style="width:10%">';
      echo '<col style="width:20%">';
      echo '<col style="width:70%">';
      echo "<tr>";
          echo "<th>#</th>";
          echo "<th>Section</th>";
          echo "<th>Description</th>";
      echo "</tr>";
      while($row = $result->fetch()){
          echo "<tr>";
              echo "<td>" . htmlentities($row['id']) . "</td>";
              echo "<td>" . htmlentities($row['name']) . "(" . $row['num'] . " Questions)" . "</td>";
              echo nl2br ("<td>" . htmlentities($row['description']) . "</td>");
          echo "</tr>";
      }
    }
  }
      echo "</table>";
 ?>

  <h2>Value of the sections</h2>
  <?php
  require_once "pdo.php";

  $sql = "SELECT section.Section_Name, count(question.Ques_ID) FROM section  join
  question on section.Section_ID = question.Section_ID group by question.Section_ID";
  if($result = $pdo->query($sql)){
      if($result->rowCount() > 0){
        echo '<table class ="responstable">';
        echo "<tr>";
            echo "<th>Section</th>";
            echo "<th>Number of Question</th>";
            echo "<th>Maximum Score</th>";
        echo "</tr>";
        $totalnum = 0;
        $totalscore = 0;
        while($row = $result->fetch()){
            echo "<tr>";
                echo "<td>" . htmlentities($row['Section_Name']) . "</td>";
                echo "<td>" . $row['count(question.Ques_ID)'] . "</td>";
                $totalnum = $totalnum + $row['count(question.Ques_ID)'];
                echo nl2br ("<td>" . $row['count(question.Ques_ID)']*5 . "</td>");
                $totalscore = $totalscore + ($row['count(question.Ques_ID)']*5);
            echo "</tr>";
        }
        echo "<tr><td>Total</td>";
        echo "<td>". $totalnum . "</td>";
        echo "<td>" . $totalscore . "</td></tr>";
      }
    }
        echo "</table>";
   ?>

   <p> Please note though that if questions 1, 3, and 11, which deal with money, scope,
     and time in the project characteristics section, are all answered as '5', a triple
     constraint condition will apply resulting in '5' response scoring for all questions
      in this section (i.e. the maximum score of 90 for the section). In addition, if
      the project has no procurement (addressed in question 2) the minimum score is
      automatically assigned for each question in the procurement section.</p>

<h2>Complexity and Risk Level Defined</h2>
<?php
require_once "pdo.php";

$sql = "SELECT * FROM complexityrisklevel";
if($result = $pdo->query($sql)){
    if($result->rowCount() > 0){
      echo '<table class ="responstable">';
      echo '<col style="width:20%">';
      echo '<col style="width:60%">';
      echo '<col style="width:20%">';
      echo "<tr>";
          echo "<th>Complexity and Risk Level</th>";
          echo "<th>Definition</th>";
          echo "<th>Score</th>";
      echo "</tr>";
      while($row = $result->fetch()){
        $CRL_ID = htmlentities($row['CRL_ID']);
        $CRL_Name = htmlentities($row['CRL_Name']);
        $CRL_Definition = htmlentities($row['CRL_Definition']);
        $Score = "undefined";
        if ($CRL_ID == 1) {
            $Score =  "less than " . htmlentities($row['CRL_MaxScore']+1);
        } else if ($CRL_ID == 2) {
            $Score = htmlentities($row['CRL_MinScore']) . " to " . htmlentities($row['CRL_MaxScore']);
        } else if ($CRL_ID == 3) {
            $Score =  htmlentities($row['CRL_MinScore']) . " to " . htmlentities($row['CRL_MaxScore']);
        } else {
            $Score = htmlentities($row['CRL_MinScore']) . " and over";
        }
        echo "<tr><td>";
        echo ($CRL_ID . ". " . $CRL_Name);
        echo ("</td><td>");
        echo ($CRL_Definition);
        echo ("</td><td>");
        echo ($Score);
        echo ("</td></tr>");
      }
    }
  }
      echo "</table>";
 ?>

 <h2>Project Complexity and Risk Assessment</h2>
 <h3>3.1 Project Characteristics (18 Questions)</h3>
 <?php
 require_once "pdo.php";

 $sql = "SELECT q.Ques_ID, ka1.KA_Name AS kan1, IFNULL(ka2.KA_Name, '') AS kan2, q.Ques_Description AS ques,
  q.Clarifications AS cla, r.Rating1 AS rat1, IFNULL(r.Rating2, '') AS rat2, IFNULL(r.Rating3, '') AS rat3,
   IFNULL(r.Rating4, '') AS rat4, IFNULL(r.Rating5, '') AS rat5
 FROM question q JOIN knowledgearea ka1 ON q.KA_ID1 = ka1.KA_ID
 LEFT OUTER JOIN knowledgearea ka2 ON q.KA_ID2 = ka2.KA_ID
 JOIN rating r ON q.Rating_ID = r.Rating_ID
 WHERE q.Section_ID = 1
 ORDER BY q.Ques_ID;";
 if($result = $pdo->query($sql)){
     if($result->rowCount() > 0){
       echo '<table class ="responstable">';
       echo '<col style="width:10%">';
       echo '<col style="width:20%">';
       echo '<col style="width:50%">';
       echo '<col style="width:20%">';
       echo "<tr>";
           echo "<th>Knowledge Area</th>";
           echo "<th>Question</th>";
           echo "<th>Clarifications</th>";
           echo "<th>Rating</th>";
       echo "</tr>";
       $count = 1;
       while($row = $result->fetch()){
           echo "<tr>";
               echo "<td>" . htmlentities($row['kan1']) . "\n";
               if (strlen($row['kan2']) >= 1)
               echo nl2br (", " . htmlentities($row['kan2']));
               echo "</td>";
               echo nl2br ("<td>" . $count++ . ". " . htmlentities($row['ques']) . "</td>");
               echo nl2br ("<td>" . htmlentities($row['cla']) . "</td>");
               if (strlen($row['rat1']) >= 1)
               echo nl2br ("<td>" . "1 = " .htmlentities($row['rat1']) . "\n");
               if (strlen($row['rat2']) >= 1)
               echo nl2br ("2 = " .htmlentities($row['rat2']) . "\n");
               if (strlen($row['rat3']) >= 1)
               echo nl2br ("3 = " .htmlentities($row['rat3']) . "\n");
               if (strlen($row['rat4']) >= 1)
               echo nl2br ("4 = " .htmlentities($row['rat4']) . "\n");
               if (strlen($row['rat5']) >= 1)
               echo nl2br ("5 = " .htmlentities($row['rat5']) . "\n");
               echo "</td>";
           echo "</tr>";
       }
     }
   }
       echo "</table>";
  ?>

  <h3>3.2 Strategic Management Risks (6 Questions)</h3>
  <?php
  require_once "pdo.php";

  $sql = "SELECT q.Ques_ID, ka1.KA_Name AS kan1, IFNULL(ka2.KA_Name, '') AS kan2, q.Ques_Description AS ques,
   q.Clarifications AS cla, r.Rating1 AS rat1, IFNULL(r.Rating2, '') AS rat2, IFNULL(r.Rating3, '') AS rat3,
    IFNULL(r.Rating4, '') AS rat4, IFNULL(r.Rating5, '') AS rat5
  FROM question q JOIN knowledgearea ka1 ON q.KA_ID1 = ka1.KA_ID
  LEFT OUTER JOIN knowledgearea ka2 ON q.KA_ID2 = ka2.KA_ID
  JOIN rating r ON q.Rating_ID = r.Rating_ID
  WHERE q.Section_ID = 2
  ORDER BY q.Ques_ID;";
  if($result = $pdo->query($sql)){
      if($result->rowCount() > 0){
        echo '<table class ="responstable">';
        echo '<col style="width:10%">';
        echo '<col style="width:20%">';
        echo '<col style="width:50%">';
        echo '<col style="width:20%">';
        echo "<tr>";
            echo "<th>Knowledge Area</th>";
            echo "<th>Question</th>";
            echo "<th>Clarifications</th>";
            echo "<th>Rating</th>";
        echo "</tr>";
        while($row = $result->fetch()){
            echo "<tr>";
                echo "<td>" . htmlentities($row['kan1']) . "\n";
                if (strlen($row['kan2']) >= 1)
                echo nl2br (", " . htmlentities($row['kan2']));
                echo "</td>";
                echo nl2br ("<td>" . $count++ . ". " . htmlentities($row['ques']) . "</td>");
                echo nl2br ("<td>" . htmlentities($row['cla']) . "</td>");
                if (strlen($row['rat1']) >= 1)
                echo nl2br ("<td>" . "1 = " .htmlentities($row['rat1']) . "\n");
                if (strlen($row['rat2']) >= 1)
                echo nl2br ("2 = " .htmlentities($row['rat2']) . "\n");
                if (strlen($row['rat3']) >= 1)
                echo nl2br ("3 = " .htmlentities($row['rat3']) . "\n");
                if (strlen($row['rat4']) >= 1)
                echo nl2br ("4 = " .htmlentities($row['rat4']) . "\n");
                if (strlen($row['rat5']) >= 1)
                echo nl2br ("5 = " .htmlentities($row['rat5']) . "\n");
                echo "</td>";
            echo "</tr>";
        }
      }
    }
        echo "</table>";
   ?>

   <h3>3.3 Procurement Risks (9 Questions)</h3>
   <?php
   require_once "pdo.php";

   $sql = "SELECT q.Ques_ID, ka1.KA_Name AS kan1, IFNULL(ka2.KA_Name, '') AS kan2, q.Ques_Description AS ques,
    q.Clarifications AS cla, r.Rating1 AS rat1, IFNULL(r.Rating2, '') AS rat2, IFNULL(r.Rating3, '') AS rat3,
     IFNULL(r.Rating4, '') AS rat4, IFNULL(r.Rating5, '') AS rat5
   FROM question q JOIN knowledgearea ka1 ON q.KA_ID1 = ka1.KA_ID
   LEFT OUTER JOIN knowledgearea ka2 ON q.KA_ID2 = ka2.KA_ID
   JOIN rating r ON q.Rating_ID = r.Rating_ID
   WHERE q.Section_ID = 3
   ORDER BY q.Ques_ID;";
   if($result = $pdo->query($sql)){
       if($result->rowCount() > 0){
         echo '<table class ="responstable">';
         echo '<col style="width:10%">';
         echo '<col style="width:20%">';
         echo '<col style="width:50%">';
         echo '<col style="width:20%">';
         echo "<tr>";
             echo "<th>Knowledge Area</th>";
             echo "<th>Question</th>";
             echo "<th>Clarifications</th>";
             echo "<th>Rating</th>";
         echo "</tr>";
         while($row = $result->fetch()){
             echo "<tr>";
                 echo "<td>" . htmlentities($row['kan1']) . "\n";
                 if (strlen($row['kan2']) >= 1)
                 echo nl2br (", " . htmlentities($row['kan2']));
                 echo "</td>";
                 echo nl2br ("<td>" . $count++ . ". " . htmlentities($row['ques']) . "</td>");
                 echo nl2br ("<td>" . htmlentities($row['cla']) . "</td>");
                 if (strlen($row['rat1']) >= 1)
                 echo nl2br ("<td>" . "1 = " .htmlentities($row['rat1']) . "\n");
                 if (strlen($row['rat2']) >= 1)
                 echo nl2br ("2 = " .htmlentities($row['rat2']) . "\n");
                 if (strlen($row['rat3']) >= 1)
                 echo nl2br ("3 = " .htmlentities($row['rat3']) . "\n");
                 if (strlen($row['rat4']) >= 1)
                 echo nl2br ("4 = " .htmlentities($row['rat4']) . "\n");
                 if (strlen($row['rat5']) >= 1)
                 echo nl2br ("5 = " .htmlentities($row['rat5']) . "\n");
                 echo "</td>";
             echo "</tr>";
         }
       }
     }
         echo "</table>";
    ?>

    <h3>3.4 Human Resources Risks (5 Questions)</h3>
    <?php
    require_once "pdo.php";

    $sql = "SELECT q.Ques_ID, ka1.KA_Name AS kan1, IFNULL(ka2.KA_Name, '') AS kan2, q.Ques_Description AS ques,
     q.Clarifications AS cla, r.Rating1 AS rat1, IFNULL(r.Rating2, '') AS rat2, IFNULL(r.Rating3, '') AS rat3,
      IFNULL(r.Rating4, '') AS rat4, IFNULL(r.Rating5, '') AS rat5
    FROM question q JOIN knowledgearea ka1 ON q.KA_ID1 = ka1.KA_ID
    LEFT OUTER JOIN knowledgearea ka2 ON q.KA_ID2 = ka2.KA_ID
    JOIN rating r ON q.Rating_ID = r.Rating_ID
    WHERE q.Section_ID = 4
    ORDER BY q.Ques_ID;";
    if($result = $pdo->query($sql)){
        if($result->rowCount() > 0){
          echo '<table class ="responstable">';
          echo '<col style="width:10%">';
          echo '<col style="width:20%">';
          echo '<col style="width:50%">';
          echo '<col style="width:20%">';
          echo "<tr>";
              echo "<th>Knowledge Area</th>";
              echo "<th>Question</th>";
              echo "<th>Clarifications</th>";
              echo "<th>Rating</th>";
          echo "</tr>";
          while($row = $result->fetch()){
              echo "<tr>";
                  echo "<td>" . htmlentities($row['kan1']) . "\n";
                  if (strlen($row['kan2']) >= 1)
                  echo nl2br (", " . htmlentities($row['kan2']));
                  echo "</td>";
                  echo nl2br ("<td>" . $count++ . ". " . htmlentities($row['ques']) . "</td>");
                  echo nl2br ("<td>" . htmlentities($row['cla']) . "</td>");
                  if (strlen($row['rat1']) >= 1)
                  echo nl2br ("<td>" . "1 = " .htmlentities($row['rat1']) . "\n");
                  if (strlen($row['rat2']) >= 1)
                  echo nl2br ("2 = " .htmlentities($row['rat2']) . "\n");
                  if (strlen($row['rat3']) >= 1)
                  echo nl2br ("3 = " .htmlentities($row['rat3']) . "\n");
                  if (strlen($row['rat4']) >= 1)
                  echo nl2br ("4 = " .htmlentities($row['rat4']) . "\n");
                  if (strlen($row['rat5']) >= 1)
                  echo nl2br ("5 = " .htmlentities($row['rat5']) . "\n");
                  echo "</td>";
              echo "</tr>";
          }
        }
      }
          echo "</table>";
     ?>

     <h3>3.5 Business Risks (5 Questions)</h3>
     <?php
     require_once "pdo.php";

     $sql = "SELECT q.Ques_ID, ka1.KA_Name AS kan1, IFNULL(ka2.KA_Name, '') AS kan2, q.Ques_Description AS ques,
      q.Clarifications AS cla, r.Rating1 AS rat1, IFNULL(r.Rating2, '') AS rat2, IFNULL(r.Rating3, '') AS rat3,
       IFNULL(r.Rating4, '') AS rat4, IFNULL(r.Rating5, '') AS rat5
     FROM question q JOIN knowledgearea ka1 ON q.KA_ID1 = ka1.KA_ID
     LEFT OUTER JOIN knowledgearea ka2 ON q.KA_ID2 = ka2.KA_ID
     JOIN rating r ON q.Rating_ID = r.Rating_ID
     WHERE q.Section_ID = 5
     ORDER BY q.Ques_ID;";
     if($result = $pdo->query($sql)){
         if($result->rowCount() > 0){
           echo '<table class ="responstable">';
           echo '<col style="width:10%">';
           echo '<col style="width:20%">';
           echo '<col style="width:50%">';
           echo '<col style="width:20%">';
           echo "<tr>";
               echo "<th>Knowledge Area</th>";
               echo "<th>Question</th>";
               echo "<th>Clarifications</th>";
               echo "<th>Rating</th>";
           echo "</tr>";
           while($row = $result->fetch()){
               echo "<tr>";
                   echo "<td>" . htmlentities($row['kan1']) . "\n";
                   if (strlen($row['kan2']) >= 1)
                   echo nl2br (", " . htmlentities($row['kan2']));
                   echo "</td>";
                   echo nl2br ("<td>" . $count++ . ". " . htmlentities($row['ques']) . "</td>");
                   echo nl2br ("<td>" . htmlentities($row['cla']) . "</td>");
                   if (strlen($row['rat1']) >= 1)
                   echo nl2br ("<td>" . "1 = " .htmlentities($row['rat1']) . "\n");
                   if (strlen($row['rat2']) >= 1)
                   echo nl2br ("2 = " .htmlentities($row['rat2']) . "\n");
                   if (strlen($row['rat3']) >= 1)
                   echo nl2br ("3 = " .htmlentities($row['rat3']) . "\n");
                   if (strlen($row['rat4']) >= 1)
                   echo nl2br ("4 = " .htmlentities($row['rat4']) . "\n");
                   if (strlen($row['rat5']) >= 1)
                   echo nl2br ("5 = " .htmlentities($row['rat5']) . "\n");
                   echo "</td>";
               echo "</tr>";
           }
         }
       }
           echo "</table>";
      ?>

      <h3>3.6 Project Management Integration Risks (6 Questions)</h3>
      <?php
      require_once "pdo.php";

      $sql = "SELECT q.Ques_ID, ka1.KA_Name AS kan1, IFNULL(ka2.KA_Name, '') AS kan2, q.Ques_Description AS ques,
       q.Clarifications AS cla, r.Rating1 AS rat1, IFNULL(r.Rating2, '') AS rat2, IFNULL(r.Rating3, '') AS rat3,
        IFNULL(r.Rating4, '') AS rat4, IFNULL(r.Rating5, '') AS rat5
      FROM question q JOIN knowledgearea ka1 ON q.KA_ID1 = ka1.KA_ID
      LEFT OUTER JOIN knowledgearea ka2 ON q.KA_ID2 = ka2.KA_ID
      JOIN rating r ON q.Rating_ID = r.Rating_ID
      WHERE q.Section_ID = 6
      ORDER BY q.Ques_ID;";
      if($result = $pdo->query($sql)){
          if($result->rowCount() > 0){
            echo '<table class ="responstable">';
            echo '<col style="width:10%">';
            echo '<col style="width:20%">';
            echo '<col style="width:50%">';
            echo '<col style="width:20%">';
            echo "<tr>";
                echo "<th>Knowledge Area</th>";
                echo "<th>Question</th>";
                echo "<th>Clarifications</th>";
                echo "<th>Rating</th>";
            echo "</tr>";
            while($row = $result->fetch()){
                echo "<tr>";
                    echo "<td>" . htmlentities($row['kan1']) . "\n";
                    if (strlen($row['kan2']) >= 1)
                    echo nl2br (", " . htmlentities($row['kan2']));
                    echo "</td>";
                    echo nl2br ("<td>" . $count++ . ". " . htmlentities($row['ques']) . "</td>");
                    echo nl2br ("<td>" . htmlentities($row['cla']) . "</td>");
                    if (strlen($row['rat1']) >= 1)
                    echo nl2br ("<td>" . "1 = " .htmlentities($row['rat1']) . "\n");
                    if (strlen($row['rat2']) >= 1)
                    echo nl2br ("2 = " .htmlentities($row['rat2']) . "\n");
                    if (strlen($row['rat3']) >= 1)
                    echo nl2br ("3 = " .htmlentities($row['rat3']) . "\n");
                    if (strlen($row['rat4']) >= 1)
                    echo nl2br ("4 = " .htmlentities($row['rat4']) . "\n");
                    if (strlen($row['rat5']) >= 1)
                    echo nl2br ("5 = " .htmlentities($row['rat5']) . "\n");
                    echo "</td>";
                echo "</tr>";
            }
          }
        }
            echo "</table>";
       ?>

       <h3>3.7 Project Requirements Risks (15 Questions)</h3>
       <?php
       require_once "pdo.php";

       $sql = "SELECT q.Ques_ID, ka1.KA_Name AS kan1, IFNULL(ka2.KA_Name, '') AS kan2, q.Ques_Description AS ques,
        q.Clarifications AS cla, r.Rating1 AS rat1, IFNULL(r.Rating2, '') AS rat2, IFNULL(r.Rating3, '') AS rat3,
         IFNULL(r.Rating4, '') AS rat4, IFNULL(r.Rating5, '') AS rat5
       FROM question q JOIN knowledgearea ka1 ON q.KA_ID1 = ka1.KA_ID
       LEFT OUTER JOIN knowledgearea ka2 ON q.KA_ID2 = ka2.KA_ID
       JOIN rating r ON q.Rating_ID = r.Rating_ID
       WHERE q.Section_ID = 7
       ORDER BY q.Ques_ID;";
       if($result = $pdo->query($sql)){
           if($result->rowCount() > 0){
             echo '<table class ="responstable">';
             echo '<col style="width:10%">';
             echo '<col style="width:20%">';
             echo '<col style="width:50%">';
             echo '<col style="width:20%">';
             echo "<tr>";
                 echo "<th>Knowledge Area</th>";
                 echo "<th>Question</th>";
                 echo "<th>Clarifications</th>";
                 echo "<th>Rating</th>";
             echo "</tr>";
             while($row = $result->fetch()){
                 echo "<tr>";
                     echo "<td>" . htmlentities($row['kan1']) . "\n";
                     if (strlen($row['kan2']) >= 1)
                     echo nl2br (", " . htmlentities($row['kan2']));
                     echo "</td>";
                     echo nl2br ("<td>" . $count++ . ". " . htmlentities($row['ques']) . "</td>");
                     echo nl2br ("<td>" . htmlentities($row['cla']) . "</td>");
                     if (strlen($row['rat1']) >= 1)
                     echo nl2br ("<td>" . "1 = " .htmlentities($row['rat1']) . "\n");
                     if (strlen($row['rat2']) >= 1)
                     echo nl2br ("2 = " .htmlentities($row['rat2']) . "\n");
                     if (strlen($row['rat3']) >= 1)
                     echo nl2br ("3 = " .htmlentities($row['rat3']) . "\n");
                     if (strlen($row['rat4']) >= 1)
                     echo nl2br ("4 = " .htmlentities($row['rat4']) . "\n");
                     if (strlen($row['rat5']) >= 1)
                     echo nl2br ("5 = " .htmlentities($row['rat5']) . "\n");
                     echo "</td>";
                 echo "</tr>";
             }
           }
         }
             echo "</table>";
        ?>
        <a href= "manager.php"><input type="button" class="right" value="Back" style="background:white;color:black;"/></a>
      </div>

</body>
