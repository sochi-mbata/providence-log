<?php

include 'config/database.php'; 

if (isset($_POST['add-user'])) {
   $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
   $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
   $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
   $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); 
   $create_password = filter_var($_POST['create_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $is_admin = filter_var($_POST['is_admin'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $avatar = $_FILES['avatar'];

    if (empty($firstname)) {
        $_SESSION['add-user'] = "Firstname required";
    }
    elseif (empty($lastname)) {
        $_SESSION['add-user'] = "Lastname required";
    }
    elseif (empty($username)) {
        $_SESSION['add-user'] = "Username required";
    }
    elseif (empty($email)) {
        $_SESSION['add-user'] = "Email required";
    }
    elseif (strlen($create_password) < 4 || strlen($confirm_password) < 4) {
        $_SESSION['add-user'] = "Password should be 4+ characters long";
    }
    elseif (empty($avatar['name'])) {
        $_SESSION['add-user'] = "Select an avatar";
    }
    elseif ($is_admin != "0" && $is_admin != "1") {
        $_SESSION['add-user'] = "Assign user role";
    }
    else {
        if ($create_password !== $confirm_password) {
            $_SESSION['add-user'] = "Password does not match";
        }
        else {
            $hashed_password = password_hash($create_password, PASSWORD_DEFAULT);
            //check if username exists in database
            $username_check_query = "SELECT username FROM users WHERE username = '$username'";
            $username_check_result = mysqli_query($con, $username_check_query);

            if (mysqli_num_rows($username_check_result) > 0) {
                $_SESSION['add-user'] = "Username already exists!";
            }
            //check if email exists in database
            $user_check_query = "SELECT email FROM users WHERE email = '$email'";
            $user_check_result = mysqli_query($con, $user_check_query);

            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['add-user'] = "Email already exists!";
            }
            else {
                // work on the avatar
                // rename avatar
                $time = time(); // make each image name unique using timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;
    
                // make sure file is allowed
                $alloowed_files = ['png', 'jpg', 'jpeg'];
                $extension = explode('.', $avatar_name);
                $extension = end($extension);
    
                if (in_array($extension, $alloowed_files)) {
                    //make sure image is not more than 2mb
                    if ($avatar['size'] < 2000000) {
                        //upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    }
                    else {
                        $_SESSION['add-user'] = "File size is too big. Should be less than 2mb";
                    }
                }
                else {
                    $_SESSION['add-user'] = "File should be png, jpg or jpeg";
                }

            }

        }
    }


    if(isset($_SESSION['add-user'])) {
        $_SESSION['add-user-data'] = $_POST;
        //redirect to add-user page
        header('location: ' . ROOT_URL . 'admin/add-user.php');
    }
    else {
        //insert into the database
        $user_insert_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin)
        VALUE ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', '$is_admin')";

        if (mysqli_query($con, $user_insert_query)) {
            $_SESSION['add-user-success'] = "New user added successfully";
            //redirect to manage users page
            header('location: '. ROOT_URL . 'admin/manage-users.php');
        }
    }

}
else {
    header('location: ' . ROOT_URL . 'admin/add-user.php');
    die();
}