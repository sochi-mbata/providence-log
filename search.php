<?php
include "partials/header.php";

if (isset($_GET['search'])) {
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query_posts_all = mysqli_query($con, "SELECT * FROM posts WHERE title LIKE '%$search%' ORDER BY id DESC");
}
else {
    header('location: ' . ROOT_URL . 'blog.php');
}
?>

<?php if (mysqli_num_rows($query_posts_all) > 0):  ?>
    <div class="posts section__extra-margin">
        <div class="container posts_container">
        <?php
            foreach($query_posts_all as $row) {
                $post_id = $row['id'];
                $thumbnail = $row['thumbnail'];
                $category_id = $row['category_id'];
                $category = $row['category'];
                $title = $row['title'];
                $body = $row['body'];
                $author_id = $row['author_id'];
                $date = $row['date'];

                ?>
                    <article class="post">
                        <div class="post__thumbnail">
                            <img src="./images/<?= $thumbnail ?>">
                        </div>
                        <div class="post__info">
                            <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category_id ?>" class="category__button">
                                <?= $category ?>
                            </a>
                            <h3 class="post__title">
                                <a href="<?= ROOT_URL ?>post.php?id=<?= $post_id ?>"><?= $title ?></a>
                            </h3>
                            <p class="post__body"><?= $body ?></p>
                            <div class="post__author">
                                <?php
                                    $query_user = mysqli_query($con, "SELECT * FROM users WHERE id = $author_id");
                                    foreach ($query_user as $value) {
                                        $name = $value['firstname'] . " " . $value['lastname'];
                                        $avatar = $value['avatar'];
                                    }
                                ?>
                                <div class="post__author-avatar">
                                    <img src="./images/<?= $avatar ?>">
                                </div>
                                <div class="post__author-info">
                                    <h5>By: <?= $name ?></h5>
                                    <small><?= date_format(new DateTime($date), "M d, Y-h:i:sa") ?></small>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php
            }
        ?>
        </div>
    </div>
<?php else: ?>
    <section class="search__bar">
        <form class="container search__bar-container" action="<?= ROOT_URL ?>search.php" method="GET">
            <div>
                <i class="fa fa-search"></i>
                <input type="search" name="search" placeholder="search">
            </div>
            <button type="submit" name="submit" class="btn">Go</button>
        </form>
    </section>
    <div class="alert__message error lg section__extra-margin">
        <p>No items match your search</p>
    </div>
<?php endif ?>


<?php include "partials/footer.php" ?>