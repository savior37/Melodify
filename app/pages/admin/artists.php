<?php

if ($action == 'add') {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $errors = [];

        //data validation
        if (empty($_POST['name'])) {
            $errors['name'] = "a name is required";
        } else
            if (!preg_match("/^[a-zA-Z \&\-]+$/", $_POST['name'])) {
                $errors['name'] = "a name can only letters & spaces";
            }

        //image
        if (!empty($_FILES['image']['name'])) {

            $folder = "uploads/";
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
                file_put_contents($folder . "index.php", "");
            }

            $allowed = ['image/jpeg', 'image/png'];

            if ($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed)) {
                $destination = $folder . $_FILES['image']['name'];

                move_uploaded_file($_FILES['image']['tmp_name'], $destination);

            } else {
                $errors['image'] = "image not valid. Allowed types are " . implode(",", $allowed);
            }
        } else {
            $errors["image"] = "an image is required";
        }


        if (empty($errors)) {

            $values = [];
            $values['name'] = trim($_POST['name']);
            $values['bio'] = trim($_POST['bio']);
            $values['image'] = $destination;
            $values['user_id'] = user('id');

            $query = "insert into artists (name,image,user_id,bio) values (:name,:image,:user_id,:bio)";
            db_query($query, $values);

            message("artist created successfully");
            redirect('admin/artists');
        }
    }
} else
    if ($action == 'edit') {


        $query = "select * from artists where id = :id limit 1";
        $row = db_query_one($query, ['id' => $id]);

        if ($_SERVER['REQUEST_METHOD'] == "POST" && $row) {

            $errors = [];

            //data validation
            if (empty($_POST['name'])) {
                $errors['name'] = "a name is required";
            } else
                if (!preg_match("/^[a-zA-Z \&\-]+$/", $_POST['name'])) {
                    $errors['name'] = "a name can only letters & spaces";
                }

            //image handling for edit
            $destination = '';
            if (!empty($_FILES['image']['name'])) {
                $folder = "uploads/";
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                    file_put_contents($folder . "index.php", "");
                }

                $allowed = ['image/jpeg', 'image/png'];

                if ($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed)) {
                    $destination = $folder . $_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                } else {
                    $errors['image'] = "image not valid. Allowed types are " . implode(",", $allowed);
                }
            }

            if (empty($errors)) {

                $values = [];
                $values['name'] = trim($_POST['name']);
                $values['bio'] = trim($_POST['bio']);
                $values['user_id'] = user('id');
                $values['id'] = $id;

                if (!empty($destination)) {
                    $query = 'update artists set name = :name, bio = :bio, user_id = :user_id, image = :image where id = :id limit 1';
                    $values['image'] = $destination;
                } else {
                    $query = 'update artists set name = :name, bio = :bio, user_id = :user_id where id = :id limit 1';
                }

                db_query($query, $values);

                message("artist edited successfully");
                redirect('admin/artists');

            }
        }
    } else
        if ($action == 'delete') {


            $query = "select * from artists where id = :id limit 1";
            $row = db_query_one($query, ['id' => $id]);

            if ($_SERVER['REQUEST_METHOD'] == "POST" && $row) {

                $errors = [];

                if (empty($errors)) {

                    $values = [];
                    $values['id'] = $id;
                    $query = "delete from artists where id = :id limit 1";

                    db_query($query, $values);

                    message("artist deleted successfully");
                    redirect('admin/artists');
                }
            }
        }

?>
<?php require page('includes/admin-header') ?>

