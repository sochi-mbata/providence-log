<?php
include 'config/database.php';

if (isset($_POST['submit'])) { 
    $user_id = $_SESSION['user']['id'];
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $prev_thumbnail = filter_var($_POST['prev_thumbnail'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $thumbnail = $_FILES['thumbnail'];
    if (filter_has_var(INPUT_POST, 'is_featured')) {
        $is_featured = 1;
    }
    else{
        $is_featured = 0;
    }


    if (!$title || !$body) {
        $_SESSION['edit-post'] = "Fields cannot be empty";
    }
    else {

        if ($thumbnail['name']) {
            $prev_thumbnail_path = '../images/' . $prev_thumbnail;
            if($prev_thumbnail_path){
                unlink($prev_thumbnail_path);
            }
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
                    $_SESSION['edit-post'] = "File size too big. Should be less than 2mb";
                }
            }
            else {
                $_SESSION['edit-post'] = "File should be png, jpg or jpeg";
            }
        }

        $query_category = mysqli_query($con, "SELECT * FROM categories WHERE id = $category_id");
        if($query_category) {
            foreach($query_category as $row) {
                $category = $row['title'];
            }
        }

        //if post is featured (1), set others to not featured (0)
        if ($is_featured == 1) {
            $query_is_featured = mysqli_query($con, "UPDATE posts SET is_featured = 0");
        }


        //choose thumbnail to insert
        if(!isset($thumbnail_name)) {
            $thumbnail_name = $prev_thumbnail;
        }

        //Update post
        $query = mysqli_query($con, "UPDATE posts SET author_id = '$user_id', category_id = '$category_id', title = '$title', category = '$category', body = '$body', is_featured = '$is_featured', thumbnail = '$thumbnail_name' WHERE id = '$id'");

        if($query) {
            $_SESSION['edit-post-success'] = "Post updated";
            //redirect to manage posts
            header('location: ' . ROOT_URL . 'admin/index.php');
        }
    }

    if (isset($_SESSION['edit-post'])){
        header('location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $id);
    }
}
else {
    header('location: ' . ROOT_URL . 'admin/edit-post.php');
}