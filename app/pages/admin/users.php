<?php

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {

        $errors = [];

        //data validation
        if(empty($_POST['username']))
        {
            $errors['username'] = "a username is required";
        } else
        if(!preg_match("/^[a-zA-Z]+$/", $_POST['username'])) {
            $errors['username'] = "a username can only letters with no scpaces";
        }

        if(empty($_POST['email']))
        {
            $errors['email'] = "a email is required";
        } else
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "email is not valid";
        }

        if(empty($_POST['password']))
        {
            $errors['password'] = "a password is required";
        }else
        if($_POST['password'] != $_POST['retype_password']) {
            $errors['password'] = "password do not match";
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

            redirect('admin/users');
        }
    }
?>

<?php require page('includes/admin-header') ?>

<section class="admin-content" style="min-height: 200px;">
    <?php if (isset($action) && $action == 'add'): ?>
        <div style="max-width: 500px; margin: auto">
            <form class="method=post">
                <h3>Add New User</h3>
                <div style="margin-bottom: 15px;">
                    <input class="form-control my-1" value="<?=set_value('username')?>" type="text" name="username" placeholder="Username"
                        style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                    <?php if (!empty($errors['username'])): ?>
                        <small class="error"><?= $errors['username'] ?></small>
                    <?php endif; ?>
                </div>
                <div style="margin-bottom: 15px;">
                    <input class="form-control my-1" value="<?=set_value('email')?>" type="email" name="email" placeholder="Email"
                        style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                    <?php if (!empty($errors['email'])): ?>
                        <small class="error"><?= $errors['email'] ?></small>
                    <?php endif; ?>
                </div>
                <select>
                    <option value="">--Select Role--</option>
                    <option <?=set_select('role', 'user')?> value="user">User</option>
                    <option <?=set_select('role', 'admin')?> value="admin">Admin</option>
                </select>
                <?php if (!empty($errors['role'])): ?>
                    <small class="error"><?= $errors['role'] ?></small>
                <?php endif; ?>
                <div style="margin-bottom: 15px;">
                    <input class="form-control my-1" value="<?=set_value('password')?>" type="password" name="password" placeholder="Password"
                        style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                </div>
                <?php if (!empty($errors['password'])): ?>
                    <small class="error"><?= $errors['password'] ?></small>
                <?php endif; ?>

                <div style="margin-bottom: 15px;">
                    <input class="form-control my-1" value="<?=set_value('retype_password')?>" type="password" name="retype_password" placeholder="Confirm Password"
                        style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                </div>
                <button class="btn bg-orange" type="submit" style="border-radius: 6px; padding: 8px 16px;">Create</button>
                <a href="<? ROOT ?>/admin/users">
                    <button type="button" class="float-end btn" style="border-radius: 6px; padding: 8px 16px;">Back</button>
                </a>
            </form>
        </div>

    <?php elseif (isset($action) && $action == 'edit'): ?>
        edit
    <?php elseif (isset($action) && $action == 'delete'): ?>
        delete
    <?php else: ?>

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
            <tr>
                <td>ID</td>
                <td>Username</td>
                <td>Email</td>
                <td>Role</td>
                <td>Date</td>
                <td>Action</td>
            </tr>
        </table>

    <?php endif; ?>

</section>
<?php require page('includes/admin-footer') ?>