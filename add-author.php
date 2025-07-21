<?php

session_start();

if (isset($_SESSION['user_id'])&& 
	isset($_SESSION['user_email'])){
	# code...
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Author</title>
<!--BootStrap link for css-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!--BootStrap link for JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
	<!--Navbar for the site with div container to customise using css and javascript-->
<div class="container">
		
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="admin.php">Admin</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link active" aria-content = "page" href="index.php ">Store</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="add-book.php">Books</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="add-category.php">Category</a>
      </li>
            <li class="nav-item">
        <a class="nav-link" href="add-author.php">Author</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>

    </ul> 
  </div>
</div>
</nav>
<form action="php/add-author.php" method="post" class="shadow p-4 rounded mt-5" style="width: 90%; max-width: 50rem;">
    <h1 class="text-center pb-5 display-4 fs-3">Add New Author</h1>
    <!--error message for user identification -->
<?php if (isset($_GET['error'])) { ?>
  <div class="alert alert-danger" role = "alert">
    <?=htmlspecialchars($_GET['error']);?>
  </div>
<?php }?>
    <!--success message for user identification -->
<?php if (isset($_GET['success'])) { ?>
  <div class="alert alert-success" role = "alert">
    <?=htmlspecialchars($_GET['success']);?>
  </div>
<?php }?>
    <div class="mb-3">
        <label class="form-label">Author Name</label>
        <!-- Updated the name attribute to "author_name" -->
        <input type="text" class="author_name" name="author_name">
    </div>
    <button type="submit" class="btn btn-primary">Add Author</button>
</form>
</div>	
</body>
</html>

<?php }else{
	header("Location: login.php");
	exit;
}?>