<?php

//message("testing one two");
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {

        $errors = [];

        //data validation
        if(empty($_POST['username']))
        {
            $errors['username'] = "a username is required";
        } else
        if(!preg_match("/^[a-zA-Z]+$/", $_POST['username'])) {
            $errors['username'] = "a username can only letters with no spaces";
        }

        if(empty($_POST['email']))
        {
            $errors['email'] = "an email is required";
        } else
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "email is not valid";
        }

        if(empty($_POST['password']))
        {
            $errors['password'] = "a password is required";
        }else
        if($_POST['password'] != $_POST['retype_password']) {
            $errors['password'] = "passwords do not match";
        }else
        if(strlen($_POST['password']) < 8)
        {
            $errors['password'] = "password must be 8 character or more";
        }

        if(empty($_POST['role']))
        {
            $errors['role'] = "a role is required";
        }

        if(empty($errors))
        {

            $values = [];
            $values['username'] = trim($_POST['username']);
            $values['email']    = trim($_POST['email']);
            $values['role']     = trim($_POST['role']);
            $values['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $values['date']     = date("Y-m-d H:1:s");
            
            $query = "insert into users (username,email,password,role,date) values (:username,:email,:password,:role,:date)";
            db_query($query,$values);

            message("user created successfully");
            redirect('admin/users');
        }
    }
?>

<?php require page('includes/admin-header') ?>

<section class="admin-content" style="min-height: 200px;">
    <?php if (isset($action) && $action == 'add'): ?>
        <div style="max-width: 500px; margin: auto">
            <form method="post">
                <h3>Add New User</h3>
                <div style="margin-bottom: 15px;">
                    <input class="form-control" value="<?=set_value('username')?>" type="text" name="username" placeholder="Username"
                        style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                    <?php if (!empty($errors['username'])): ?>
                        <small class="error"><?= $errors['username'] ?></small>
                    <?php endif; ?>
                </div>
                <div style="margin-bottom: 15px;">
                    <input class="form-control" value="<?=set_value('email')?>" type="email" name="email" placeholder="Email"
                        style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                    <?php if (!empty($errors['email'])): ?>
                        <small class="error"><?= $errors['email'] ?></small>
                    <?php endif; ?>
                </div>
                <select name="role" class="form-control">
                    <option value="">--Select Role--</option>
                    <option <?=set_select('role', 'user')?> value="user">User</option>
                    <option <?=set_select('role', 'admin')?> value="admin">Admin</option>
                </select>
                <?php if (!empty($errors['role'])): ?>
                    <small class="error"><?= $errors['role'] ?></small>
                <?php endif; ?>
                <div style="margin-bottom: 15px;">
                    <input class="form-control" value="<?=set_value('password')?>" type="password" name="password" placeholder="Password"
                        style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                </div>
                <?php if (!empty($errors['password'])): ?>
                    <small class="error"><?= $errors['password'] ?></small>
                <?php endif; ?>

                <div style="margin-bottom: 15px;">
                    <input class="form-control" value="<?=set_value('retype_password')?>" type="password" name="retype_password" placeholder="Confirm Password"
                        style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                </div>
                <button class="btn bg-orange" type="submit" style="border-radius: 6px; padding: 8px 16px;">Create</button>
                <a href="<?= ROOT ?>/admin/users">
                    <button type="button" class="float-end btn" style="border-radius: 6px; padding: 8px 16px;">Back</button>
                </a>
            </form>
        </div>

    <?php elseif (isset($action) && $action == 'edit'): ?>
        edit
    <?php elseif (isset($action) && $action == 'delete'): ?>
        delete
    <?php else: ?>

        <?php
            $query = "select * from users order by id asc limit 20";
            $rows = db_query($query);
        ?>

        <h3>Users
            <a href="<?= ROOT ?>/admin/users/add">
                <button class="float-end btn bg-purple" style="border-radius: 6px; padding: 8px 16px;">Add New</button>
            </a>
        </h3>

        <table class="table">
            
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Date</th>
                <th>Action</th>
            </tr>

            <?php if(!empty($rows)):?>
                <?php foreach($rows as $row):?>
                    <tr>
                        <td><?=$row['id']?></td>
                        <td><?=$row['username']?></td>
                        <td><?=$row['email']?></td>
                        <td><?=$row['role']?></td>
                        <td><?=get_date($row['date'])?></td>
                        <td>
                            <a href="<?=ROOT?>/admin/users/edit/<?=$row['id']?>">
                                <img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
                            </a>
                            <a href="<?=ROOT?>/admin/users/delete/<?=$row['id']?>">
                                <img class="bi" src="<?=ROOT?>/assets/icons/trash3.svg">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

        </table>
    <?php endif; ?>

</section>
<?php require page('includes/admin-footer') ?>