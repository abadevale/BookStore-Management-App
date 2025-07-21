<?php

session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    // code...
    #handling the no book id set problem 
    if(!isset($_GET['id'])){
        #redirecting to admin page
        header("Location: admin.php");
        exit;
    }

    $id = $_GET['id'];

    // db connection file
    include "db_conn.php";

    // book helper function
    include "php/func-book.php";
    $book = get_book($conn,$id);

    # error handling if the ID is invalid
    if ($book == 0) {
        // code...
        header("Location: admin.php");
        exit;

    }

    // categories helper function
    include "php/func-category.php";
    $categories = get_all_categories($conn);

    // author helper function
    include "php/func-author.php";
    $authors = get_all_author($conn);




/*
    // title input form for books into the project
    if (isset($_GET['title'])) {
        $title = $_GET['title'];
    } else {
        $title = '';
    }

    // description input form for books into the project
    if (isset($_GET['desc'])) {
        $desc = $_GET['desc'];
    } else {
        $desc = '';
    }

    // category input form for the books into the project
    if (isset($_GET['category_id'])) {
        $category_id = $_GET['category_id'];
    } else {
        $category_id = 0;
    }

    // author input form for the books into the project
    if (isset($_GET['author_id'])) {
        $author_id = $_GET['author_id'];
    } else {
        $author_id = 0;
    }
    */
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
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
                    <a class="nav-link active" aria-content="page" href="index.php">Store</a>
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
    </nav>
    <form action="php/edit-book.php" method="post" class="shadow p-4 rounded mt-5" enctype="multipart/form-data" style="width: 90%; max-width: 50rem;">
    <h1 class="text-center pb-5 display-4 fs-3">Edit Book</h1>
    <!--error message for user identification -->
    <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($_GET['error']); ?>
        </div>
    <?php } ?>
    <!--success message for user identification -->
    <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($_GET['success']); ?>
        </div>
    <?php } ?>
    <div class="mb-3">
        <label class="form-label">Book Title</label>
        <input type="text" hidden
               value="<?= $book['id'] ?>" name="book_id">

        <input type="text" class="form-control"
               value="<?= $book['title'] ?>" name="book_title">       
    </div>

    <div class="mb-3">
        <label class="form-label">Book Description</label>
        <input type="text" class="form-control"
               value="<?= $book['description'] ?>" name="book_description">
    </div>

    <div class="mb-3">
        <label class="form-label">Book Author</label>
        <select name="book_author" class="form-control">
            <option value="0"> Select author </option>
            <?php
            if (!empty($authors)) {
                foreach ($authors as $author) {
                    if ($book['author_id'] == $author['id']) {
                        ?>
                        <option selected value="<?= $author['id'] ?>">
                            <?= $author['name'] ?>
                        </option>
                    <?php } else { ?>
                        <option value="<?= $author['id'] ?>">
                            <?= $author['name'] ?>
                        </option>
                    <?php }
                }
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Book Category</label>
        <select name="book_category" class="form-control">
            <option value="0"> Select category </option>
            <?php
            if (!empty($categories)) {
                foreach ($categories as $category) {
                    if ($book['category_id'] == $category['id']) {
                        ?>
                        <option selected value="<?= $category['id'] ?>">
                            <?= $category['name'] ?>
                        </option>
                    <?php } else { ?>
                        <option value="<?= $category['id'] ?>">
                            <?= $category['name'] ?>
                        </option>
                    <?php }
                }
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Book Cover</label>
        <input type="file" class="form-control" name="book_cover">

        <input type="text" hidden
               value="<?= $book['cover'] ?>" name="current_cover">

        <a href="uploads/cover/<?=$book['cover']?>" 
        >Current Cover</a>
    </div>

    <div class="mb-3">
        <label class="form-label">File</label>
        <input type="file" class="form-control" name="file">

        <input type="text" hidden
               value="<?= $book['file'] ?>" name="current_file">

        <a href="uploads/files/<?=$book['file']?>" 
        >Current File</a>
    </div>
    <button type="submit" class="btn btn-primary">Refresh</button>
</form>

</div>	
</body>
</html>

<?php }else{
	header("Location: login.php");
	exit;
}?>
