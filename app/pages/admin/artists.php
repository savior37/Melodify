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
        if(!empty($_FILES['image']['name']))
        {

            $folder = "uploads/";
            if(!file_exists($folder))
            {
                mkdir($folder,0777,true);
                file_put_contents($folder."index.php", "");
            }

            $allowed = ['image/jpeg','image/png'];

            if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed))
            {
                $destination = $folder. $_FILES['image']['name'];
                
                move_uploaded_file($_FILES['image']['tmp_name'], $destination);
            } else {
                $errors['name'] = "image not valid. Allowed types are ". implode(",", $allowed);
            }
            
           

        }else{
            $errors['name'] = "a image is required";
        }
        if (empty($errors)) {

            $values = [];
            $values['name'] = trim($_POST['name']);
            $values['image'] = $destination;
            $values['user_id'] = user('id');

            $query = "insert into artists (name,image,user_id) values (:name,:image,:user_id)";
            db_query($query, $values);

            message("name created successfully");
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
                    $errors['name'] = "a name can only letters with no spaces";
                }


            if (empty($errors)) {

                $values = [];
                $values['name'] = trim($_POST['name']);
                $values['disabled'] = trim($_POST['disabled']);
                $values['id'] = $id;

                $query = 'update artists set name = :name, disabled = :disabled where id = :id limit 1';
                db_query($query, $values);

                message("name edited successfully");
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

                message("name deleted successfully");
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
                    <input class="form-control" value="<?= set_value('name') ?>" type="text" name="name"
                        placeholder="name" style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                    <?php if (!empty($errors['name'])): ?>
                        <small class="error"><?= $errors['name'] ?></small>
                    <?php endif; ?>
                </div>

                <div style="margin-bottom: 15px;">
                    <input class="form-control" type="file" name="image">
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
            <form method="post">
                <h3>Edit Artist</h3>

                <?php if (!empty($row)): ?>
                    <div style="margin-bottom: 15px;">
                        <input class="form-control" value="<?= set_value('name', $row['name']) ?>" type="text"
                            name="name" placeholder="name" style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                        <?php if (!empty($errors['name'])): ?>
                            <small class="error"><?= $errors['name'] ?></small>
                        <?php endif; ?>
                    </div>
                    
                    <select name="disabled" class="form-control" style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                        <option value="">--Select Disabled--</option>
                        <option <?= set_select('disabled', '1', $row['disabled']) ?> value="1">Yes</option>
                        <option <?= set_select('disabled', '0', $row['disabled']) ?> value="0">No</option>
                    </select> 

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
                        <div class="form-control" ><?= set_value('name', $row['name'])?></div>
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
                        <td><?= $row['image'] ?></td>
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