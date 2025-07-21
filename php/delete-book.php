<?php  
session_start();

# Check if admin is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    # Database Connection File
    include "../db_conn.php";

    # Check if book id is submitted
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        # Simple form validation
        if (empty($id)) {
            $em = "There was an error";
            header("Location: ../admin.php?error=$em&id=$id");
            exit;
        } else {
            # Get the book from the database
            $sql = "SELECT * FROM books WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            $the_book = $stmt->fetch();

            if ($stmt->rowCount() > 0) {
                # Delete the book from the Database
                $sql = "DELETE FROM books WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res = $stmt->execute([$id]);

                # If there is no error while deleting the data
                if ($res) {
                    // Deleting the current book cover and file
                    $cover = $the_book['cover'];
                    $file = $the_book['file'];
                    $c_b_p = "../uploads/cover/$cover";
                    $c_f = "../uploads/files/$file";

                    unlink($c_b_p);
                    unlink($c_f);

                    # Success message
                    $sm = "Successfully deleted!";
                    header("Location: ../admin.php?success=$sm&id=$id");
                    exit;
                } else {
                    # Error message
                    $em = "Unknown Error Occurred!";
                    header("Location: ../admin.php?error=$em&id=$id");
                    exit;
                }
            } else {
                $em = "There was an error";
                header("Location: ../admin.php?error=$em&id=$id");
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
