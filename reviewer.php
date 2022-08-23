<?php
include('session.php');
$error = "";
$success = "";
if ($row['desgn' === 1]) {
   header("location: student.php");
}
$query_one = "SELECT name,yearDept,pendingAssignments,asstobeReviewed from users where desgn = 1";
$result_one = mysqli_query($db, $query_one);
$qquery = "SELECT distinct assignName from users inner join assignment on assignment.studentId = users.id where desgn = 1";
$rresult = mysqli_query($db, $qquery);
$result_one2 = mysqli_query($db, $query_one);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $action = mysqli_real_escape_string($db, htmlspecialchars($_POST['action']));
   $student = mysqli_real_escape_string($db, htmlspecialchars($_POST['student']));
   $assignment = mysqli_real_escape_string($db, htmlspecialchars($_POST['assign']));
   $remark = mysqli_real_escape_string($db, htmlspecialchars($_POST['review']));
   $query_student = "SELECT * FROM users inner join assignment on assignment.studentId = users.id where name = '$student' and assignName = '$assignment'";
   $result_student = mysqli_query($db, $query_student);
   $studentData = mysqli_fetch_array($result_student, MYSQLI_ASSOC);

   if (strcmp($action, "review") === 0 && strcmp($studentData['status'], "Submitted for review") === 0) {
      $query_two = "UPDATE users set asstobeReviewed = asstobeReviewed - 1 where name = '$student' AND asstobeReviewed > 0 ";
      $query_three = "UPDATE users inner join assignment on assignment.studentId = users.id set remark = '$remark' where name = '$student' and assignName = '$assignment'";
      $query_four = "UPDATE users inner join assignment on assignment.studentId = users.id set status = 'Sent back with an Iteration from the reviewer' where name = '$student' and assignName = '$assignment'";
      $query_five = "UPDATE users set reviewedAssignment = reviewedAssignment + 1 where name = '$name'";
      $result_two = mysqli_query($db, $query_two);
      $result_three = mysqli_query($db, $query_three);
      $result_four = mysqli_query($db, $query_four);
      $result_five = mysqli_query($db, $query_five);
   } else if (strcmp($action, "check") === 0 && strcmp($studentData['status'], "Submitted for review") === 0) {
      $query_six = "UPDATE users set pendingAssignments = pendingAssignments - 1 where name = '$student' AND pendingAssignments >0";
      $query_seven = "UPDATE users inner join assignment on assignment.studentId = users.id set status = 'Submitted' where name = '$student' and assignName = $assignment";
      $result_six = mysqli_query($db, $query_six);
      $result_seven = mysqli_query($db, $query_seven);
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
         <h2> Welcome to IMG Assignment Management System </h2>

      </div>

      <script>
         doSomething = () => {
            let abc = document.getElementById("abc");
            let text = document.getElementById('text');
            let assign = document.getElementById('assign');
            let student = document.getElementById('student');
            let tableall = document.getElementById('tableall');
            if (abc.value === 'review') {
               text.style.visibility = 'visible';
               text.value = null;
            } else {
               text.style.visibility = 'hidden';
               text.value = null;
            }
            if (abc.value === 'review' || abc.value === 'check') {
               student.style.visibility = 'visible';
            } else {
               student.style.visibility = 'hidden';
            }
            if (abc.value === 'review' || abc.value === 'check') {
               assign.style.visibility = 'visible'
            } else {
               assign.style.visibility = 'hidden'
            }
            if (abc.value !== 'all') {
               tableall.style.visibility = "hidden";
            } else {
               tableall.style.visibility - "visible";
            }

         }
      </script>

      <div class="form">

         <form action="" method="POST">
            <p>What do you want to do?</p>
            <select name="action" id="abc" onchange=doSomething()>
               <option value="null">Select</option>
               <option value="all">Show Assignment Status of All Students</option>
               <option value="review">Review Assignment </option>
               <option value="check">Check Assignment</option>
            </select>

            <select name="student" id="student" style="visibility: hidden;">
               <option value="null">Select Student</option>
               <?php
               while ($row = mysqli_fetch_assoc($result_one)) {
                  echo "<option value='{$row['name']}'>{$row['name']}</option>";
               }
               ?>
            </select>

            <select name="assign" id="assign" style="visibility: hidden;">
               <option value="null">Select Assignment</option>
               <?php
               while ($row = mysqli_fetch_assoc($rresult)) {
                  echo "<option value='{$row['assignName']}'>{$row['assignName']}</option>";
               }
               ?>
            </select>
            <textarea name="review" id="text" cols="30" rows="10" placeholder="Enter your Remark" style="visibility: hidden;"></textarea>
            <input type="submit" value="Submit" id="">

         </form>
         <p style="color: red"><?php echo $error ?></p>
         <p style="color: blue"><?php echo $success ?> </p>

      </div>
      <?php
      if (strcmp($action, "all") === 0) {
         echo "<div class = 'abc'>";
         echo "<table id='alltable'>
               <tr>
                  <th>Name</th>
                  <th>Year and Dept</th>
                  <th>Pending Assignments</th>
                  <th>Assignment to be Reviewed</th>
               </tr>";

         while ($row = mysqli_fetch_assoc($result_one2)) {
            echo " 
                  <tr>
                  <td> {$row['name']}  </td>
                  <td> {$row['yearDept']}  </td>
                  <td> {$row['pendingAssignments']}  </td>
                  <td> {$row['asstobeReviewed']}  </td>
                  </tr>
               ";
         }

         echo "</tr>";
         echo "</table>";
         echo "</div>";
      }





      ?>


   </body>

   </html>