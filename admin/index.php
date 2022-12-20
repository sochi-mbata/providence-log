<?php 
include "partials/header.php";

?>



    <section class="dashboard">
        <?php if(isset($_SESSION['signin-success'])): ?>
            <div class="container alert__message success">
                <p style="font-size: large;">
                <?= $_SESSION['signin-success']; 
                unset($_SESSION['signin-success']);
                ?>
                </p>
            </div>
        <?php endif ?>
        <?php if(isset($_SESSION['add-post-success'])): ?>
            <div class="container alert__message success">
                <p style="font-size: large;">
                <?= $_SESSION['add-post-success']; 
                unset($_SESSION['add-post-success']);
                ?>
                </p>
            </div>
        <?php endif ?>
        <?php if(isset($_SESSION['edit-post-success'])): ?>
            <div class="container alert__message success">
                <p style="font-size: large;">
                <?= $_SESSION['edit-post-success']; 
                unset($_SESSION['edit-post-success']);
                ?>
                </p>
            </div>
        <?php endif ?>
        <?php if(isset($_SESSION['delete-success'])): ?>
            <div class="container alert__message success">
                <p style="font-size: large;">
                <?= $_SESSION['delete-success']; 
                unset($_SESSION['delete-success']);
                ?>
                </p>
            </div>
        <?php endif ?>
        <?php if(isset($_SESSION['delete'])): ?>
            <div class="alert__message error container">
                <p>
                    <?= $_SESSION['delete']; 
                        unset($_SESSION['delete']);
                    ?>
                </p>
            </div>
    <?php endif ?>
        <div class="container dashboard__container">
            <button id="show__sidebar-btn" class="sidebar__toggle"><i class="fa fa-angle-right"></i></button>
            <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="fa fa-angle-left"></i></button>
            <aside>
                <ul>
                    <li>
                        <a href="<?= ROOT_URL ?>admin/add-post.php"><i class="fa fa-pen"></i>
                            <h5>Add Post</h5>
                        </a>
                    </li>
                    <li>
                        <a href="<?= ROOT_URL ?>admin/index.php" class="active"><i class="fa fa-vcard"></i>
                            <h5>Manage Posts</h5>
                        </a>
                    </li>
                    <?php if(isset($_SESSION['user-role'])): ?>
                        <?php if($_SESSION['user-role'] == 1): ?>
                            <li>
                                <a href="<?= ROOT_URL ?>admin/add-user.php"><i class="fa fa-user-plus"></i>
                                    <h5>Add User</h5>
                                </a>
                            </li>
                            <li>
                                <a href="<?= ROOT_URL ?>admin/manage-users.php"><i class="fa fa-users-cog"></i>
                                    <h5>Manage User</h5>
                                </a>
                            </li>
                            <li>
                                <a href="<?= ROOT_URL ?>admin/add-category.php"><i class="fa fa-edit"></i>
                                    <h5>Add Category</h5>
                                </a>
                            </li>
                            <li>
                                <a href="<?= ROOT_URL ?>admin/manage-categories.php"><i class="fa fa-list-ul"></i>
                                    <h5>Manage Categories</h5>
                                </a>
                            </li>
                        <?php endif ?>
                    <?php endif ?>
                </ul>
            </aside>
            <main>
                <h2>Manage Posts</h2>
                <table>
                    
                    <?php
                        $user_id = $_SESSION['user']['id'];
                        $query = "SELECT * FROM posts WHERE author_id = '$user_id'";
                        $result = mysqli_query($con, $query);

                        if (mysqli_num_rows($result) > 0) {
                            ?>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($result as $row) {
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    $category = $row['category'];
                                    ?>
                                        <tr>
                                        <td><?= $title ?></td>
                                        <td><?= $category ?></td>
                                        <td><a href="<?= ROOT_URL ?>admin/edit-post.php?id=<?= $id ?>" class="btn sm">Edit</a></td>
                                        <td><a href="<?= ROOT_URL ?>admin/delete-post-logic.php?id=<?= $id ?>" class="btn sm danger" onclick="confirmation_box();">Delete</a></td>
                                        </tr>
                                    <?php
                                }
                        }
                        else{
                                ?>
                                <div class="alert__message error">
                                    No Post Yet
                                </div>
                                <?php
                        }
                                ?>
                            </tbody>
                </table>
            </main>
        </div>
    </section>

        <!-- Delete Post -->
<script>

function confirmation_box() {
    if (confirm('Are you sure?')) {
        return true;
    }
    else {
        event.stopPropagation();
        event.preventDefault();
    }
}
</script>

<?php 
    include "partials/footer.php";
?>