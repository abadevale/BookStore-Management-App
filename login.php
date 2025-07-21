
<!--php page to sort on security and login credentials of admins in the system-->
<?php

#function to start a new session or resuming an existning session
session_start();

#user_id and user_email are in session

if (!isset($_SESSION['user_id'])&& 
  !isset($_SESSION['user_email'])){

    ?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<!--BootStrap link for css-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!--BootStrap link for JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>

<!--div class to handle forms for user identification-->
<!--d-flex is used to style the form-->

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <!--we use the post method on the forms-->
  <form class="p-5 rounded shadow" style="max-width: 30rem; width: 100%"
  method="POST"
  action="php/auth.php" 
  >
  <!--
  #php 
  #inserting the admin
  #encrypting the password using password_hash

  #echo password_hash("12345", PASSWORD_DEFAULT);
-->
<h1 class="text-center display-4 pb-5 ">VENDOR LOGIN</h1>

<!--error message for user identification -->
<?php if (isset($_GET['error'])) { ?>
  <div class="alert alert-danger" role = "alert">
    <?=htmlspecialchars($_GET['error']);?>
  </div>
<?php }?>

  <div class="mb-3">
    <label for="exampleInputEmail1"
    class="form-label">Email address</label>
    <input type="email"
    class="form-control"
    id="exampleInputEmail1"
    aria-describedby="emailHelp" 
    placeholder="Enter email"
    name="email">
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1"
    class="form-label">Password</label>
    <input type="password" 
    class="form-control" 
    id="exampleInputPassword1" 
    placeholder="Password"
    name="password">
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
  <br>
  <a href="index.php">Home Page</a>
  <br>
  <a href="admin-registration.php">Register Vendor<a>

</form>
</div>
</body>
</html>

<?php }else{
  header("Location: login.php");
  exit;
}?>
