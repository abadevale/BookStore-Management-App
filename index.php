<?php

session_start();
#db connection file responsible for database connection
include "db_conn.php";


#retrieve all books using the get_all_books function and store the result in $book
include "php/func-book.php";
$books = get_all_books($conn);

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
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About Us</a>
        </li>
        <li class="nav-item">

          <?php if(isset($_SESSION['user_id'])){ ?>
             <a class="nav-link" href="admin.php">Vendor</a>
          <?php }else{?>
          <a class="nav-link" href="login.php">Vendor</a>
        <?php }?>
        </li>
      </ul> 
    </div>
  </div>
</nav>
<form action="search.php" method = "get">

    <div class="input-group mb-3">
  <input type="text" class="form-control" name="key" placeholder="Search for book...." aria-label="Search for book...." aria-describedby="basic-addon2">
  <div class="input-group-append">
    <button class="input-group-text btn btn-primary" id="basic-addon2">

  </div>
</div>

</form>

<div class="d-flex pt-3">
  <?php if ($books == 0) {?>
  <br>
  <div class="alert alert-warning text-center p-5"
  role = "alert">
    
  </div> 
  There is no book in the database
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
      <br><i><b> From:
      <?php foreach($categories as $category){
        if($category['id'] == $books['category_id'])
        {
          echo $category['name'];
          break;
        }
       
       }?>

    </p>
    <a href="uploads/files/<?=$book['file']?>" class="btn btn-success">Open</a>
    <a href="uploads/files/<?=$book['file']?>" class="btn btn-primary"download="<?=$book['title']?>">Download</a>
  </div>
      </div>

    <div class="card m-1">
      <?php } ?>
    </div>
  <?php } ?>
      <!-- List of categories -->
      <div class="list-group">
        <?php if ($categories == 0){
          // do nothing
        }else{ ?>
        <a href="#"
           class="list-group-item list-group-item-action active">Category</a>
           <?php foreach ($categories as $category ) {?>
          
           <a href="category.php?id=<?=$category['id']?>"
              class="list-group-item list-group-item-action active">
              <?=$category['name']?></a>
        <?php } } ?>
    

        <!-- list of authors -->
    <div class="list-group mt-5">
      <?php if($authors == 0){ 
        //nada zilch 
       }else{ ?>
        <a href="#" class="list-group-item list-group-item-action active">Authors</a>
        <?php foreach ($authors as $author) { ?>
            <a href="author.php?id=<?=$author['id']?>" class="list-group-item list-group-item-action active"><?= $author['name'] ?></a>
        <?php } } ?>
    </div>
</div>



  </div>
  </div>
</div>
<!-- Footer section -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h5>About Us</h5>
          <p>This is a brief description of our bookstore and what we offer to our customers.</p>
        </div>
        <div class="col-md-4">
          <h5>Help</h5>
          <ul>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Support</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h5>Frequently Asked Questions</h5>
          <ul>
            <li><a href="#">Shipping & Delivery</a></li>
            <li><a href="#">Returns & Refunds</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>


</body>
</html>
