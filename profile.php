<?php 
include('session.php');


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href="profile.css">
    <title>Document</title>
</head>
<body>
  <table>
    <tr>
    <th>Name</th>
    <td><?php echo $row['name'] ?></td>
    </tr>

    <tr>
    <th>Year and Department</th>
    <td><?php echo $row['yearDept'] ?></td>
    </tr>

    
    <?php 
    if($row['desgn'] == 1){
        echo "<tr>";
        echo "<th> Pending Assignments </th>";
        echo "<td> {$row['pendingAssignments']} </td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th> Assignments Given for review </th>";
        echo "<td> {$row['asstobeReviewed']} </td>";
        echo "</tr>";
    }
    else {
        echo "<tr>";
        echo "<th> Reviewed Assignments </th>";
        echo "<td> {$row['reviewedAssignments']} </td>";
        echo "</tr>";
    }
    ?>
    

  </table>
  
  <?php  
  if($row['desgn']==1){
  echo "<button onclick=\"location.href='student.php'\">Go Back to Dashboard</button>";
}
  else{
    echo "<button onclick=\"location.href='reviewer.php'\">Go Back to Dashboard</button>";
  } 
  ?>
  
</body>
</html>