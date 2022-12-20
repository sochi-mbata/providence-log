<?php 
    include './admin/config/database.php';
    $firstname = $_SESSION['signup-data']['firstname'] ?? null; 
    $lastname = $_SESSION['signup-data']['lastname'] ?? null; 
    $username = $_SESSION['signup-data']['username'] ?? null; 
    $email = $_SESSION['signup-data']['email'] ?? null; 
    $create_password = $_SESSION['signup-data']['create_password'] ?? null; 
    $confirm_password = $_SESSION['signup-data']['confirm_password'] ?? null; 

    unset($_SESSION['signup-data']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tee Blog website</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./fontawesome-free-6.1.1-web/css/all.css">
    <!-- GOOGLE FONT (MONTSERRAT) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body>
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Sign up</h2>
            <?php if(isset($_SESSION['signup'])): ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['signup']; 
                            unset($_SESSION['signup']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL?>signup-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" placeholder="First Name" name="firstname" value="<?=$firstname?>">
                <input type="text" placeholder="Last Name" name="lastname" value="<?=$lastname?>">
                <input type="text" placeholder="Username" name="username" value="<?=$username?>">
                <input type="email" placeholder="Email" name="email" value="<?=$email?>">
                <input type="password" placeholder="Create Password" name="create_password" value="<?=$create_password?>">
                <input type="password" placeholder="Confirm Password" name="confirm_password" value="<?=$confirm_password?>">
                <div class="form__control">
                    <label for="avatar">User avatar</label>
                    <input type="file" id="avatar" name="avatar">
                </div>
                <button class="btn" type="submit" name="signup">Sign up</button>
                <small>Already have an account? <a href="signin.php">Sign In</a></small>
            </form>
        </div>
    </section>



</body>

</html>