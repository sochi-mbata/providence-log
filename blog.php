<?php include "partials/header.php" ?>


    <section class="search__bar">
        <form class="container search__bar-container" action="<?= ROOT_URL ?>search.php" method="GET">
            <div>
                <i class="fa fa-search"></i>
                <input type="search" name="search" placeholder="search">
            </div>
            <button type="submit" name="submit" class="btn">Go</button>
        </form>
    </section>

    <!-- ================== END OF SEARCH ============= -->

<div class="posts">
    <div class="container posts__container">
        <?php
            $query_posts_all = mysqli_query($con, "SELECT * FROM posts ORDER BY id DESC");
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
<!-- ================== END OF POSTS ============= -->

<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php
            $query_cat = mysqli_query($con, "SELECT * FROM categories");
            foreach ($query_cat as $row) {
                $category_id = $row['id'];
                $title = $row['title'];
            ?>
            <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category_id ?>" class="category__button"><?= $title ?></a>
            <?php
            }
        ?>
    </div>
</section>

<!-- ================== END OF CATEGORY BUTTONS ============= -->

<?php include "partials/footer.php" ?>