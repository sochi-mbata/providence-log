<?php 
    include "partials/header.php";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM categories WHERE id=$id";
        $result = mysqli_query($con, $query);
        foreach ($result as $row) {
            $title = $row['title'];
            $description = $row['description'];
        }
    }
    else {
        header('location: '. ROOT_URL .'admin/manage-categories.php');
    }
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Category</h2>
        <?php if(isset($_SESSION['edit-category'])): ?>
                <div class="alert__message error">
                    <p style="font-size: 20px;">
                        <?= $_SESSION['edit-category']; 
                            unset($_SESSION['edit-category']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/edit-category-logic.php" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="text" placeholder="Title" name="title" value="<?= $title ?>">
            <textarea rows="4" placeholder="Description" name="description"><?= $description ?></textarea>
            <button class="btn " type="submit " name="submit">Edit Category</button>
        </form>
    </div>
</section>


<?php 
    include "partials/footer.php";
?>