<?php
include 'config/database.php';

if (isset($_POST['update-user'])) {
     
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT); 
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['is_admin'], FILTER_SANITIZE_NUMBER_INT);


    if (empty($firstname)) {
        $_SESSION['edit-user'] = "Firstname required";
    }
    elseif (empty($lastname)) {
        $_SESSION['edit-user'] = "Lastname required";
    }
    else {
       $update_query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', is_admin = $is_admin WHERE id = $id LIMIT 1";
       $result = mysqli_query($con, $update_query);

       if (mysqli_query($con, $update_query)) {
        $_SESSION['update-user-success'] = "$firstname $lastname updated successfully";
        //redirect to manage users page
        header('location: '. ROOT_URL . 'admin/manage-users.php');
        }
    }

    if (isset($_SESSION['edit-user'])){
    
        header('location: ' . ROOT_URL . 'admin/edit-user.php?id=' . $id);
    }
}
else {
    header('location: ' . ROOT_URL . 'admin/edit-user.php');
    die();
}