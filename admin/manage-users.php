<?php 
    include "partials/header.php";
?>

<section class="dashboard">
    <?php if(isset($_SESSION['add-user-success'])): ?>
            <div class="alert__message success container">
                <p>
                    <?= $_SESSION['add-user-success']; 
                        unset($_SESSION['add-user-success']);
                    ?>
                </p>
            </div>
    <?php endif ?>
    <?php if(isset($_SESSION['update-user-success'])): ?>
            <div class="alert__message success container">
                <p>
                    <?= $_SESSION['update-user-success']; 
                        unset($_SESSION['update-user-success']);
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
    <?php if(isset($_SESSION['delete-success'])): ?>
            <div class="alert__message success container">
                <p>
                    <?= $_SESSION['delete-success']; 
                        unset($_SESSION['delete-success']);
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
                    <a href="./add-post.php"><i class="fa fa-pen"></i>
                        <h5>Add post</h5>
                    </a>
                </li>
                <li>
                    <a href="./index.php"><i class="fa fa-vcard"></i>
                        <h5>Manage posts</h5>
                    </a>
                </li>
                <li>
                    <a href="./add-user.php"><i class="fa fa-user-plus"></i>
                        <h5>Add User</h5>
                    </a>
                </li>
                <li>
                    <a href="./manage-users.php" class="active"><i class="fa fa-users-cog"></i>
                        <h5>Manage Users</h5>
                    </a>
                </li>
                <li>
                    <a href="./add-category.php"><i class="fa fa-edit"></i>
                        <h5>Add Category</h5>
                    </a>
                </li>
                <li>
                    <a href="./manage-categories.php"><i class="fa fa-list-ul"></i>
                        <h5>Manage Categories</h5>
                    </a>
                </li>
            </ul>
        </aside>
        <main>
            <h2>Manage Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $admin_id = $_SESSION['user']['id'];
                        $query = "SELECT * FROM users WHERE NOT id = '$admin_id'";
                        $result = mysqli_query($con, $query);

                        if (mysqli_num_rows($result) > 0) {
                            foreach ($result as $row) {
                                $name = "{$row['firstname']} {$row ['lastname']}";
                                $username = $row['username'];
                                $id = $row['id'];
                                $is_admin = $row['is_admin'];
                                if ($is_admin == '1') {
                                    $is_admin = "Yes";
                                }
                                elseif($is_admin == '0') {
                                    $is_admin = "No";
                                }
                    ?>

                            <tr>
                                <td><?= $name ?></td>
                                <td><?= $username ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $id ?>" class="btn sm">Edit</a></td>
                                <td><a href="<?= ROOT_URL ?>admin/delete-user-logic.php?id=<?= $id ?>" class="btn sm danger" onclick="confirmation_box();">Delete</a></td>
                                <td><?= $is_admin ?></td>
                            </tr>

                    <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
</section>

<!-- Delete User -->
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