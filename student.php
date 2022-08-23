<?php
include('session.php');
$error = "";
$success = "";
if ($row['desgn' === 0]) {
   header("location: reviewer.php");
}
$qquery = "SELECT * from users inner join assignment on assignment.studentId = users.id where name = '$name'";
$rresult = mysqli_query($db, $qquery);
$rresult2 = mysqli_query($db, $qquery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $response = mysqli_real_escape_string($db, htmlspecialchars($_POST['action']));
   $student_query = "SELECT * from users inner join assignment on assignment.studentId = users.id where name = '$name' and assignName='$response'";
   $student_result = mysqli_query($db, $student_query);
   $student_data = mysqli_fetch_array($student_result, MYSQLI_ASSOC);
   if (strcmp($response, "null") != 0) {
      $error = "";
      if (strcmp($student_data['status'], 'Submitted for review') != 0) {
         $sqll = "UPDATE users SET asstobeReviewed = asstobeReviewed + 1 where name = '$name'";
      }
      $sql = "UPDATE assignment SET status = 'Submitted for review' where assignName = '$response' and studentId = '$id'";
      $result = mysqli_query($db, $sql);
      $another_result = mysqli_query($db, $sqll);
      $success = "Assignment Submitted for review successfully";
      header('location: student.php');
   } else {
      $error = "Please Select the Assignment";
   }
}

?>
<html">

   <head>
      <title>Welcome </title>
      <link rel="stylesheet" href="table.css">
   </head>

   <body>
      <div class="header">
         <div class="heading">
            <h3>Welcome <?php echo $name; ?></h3>
         </div>
         <div class="button">
            <button onclick="location.href = 'logout.php';">Sign Out</button>
            <button onclick="location.href = 'profile.php';"> See Profile</button>
         </div>
      </div>
      <div class="content">
         <h2> Your Assignment Status </h2>
         <table>
            <tr>
               <th> <strong> Assignment Name </strong></th>
               <th> <strong> Assignment Status </strong> </th>
               <th> <strong> Remark </strong> </th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($rresult)) {
               echo "<tr>";
               echo "<th> {$row['assignName']} </th>";
               echo "<td> {$row['status']} </td>";
               echo "<td> {$row['remark']} </td>";
               echo "</tr>";
            }
            ?>

         </table>
      </div>


      <div class="form">
         <form action="" method="POST">
            <p>Which assignment you want to submit for review?</p>
            <select name="action" id="">
               <option value="null">Select Assignment</option>
               <?php
               while ($row = mysqli_fetch_assoc($rresult2)) {
                  echo "<option value='{$row['assignName']}'>{$row['assignName']}</option>";
               }
               ?>
            </select>
            <input type="submit" value="Submit for Review" id="">

         </form>
         <p style="color: red"><?php echo $error ?></p>
         <p style="color: blue"><?php echo $success ?> </p>

      </div>


   </body>

   </html>