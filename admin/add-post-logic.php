<?php
include 'config/database.php';

if (isset($_POST['add_post'])) {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $thumbnail = $_FILES['thumbnail'];
    if (filter_has_var(INPUT_POST, 'is_featured')) {
        $is_featured = 1;
    }
    else{
        $is_featured = 0;
    }

    
    //query categories table to get title
    $query = "SELECT title FROM categories WHERE id = $category_id";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0 ) {
        foreach($result as $row) {
            $category = $row['title'];
        }
    }

    //fetch author, i.e current user from session user
    $author_id = $_SESSION['user']['id'];


    //validate
    if (!$title) {
        $_SESSION['add-post'] = "Title required";
    }
    elseif (!$body) {
        $_SESSION['add-post'] = "Post body cannot be empty";
    }
    elseif (!$thumbnail) {
        $_SESSION['add-post'] = "Select a thumbnail ";
    }
    else {
        //work on the thumbnail
        // rename thumbnail
        $time = time(); //name the images using current timestamp
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        //validate file type and size
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);

        if (in_array($extension, $allowed_files)) {
            // max image size = 2mb
            if ($thumbnail['size'] < 2000000) {
                //upload thumbnail
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            }
            else {
                $_SESSION['add-post'] = "File size too big. Should be less than 2mb";
            }
        }
        else {
            $_SESSION['add-post'] = "File should be png, jpg or jpeg";
        }

        //if post is featured (1), set others to not featured (0)
        if ($is_featured == 1) {
        $query_is_featured = mysqli_query($con, "UPDATE posts SET is_featured = 0");
        }

        // insert into database
        $query_posts = mysqli_query($con, "INSERT INTO posts (author_id, category_id, title, category, body, is_featured, thumbnail) VALUES ($author_id, $category_id, '$title', '$category', '$body', $is_featured, '$thumbnail_name')");
        if ($query_posts){
            $_SESSION['add-post-success'] = "Post added successfully";
            header('location: ' . ROOT_URL . 'admin/index.php');
        }
        else {
            $_SESSION['add-post-success'] = "An error occured";

        }
    }
    if (isset($_SESSION['add-post'])) {
        //return field info if there's an error
        $_SESSION['add-post-data'] = $_POST;
        //redirect to add post page
        header('location: ' . ROOT_URL . 'admin/add-post.php');
    }
}
else{
    header('location: ' . ROOT_URL . 'admin/add-post.php');
}