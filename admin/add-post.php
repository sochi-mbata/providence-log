<?php 
    include "partials/header.php";

    $title = $_SESSION['add-post-data']['title'] ?? null;
    $body = $_SESSION['add-post-data']['body'] ?? null;

    unset($_SESSION['add-post-data']);
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Add Post</h2>
        <?php if(isset($_SESSION['add-post'])): ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['add-post']; 
                            unset($_SESSION['add-post']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add-post-logic.php" method="POST" enctype="multipart/form-data">
            <input type="text" placeholder="Title" name="title">
            <select name="category_id">
                <?php
                    $query = "SELECT id, title FROM categories";
                    $result = mysqli_query($con, $query);

                    if (mysqli_num_rows($result) > 0) {
                        foreach ($result as $row) {
                            $category_id = $row['id'];
                            $title = $row['title'];
                            ?>
                            <option value="<?= $category_id ?>"><?= $title ?></option>
                            <?php
                        }
                    }
                ?>
            </select>
            <textarea rows="10" placeholder="Body" name="body"></textarea>
            <?php if ($_SESSION['user']['is_admin'] ==1): ?>
            <div class="form__control inline">
                <input type="checkbox" id="is_featured" checked name="is_featured">
                <label for="is_featured">Featured</label>
            </div>
            <?php endif ?>

            <div class="form__control">
                <label for="thumbnail">Add Thumbnail</label>
                <input type="file" id="thumbnail" name="thumbnail">
            </div>
            <button class="btn" type="submit" name="add_post">Add Post</button>
        </form>
    </div>
</section>


<?php 
    include "partials/footer.php";
?>