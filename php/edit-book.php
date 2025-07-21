<?php  
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    include "../db_conn.php";
    include "func-validation.php";
    include "func-file-upload.php";

    if (
        isset($_POST['book_id']) &&
        isset($_POST['book_title']) && 
        isset($_POST['book_description']) &&
        isset($_POST['book_author']) &&
        isset($_POST['book_category']) && 
        isset($_FILES['book_cover']) && 
        isset($_FILES['file']) &&
        isset($_POST['current_cover']) &&
        isset($_POST['current_file'])
    ) {
        $id = $_POST['book_id'];
        $title = $_POST['book_title'];
        $description = $_POST['book_description'];
        $author = $_POST['book_author'];
        $category = $_POST['book_category'];
        $current_cover = $_POST['current_cover'];
        $current_file = $_POST['current_file'];

        // Simple form validation
        $text = "Book Title";
        $location = "../edit-book.php";
        $ms = "id=$id&error";
        is_empty($title, $text, $location, $ms, "");

        $text = "Book Description";
        is_empty($description, $text, $location, $ms,"");

        $text = "Book author";
        is_empty($author, $text, $location, $ms,"");

        $text = "Book category";
        is_empty($category, $text, $location, $ms,"");

        if (!empty($_FILES['book_cover']['name'])) {
            $allowed_image_exs = array("jpg", "jpeg", "png");
            $path = "cover";
            $book_cover = upload_file($_FILES['book_cover'],$allowed_image_exs, $path);

            if ($book_cover['status'] == "error") {
                $em = $book_cover['data'];
                header("Location: ../edit-book.php?error=$em&id=$id");
                exit;
            }

            $allowed_file_exs = array("pdf", "docx", "pptx");
            $path = "files";
            $file = upload_file($_FILES['file'], $allowed_file_exs, $path);

            if ($file['status'] == "error") {
                $em = $file['data'];
                header("Location: ../edit-book.php?error=$em&id=$id");
                exit;
            }

            $c_p_book_cover = "../uploads/cover/$current_cover";
            $c_p_file = "../uploads/files/$current_file";

            unlink($c_p_book_cover);
            unlink($c_p_file);

            $file_URL = $file['data'];
            $book_cover_URL = $book_cover['data'];

            $sql = "UPDATE books SET title=?, 
                                    author_id=?,
                                    description=?,
                                    category_id=?,
                                    cover=?,
                                    file=?
                    WHERE id=?";

            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$title, $author, $description, $category,$book_cover_URL, $file_URL, $id]);

            if ($res) {
                $sm = "Successfully changed!";
                header("Location: ../edit-book.php?success=$sm&id=$id");
                exit;
            } else {
                $em = "Unknown Error Occurred!";
                header("Location: ../edit-book.php?error=$em&id=$id");
                exit;
            }
        } elseif (!empty($_FILES['file']['name'])) {
            // Update the file
        } else {
            $sql = "UPDATE books SET title=?, 
                                    author_id=?,
                                    description=?,
                                    category_id=?
                    WHERE id=?";

            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$title, $author, $description, $category, $id]);

            if ($res) {
                $sm = "Successfully changed!";
                header("Location: ../edit-book.php?success=$sm&id=$id");
                exit;
            } else {
                $em = "Unknown Error Occurred!";
                header("Location: ../edit-book.php?error=$em&id=$id");
                exit;
            }
        }
    } else {
        header("Location: ../admin.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
