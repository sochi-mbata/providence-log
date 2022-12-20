<?php 
    include "partials/header.php";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM posts WHERE id=$id";
        $result = mysqli_query($con, $query);
        foreach ($result as $row) {
            $title = $row['title'];
            $category_id = $row['category_id'];
            $category = $row['category'];
            $body = $row['body'];
            $is_featured = $row['is_featured'];
            $prev_thumbnail = $row['thumbnail'];
        }
    }
    // else {
    //     header('location: '. ROOT_URL .'admin/index.php');
    // }
?>

<section class="form__section">
    <div class="container form__section-container">
    <?php if(isset($_SESSION['edit-post'])): ?>
                <div class="alert__message error">
                    <p style="font-size: 20px;">
                        <?= $_SESSION['edit-post']; 
                            unset($_SESSION['edit-post']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
        <h2>Edit Post</h2>
        <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" value="<?= $id ?>" name="id">
            <input type="text" placeholder="Title" value="<?= $title ?>" name="title">
            <select name="category_id">
                <?php
                    $query = "SELECT id, title FROM categories";
                    $result = mysqli_query($con, $query);

                    foreach ($result as $row) {
                        $category_id = $row['id'];
                        $cat_title = $row['title'];
                        if ($cat_title == $category) {
                            ?>
                                <option value="<?= $category_id ?>" selected><?= $cat_title ?></option>
                            <?php
                        }
                        else {
                            ?>
                                <option value="<?= $category_id ?>"><?= $cat_title ?></option>
                            <?php
                        }
                    }
                ?>
            </select>
            <textarea rows="10" placeholder="Body" name="body"><?= $body ?></textarea>
            <?php if ($_SESSION['user']['is_admin'] ==1): ?>
            <div class="form__control inline">
                <?php
                    if ($is_featured == 1) {
                        ?>
                        <input type="checkbox" id="is_featured" checked name="is_featured" value="1">
                        <?php
                    }
                    else {
                        ?>
                            <input type="checkbox" id="is_featured" name="is_featured" value="0">
                        <?php
                    }
                ?>
                <label for="is_featured">Featured</label>
            </div>
            <?php endif ?>

            <div class="form__control">
                <label for="thumbnail">Change Thumbnail</label>
                <input type="hidden" value="<?= $prev_thumbnail ?>" name="prev_thumbnail">
                <input type="file" id="thumbnail" name="thumbnail">
            </div>
            <button class="btn " type="submit " name="submit">Update Post</button>
        </form>
    </div>
</section>


<?php 
    include "partials/footer.php";
?>

