<?php

#function to start a new session or resuming an existning session
session_start();

#user_id and user_email are in session

if (isset($_SESSION['user_id'])&& 
	isset($_SESSION['user_email'])){
	# code...

#db connection file responsible for database connection
include "db_conn.php";

#Book helper function
include "php/func-book.php";

#retrieve all books using the get_all_books function and store the result in $book
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
<title>ADMIN</title>
<!--BootStrap link for css-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!--BootStrap link for JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
	<!--Navbar for the site with div container to customise using css and javascript-->
<div class="container">
		
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="admin.php">Vendor Palace</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link active" aria-content = "page" href="index.php">Store</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="add-book.php">Add Books</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="add-category.php">Add Category</a>
      </li>
            <li class="nav-item">
        <a class="nav-link" href="add-author.php">Add Author</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>

    </ul> 
  </div>
</div>
</nav>
<!--
<form action="search.php" method = "get">

    <div class="input-group mb-3">
  <input type="text" class="form-control" name="key" placeholder="Search for book...." aria-label="Search for book...." aria-describedby="basic-addon2">
  <div class="input-group-append">
    <button class="input-group-text btn btn-primary" id="basic-addon2">

  </div>
</div>

</form>
-->
<?php if ($books == 0) {?>
	empty
<?php } else {  ?>
<!-- List of all books -->
<h4 class="mt-5">All Books</h4>
<!-- Making the admin table for CRUD operations -->
<table class="table table-bordered shadow">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Author</th>
            <th>Description</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    	<?php
        #loop structure to allow actions on each book in the array 
    	$i = 0;
    	foreach ($books as $book) {
    		$i++;
    		?>
        <tr>
        	<tr></tr>
            <td>1</td>
            <!--Section to book img db stored-->
            <td>
            	<img width="100"src="uploads/cover/<?=$book['cover'] ?>">
            	<a class="link-dark d-block text-center"href="uploads/files/<?=$book['file'] ?>">
            		<?=$book['title'] ?>
            	</a>
            </td>
        <td>
        	<!--Section to display db stored author-->
					<?php if ($authors == 0) {
						echo "Undefined";}else{ 

					    foreach ($authors as $author) {
					    	if ($author['id'] == $book['author_id']) {
					    		echo $author['name'];
					    	}
					    }
					}
					?>
            </td>
            <td><?=$book['description']?></td>
            <td>
            	        	<!--Section to display db stored categories -->
          <?php
                    if ($categories == 0) {
                        echo "Undefined";
                    } else {
                        $categoryFound = false;
                        foreach ($categories as $category) {
                            if ($category['id'] == $book['category_id']) {
                                echo $category['name'];
                                $categoryFound = true;
                                break;
                            }
                        }
                        if (!$categoryFound) {
                            echo "Category Not Found";
                        }
                    }
                    ?>
            </td>
            <td>
                <a href="edit-book.php?id=<?=$book['id']?>" class="btn btn-warning">Edit</a>
                <a href="php/delete-book.php?id=<?=$book['id']?>" class="btn btn-danger">Delete</a>
            </td>
        </tr>
    </tr >
<?php } ?>
    </tbody>
</table>

<?php } ?>
<?php if ($categories == 0) {?>
	empty
<?php } else {  ?>
<!-- List of all categories -->
<h4 class="mt-5">All Categories</h4>
<table class="table table-bordered shadow">
	<thead>
		<tr>
			<th>#</th>
			<th>Categories</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$j = 0;
		foreach ($categories as $category) {
			$j++;
		?>
		<tr>
			<td>1</td>
			<td><?php echo $category['name'] ?></td>
			<td>
			<a href="edit-category.php?id=<?=$category['id']?>" class="btn btn-warning">Edit</a>
            <a href="php/delete-category.php?id=<?=$category['id']?>" class="btn btn-danger">Delete</a>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>

<?php } ?>

<?php if ($authors == 0) {?>
	empty
<?php } else {  ?>
<!-- List of all Authors -->
<h4 class="mt-5">All Authors</h4>
<table class="table table-bordered shadow">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
            <?php 
            $k = 0;
            foreach ($authors as $author) {
                $k++;	
            ?>
                <tr>
                    <td><?=$k?></td>
                    <td><?=$author['name']?></td>
                    <td>
                        <a href="edit-author.php?id=<?=$author['id']?>" class="btn btn-warning">Edit</a>
                        <a href="php/delete-author.php?id=<?=$author['id']?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php } ?>

</div>	
</body>
</html>

<?php }else{
	header("Location: login.php");
	exit;
}?>