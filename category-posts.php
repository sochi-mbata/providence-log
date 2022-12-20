<?php
    include "partials/header.php";

    if(isset($_GET['id'])) {
        $category_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $query_posts = mysqli_query($con, "SELECT * FROM posts WHERE category_id = $category_id ORDER BY id DESC");

        if(mysqli_num_rows($query_posts) > 0){
        foreach ($query_posts as $row) {
            $post_id = $row['id'];
            $thumbnail = $row['thumbnail'];
            $category_id = $row['category_id'];
            $category = $row['category'];
            $title = $row['title'];
            $body = $row['body'];
            $author_id = $row['author_id'];
            $date = $row['date'];
            
            ?>

            
            <header class="category__title">
                <h2><?= $category ?></h2>
            </header>
            
            <div class="posts">
                <div class="container posts__container">
                    <article class="post">
                        <div class="post__thumbnail">
                            <img src="./images/<?= $thumbnail ?>">
                        </div>
                        <div class="post__info">
                            <h3 class="post__title">
                                <a href="<?= ROOT_URL ?>post.php?id=<?= $post_id ?>"><?= $title ?></a>
                            </h3>
                            <p class="post__body"><?= substr($body, 0, 150) ?></p>
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
                </div>
            </div>
            
            <?php
        }
        }  else{
        ?>
        <div class="section__extra-margin">
        <p class="alert__message error lg">No Post found for this category</p>
        <?php
        }
    }
?>
    
    

   <!-- END OF POSTS -->
    
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
<?php
 include "partials/footer.php";    
?>