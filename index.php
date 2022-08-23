<?php
   include("config.php");
   
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($db,htmlspecialchars($_POST['username']));
      $mypassword = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));
      
      // $mydesgn = mysqli_real_escape_string($db,$_POST['desgn']);
      
      $sql = "SELECT desgn,password FROM users WHERE username = '$myusername'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $abc = mysqli_fetch_row($result);
      $active = $row['active'];
   
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1 && $row['desgn'] == 1 && password_verify($mypassword,$row['password'])) {
         $_SESSION['login_user'] = $myusername;
         
         header("location: student.php");
      }
      else if($count == 1 && $row['desgn'] == 0 && password_verify($mypassword,$row['password'])) {
        $_SESSION['login_user'] = $myusername;
        
        header("location: reviewer.php");
        
     }
      elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
      $error = "Username can only contain letters, numbers, and underscores.";
     }
      else {
         $error = "Your Login Name or Password is invalid. Please try again";
      }
   }
?>
<html>
   
   <head>
      <title>Login Page</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
               <form action = "" method = "post">
                  <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <!-- <select name="desgn" id="" >
                    <option value="1">Student</option>
                    <option value="0">Reviewer</option>
                  </select> -->
                  <input type = "submit" value = " Login " class="btn btn-primary"/><br />
               </form>
               <button onclick = "location.href = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ' ">Login without password</button>
 
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>