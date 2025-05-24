<?php require page('includes/admin-header') ?>

<section class="admin-content" style="min-height: 200px;">
    <?php if (isset($action) && $action == 'add'): ?>
        <div style="max-width: 500px; margin: auto">
            <form class="method=post">
                <h3>Add New User</h3>
                <div style="margin-bottom: 15px;">
                    <input class="form-control" type="text" name="username" placeholder="Username"
                        style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                    <?php if (!empty($errors['username'])): ?>
                        <small class="error"><?= $errors['username'] ?></small>
                    <?php endif; ?>
                </div>
                <div style="margin-bottom: 15px;">
                    <input class="form-control" type="email" name="email" placeholder="Email"
                        style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                    <?php if (!empty($errors['email'])): ?>
                        <small class="error"><?= $errors['email'] ?></small>
                    <?php endif; ?>
                </div>
                <select>
                    <option value="">--Select Role--</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <?php if (!empty($errors['role'])): ?>
                    <small class="error"><?= $errors['role'] ?></small>
                <?php endif; ?>
                <div style="margin-bottom: 15px;">
                    <input class="form-control" type="password" name="password" placeholder="Password"
                        style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                </div>
                <?php if (!empty($errors['password'])): ?>
                    <small class="error"><?= $errors['password'] ?></small>
                <?php endif; ?>

                <div style="margin-bottom: 15px;">
                    <input class="form-control" type="password" name="confirm_password" placeholder="Confirm Password"
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