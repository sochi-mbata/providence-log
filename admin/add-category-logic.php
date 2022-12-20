<?php
include 'config/database.php';

if (isset($_POST['submit'])) {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$title || !$description) {
        $_SESSION['add-category'] = "Please fill out all fields";
    }
    if (isset($_SESSION['add-category'])) {
        $_SESSION['add-category-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-category.php');
    }
    else {
        //insert into the database
        $query = "INSERT INTO categories (title, description)
        VALUE ('$title', '$description')";

        if (mysqli_query($con, $query)) {
            $_SESSION['add-category-success'] = "New category added successfully";
            //redirect to manage category page
            header('location: '. ROOT_URL .'admin/manage-categories.php');
        }
    }

}
else {
    header('location: '. ROOT_URL .'admin/add-category.php');
}