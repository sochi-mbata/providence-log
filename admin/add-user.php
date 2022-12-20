<?php 
    include "partials/header.php";

    $firstname = $_SESSION['add-user-data']['firstname'] ?? null; 
    $lastname = $_SESSION['add-user-data']['lastname'] ?? null; 
    $username = $_SESSION['add-user-data']['username'] ?? null; 
    $email = $_SESSION['add-user-data']['email'] ?? null; 
    $create_password = $_SESSION['add-user-data']['create_password'] ?? null; 
    $confirm_password = $_SESSION['add-user-data']['confirm_password'] ?? null; 

    unset($_SESSION['add-user-data']);
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Add User</h2>
        <?php if(isset($_SESSION['add-user'])): ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['add-user']; 
                            unset($_SESSION['add-user']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add-user-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" placeholder="First Name" name="firstname" value="<?= $firstname ?>">
            <input type="text" placeholder="Last Name" name="lastname" value="<?= $lastname ?>">
            <input type="text" placeholder="Username" name="username" value="<?= $username ?>">
            <input type="email" placeholder="Email" name="email">
            <input type="password" placeholder="Create Password" name="create_password" value="<?= $create_password ?>">
            <input type="password" placeholder="Confirm Password" name="confirm_password" value="<?= $confirm_password ?>">
            <select name="is_admin">
                <option value="">User Role</option>
                <option value="0">Author</option>
                <option value="1">Admin</option>
            </select>
            <div class="form__control">
                <label for="avatar">User avatar</label>
                <input type="file" id="avatar" name="avatar">
            </div>
            <button class="btn" type="submit" name="add-user">Add User</button>

        </form>
    </div>
</section>


<?php 
    include "partials/footer.php";
?>