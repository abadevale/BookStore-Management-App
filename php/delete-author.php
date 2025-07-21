<?php  
session_start();

# Check if admin is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    # Database Connection File
    include "../db_conn.php";

    # Check if author id is submitted
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        # Simple form validation
        if (empty($id)) {
            $em = "There was an error";
            header("Location: ../admin.php?error=$em&id=$id");
            exit;
        } else {
                # Delete the category from the Database
                $sql = "DELETE FROM authors WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res = $stmt->execute([$id]);

                # If there is no error while deleting the data
                if ($res) {

                    # Success message
                    $sm = "Successfully deleted!";
                    header("Location: ../admin.php?success=$sm&id=$id");
                    exit;
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
