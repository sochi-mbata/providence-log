<?php 
    include './admin/config/database.php'; 
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tee Blog website</title>
    <link rel="stylesheet" href="<?= ROOT_URL?>css/style.css">
    <link rel="stylesheet" href="<?= ROOT_URL?>fontawesome-free-6.1.1-web/css/all.css">
    <!-- GOOGLE FONT (MONTSERRAT) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body>
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Sign In</h2>
            <?php if(isset($_SESSION['signup-success'])): ?>
                <div class="alert__message success">
                    <p>
                        <?= $_SESSION['signup-success']; 
                            unset($_SESSION['signup-success']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <?php if(isset($_SESSION['signin'])): ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['signin']; 
                            unset($_SESSION['signin']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
                <input type="text" placeholder="Username or Email" name="username_email">
                <input type="password" placeholder="Password" name="password">
                <button class="btn" type="submit" name="signin">Sign In</button>
                <small>Don't have an account? <a href="signup.php">Sign Up</a></small>
            </form>
        </div>
    </section>



</body>