<section class="admin-content" style="min-height: 200px;">
    <?php if (isset($action) && $action == 'add'): ?>
        <div style="max-width: 500px; margin: auto">
            <form method="post" enctype="multipart/form-data">

                <h3>Add New Artist</h3>

                <div style="margin-bottom: 15px;">
                    <input class="form-control" value="<?= set_value('name')?>" type="text" name="name" placeholder="name"
                        style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                    <?php if (!empty($errors['name'])): ?>
                        <small class="error"><?= $errors['name'] ?></small>
                    <?php endif; ?>
                </div>

                <div style="margin-bottom: 15px;">
                    <label>Artist Image:</label>
                    <input class="form-control" type="file" name="image">

                    <label>Artist Bio:</label>
                    <textarea rows="10" class="form-control" name="bio"><?=set_value('bio')?></textarea>

                    <?php if (!empty($errors['image'])): ?>
                        <small class="error"><?= $errors['image'] ?></small>
                    <?php endif; ?>
                </div>


            
                <button class="btn bg-orange" type="submit" style="border-radius: 6px; padding: 8px 16px;">Create</button>
                <a href="<?= ROOT ?>/admin/artists">
                    <button type="button" class="float-end btn" style="border-radius: 6px; padding: 8px 16px;">Back</button>
                </a>
            </form>
        </div>
    <?php elseif (isset($action) && $action == 'edit'): ?>
        <div style="max-width: 500px; margin: auto">
            <form method="post" enctype="multipart/form-data">
                <h3>Edit Artist</h3>

                <?php if (!empty($row)): ?>
                    <div style="margin-bottom: 15px;">
                        <input class="form-control" value="<?= set_value('name', $row['name']) ?>" type="text" name="name"
                            placeholder="name" style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                        <?php if (!empty($errors['name'])): ?>
                            <small class="error"><?= $errors['name'] ?></small>
                        <?php endif; ?>
                    </div>

                    <img src="<?= ROOT ?>/<?= $row['image'] ?>" style="width:200px;height: 200px;object-fit: cover;">
                    
                    <div>Artist Image:</div>
                    <input class="form-control" type="file" name="image">
                    <?php if (!empty($errors['image'])): ?>
                        <small class="error"><?= $errors['image'] ?></small>
                    <?php endif; ?>

                    <label>Artist Bio:</label>
                    <textarea rows="10" class="form-control" name="bio"><?=set_value('bio',$row['bio'])?></textarea>

                    <button class="btn bg-orange" type="submit" style="border-radius: 6px; padding: 8px 16px;">Update</button>
                    <a href="<?= ROOT ?>/admin/artists">
                        <button type="button" class="float-end btn" style="border-radius: 6px; padding: 8px 16px;">Back</button>
                    </a>
                <?php else: ?>
                    <div class="alert">That record was not found</div>
                    <a href="<?= ROOT ?>/admin/artists">
                        <button type="button" class="float-end btn" style="border-radius: 6px; padding: 8px 16px;">Back</button>
                    </a>
                <?php endif; ?>
            </form>
        </div>

    <?php elseif (isset($action) && $action == 'delete'): ?>

        <div style="max-width: 500px; margin: auto">
            <form method="post">
                <h3>Delete Artist</h3>
                <?php if (!empty($row)): ?>
                    <div style="margin-bottom: 15px;">
                        <div class="form-control"><?= set_value('name', $row['name']) ?></div>
                        <?php if (!empty($errors['name'])): ?>
                            <small class="error"><?= $errors['name'] ?></small>
                        <?php endif; ?>
                    </div>

                    <button class="btn bg-red" type="submit" style="border-radius: 6px; padding: 8px 16px;">Delete</button>
                    <a href="<?= ROOT ?>/admin/artists">
                        <button type="button" class="float-end btn" style="border-radius: 6px; padding: 8px 16px;">Back</button>
                    </a>
                <?php else: ?>
                    <div class="alert">That record was not found</div>
                    <a href="<?= ROOT ?>/admin/artists">
                        <button type="button" class="float-end btn" style="border-radius: 6px; padding: 8px 16px;">Back</button>
                    </a>
                <?php endif; ?>
            </form>
        </div>
    <?php else: ?>

        <?php
        $query = "select * from artists order by id asc limit 20";
        $rows = db_query($query);
        ?>

        <h3>Artists
            <a href="<?= ROOT ?>/admin/artists/add">
                <button class="float-end btn bg-purple" style="border-radius: 6px; padding: 8px 16px;">Add New</button>
            </a>
        </h3>

        <table class="table">

            <tr>
                <th>ID</th>
                <th>Artist</th>
                <th>Image</th>
                <th>Action</th>
            </tr>

            <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td>
                            <a href="<?=ROOT?>/artist/<?=$row['id']?>">
                            <img src="<?= ROOT ?>/<?= $row['image'] ?>" style="width:100px;height: 100px;object-fit: cover;">
                            </a>
                        </td>
                        <td>
                            <a href="<?= ROOT ?>/admin/artists/edit/<?= $row['id'] ?>">
                                <img class="bi" src="<?= ROOT ?>/assets/icons/pencil-square.svg">
                            </a>
                            <a href="<?= ROOT ?>/admin/artists/delete/<?= $row['id'] ?>">
                                <img class="bi" src="<?= ROOT ?>/assets/icons/trash3.svg">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

        </table>
    <?php endif; ?>

</section>
<?php require page('includes/admin-footer') ?>