<?php 
include './partials/header.php';

if(isset($_GET['id'])) {
    $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query_posts = mysqli_query($con, "SELECT * FROM posts WHERE id = $post_id");

    foreach ($query_posts as $row) {
        $post_id = $row['id'];
        $thumbnail = $row['thumbnail'];
        $category_id = $row['category_id'];
        $category = $row['category'];
        $title = $row['title'];
        $body = $row['body'];
        $author_id = $row['author_id'];
        $date = $row['date'];
    }
}
?>

<section class="singlepost">
    <div class="container singlepost__container">
        <h2><?= $title ?></h2>
        <div class="post__author">
        <?php
            $query_user = mysqli_query($con, "SELECT * FROM users WHERE id = $author_id");
            foreach ($query_user as $value) {
                $name = $value['firstname'] . " " . $value['lastname'];
                $avatar = $value['avatar'];
            }
        ?>
            <div class="post__author-avatar">
                <img src="./images/<?= $avatar ?>" alt="">
            </div>
            <div class="post__author-info">
                <h5>By: <?= $name ?></h5>
                <small><?= date_format(new DateTime($date), "M d, Y-h:i:sa") ?></small>
            </div>
        </div>
        <div class="singlepost__thumbnail">
            <img src="./images/<?= $thumbnail ?>" alt="">
        </div>
        <p>
            <?= $body ?>
        </p>
    </div>
</section>

<!-- ================== END OF SINGLE POST ============= -->

<?php 
include "partials/footer.php";
?>