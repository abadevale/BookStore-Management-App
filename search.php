<?php

session_start();

# checking if the key parameter is set or is empty
if (!isset($_GET['key']) || empty($_GET['key'])) {
   // code...
  header("Location:index.php");
  exit;
}


$key = $_GET['key'];

#db connection file responsible for database connection
include "db_conn.php";


#retrieve all books using the get_all_books function and store the result in $book
include "php/func-book.php";
$books = search_book($conn, $key);

#including the author helper functions
include "php/func-author.php";
$authors = get_all_author($conn);

#including the categories helper function
include "php/func-category.php";

#retrieveing all categories using the get_all_categories function and store the result in $categories
$categories = get_all_categories($conn);


?>

<!DOCTYPE html>
<html>
<head>
<title>Online BookStore</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<!-- Bootstrap javascript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-..." crossorigin="anonymous"></script>

<link rel="stylesheet" href="css/style.css">



</head>
<body>

<!-- Navbar for the site with div container to customise using css and javascript -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="index.php">Online Book Store</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Store</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About Us</a>
        </li>
        <li class="nav-item">

          <?php if(isset($_SESSION['user_id'])){ ?>
             <a class="nav-link" href="admin.php">Admin</a>
          <?php }else{?>
          <a class="nav-link" href="login.php">Login</a>

        <?php }?>
        </li>
      </ul> 
    </div>
  </div>
</nav><br>
Search resulr for<b> <?=$key?> </b>
<div class="d-flex">
  <?php if ($books == 0) {?>
  <br> 
  The key <b>"<?=$key?>"</b> didn't match to any record in the database
  <?php }else{?>
  <div class="pdf-list d d-flex flex-wrap">
    <?php foreach ($books as $books) { ?>
      <div class="card m-1">
        <img src="uploads/cover/<?=$books['cover']?>"
        class = "card-img-top">
  <div class="card-body">
    <h5 class = "card-title">
      <?=$books['title'] ?>
    </h5>
    <p class="card-text">
      <i><b> By:
      <?php foreach($authors as $author){
        if($author['id'] == $books['author_id'])
        {
          echo $author['name'];
          break;
        }
       ?>

      <?php } ?>       
      <br></b></i>
      <?=$books['description']?>
      <br><i><b> Category:
      <?php foreach($categories as $category){
        if($category['id'] == $books['category_id'])
        {
          echo $category['name'];
          break;
        }
       
       }?>

    </p>
    <a href="uploads/files/<?=$book['file']?>" class="btn btn-success">Open</a>
    <a href="uploads/files/<?=$book['file']?>" class="btn btn-priiamry"download="<?=$book['title']?>">Download</a>
  </div>
      </div>

    <div class="card m-1">
      <?php } ?>
    </div>
  <?php } ?>
  </div>
</div>
</body>
</html>
