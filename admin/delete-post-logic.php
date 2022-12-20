<?php
include 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //fetch data from database
    $query = "SELECT * FROM posts WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($con, $query);
    $posts = mysqli_fetch_assoc($result);

    //make sure we're fetching only one user
    if (mysqli_num_rows($result) == 1) {
        $thumbnail_name = $posts['thumbnail'];
        $thumbnail_path = '../images/' . $thumbnail_name;

        //delete the image if it exists
        if ($thumbnail_path) {
            unlink($thumbnail_path);
        }

        $query = "DELETE FROM posts WHERE id = '$id'";
        $result = mysqli_query($con, $query);

        if ($result) {
            $_SESSION['delete-success'] = "Post deleted";
            header('location: ' . ROOT_URL . 'admin/index.php');
        }
        else {
            $_SESSION['delete'] = "Error! Delete failed";
            header('location: ' . ROOT_URL . 'admin/index.php');
        }
    }
    else {
        $_SESSION['delete'] = "Error! Delete failed";
        header('location: ' . ROOT_URL . 'admin/index.php');
    }
}
else {
    //redirect to manage users page
    header('location: ' . ROOT_URL . 'admin/index.php');
}