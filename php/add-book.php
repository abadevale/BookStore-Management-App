<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    # Database Connection File
    include "../db_conn.php";

    # Validation helper function 
    include "func-validation.php";

    # Including File Upload Helper function
    include "func-file-upload.php";	

    # If all input fields are filled
    if (isset($_POST['book_title']) && 
        isset($_POST['book_description']) &&
        isset($_POST['book_author']) &&
        isset($_POST['book_category']) && 
        isset($_FILES['book_cover']) && 
        isset($_FILES['file'])) {

        # Get data from POST request and store them in variables
        $title = $_POST['book_title'];
        $description = $_POST['book_description'];
        $author = $_POST['book_author'];
        $category = $_POST['book_category'];

        # Making URL data format
        $user_input = 'title='.$title.'&category_id='.$category.'&description'.$description.'&author_id='.$author;

        # Simple form validation
        $text = "Book Title";
        $location = "../add-book.php";
        $ms = "error";
        is_empty($title, $text, $location, $ms, $user_input);

        $text = "Book Description";
        $location = "../add-book.php";
        $ms = "error";
        is_empty($description, $text, $location, $ms, $user_input);

        $text = "Book author";
        $location = "../add-book.php";
        $ms = "error";
        is_empty($author, $text, $location, $ms, $user_input);

        $text = "Book category";
        $location = "../add-book.php";
        $ms = "error";
        is_empty($category, $text, $location, $ms, $user_input);

        # Book cover uploading
        $allowed_image_exs = array("jpg", "jpeg", "png");
        $path = "cover";
        $book_cover = upload_file($_FILES['book_cover'], $allowed_image_exs, $path);

        # If an error occurred on file uploading 
        if ($book_cover['status'] == "error") {
            $em = $book_cover['data'];

            # Redirecting to add-book directory with error message
            header("Location: ../add-book.php?error=$em$user_input");
            exit;
        } else {
            # File uploading
            $allowed_file_exs = array("pdf", "docx", "pptx");
            $path = "files";
            $file = upload_file($_FILES['file'], $allowed_file_exs, $path);

            # Error when uploading the file
            if ($file['status'] == "error") {
                $em = $file['data'];

                # Redirecting to add-book directory with error message
                header("Location: ../add-book.php?error=$em$user_input");
                exit;
            } else {
                # Getting the new file name and book cover name
                $file_URL = $file['data'];
                $book_cover_URL = $book_cover['data'];

                # Code to insert the data into the database
                $sql = "INSERT INTO books (title, author_id, description, category_id, cover, file)
                        VALUES (?,?,?,?,?,?)";

                # Insert Into Database
                $stmt = $conn->prepare($sql);
                $res = $stmt->execute([$title, $author, $description, $category, $book_cover_URL, $file_URL]);

                # If there is no error while inserting the data
                if ($res) {
                    # Success message
                    $sm = "The Book is Successfully created!";
                    header("Location: ../add-book.php?success=$sm");
                    exit;
                } else {
                    # Error message
                    $em = "Unknown Error Occurred!";
                    header("Location: ../add-book.php?error=$em$user_input");
                    exit;
                }
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