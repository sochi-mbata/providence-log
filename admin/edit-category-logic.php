<?php
include 'config/database.php';




if (isset($_POST['submit'])) { 
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$title || !$description) {
        $_SESSION['edit-category'] = "Fields cannot be empty";
    }
    else {
        $update_query = "UPDATE categories SET title = '$title', description = '$description' WHERE id = $id LIMIT 1";
        $result = mysqli_query($con, $update_query);
 
        if (mysqli_query($con, $update_query)) {
         $_SESSION['update-category-success'] = "Category updated successfully";

        //  redirect to manage users page
         header('location: '. ROOT_URL . 'admin/manage-categories.php');
         }
    }

    if (isset($_SESSION['edit-category'])){
        header('location: ' . ROOT_URL . 'admin/edit-category.php?id=' . $id);
    }
}
else {
    header('location: ' . ROOT_URL . 'admin/edit-category.php');
}