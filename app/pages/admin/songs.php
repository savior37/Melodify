<?php

if ($action == 'add') {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $errors = [];

        //data validation
        if (empty($_POST['title'])) {
            $errors['title'] = "a title is required";
        } else
            if (!preg_match("/^[a-zA-Z0-9 \'\.\&\-]+$/", $_POST['title'])) {
                $errors['title'] = "a title can only letters & spaces";
            }

        // Validate category_id - FIXED: Made it required
        if (empty($_POST['category_id'])) {
            $errors['category_id'] = "a category is required";
        } else if (!is_numeric($_POST['category_id'])) {
            $errors['category_id'] = "Please select a valid category";
        }

        // Validate artist_id - FIXED: Made it required
        if (empty($_POST['artist_id'])) {
            $errors['artist_id'] = "an artist is required";
        } else if (!is_numeric($_POST['artist_id'])) {
            $errors['artist_id'] = "Please select a valid artist";
        }

        $destination = ''; // Initialize destination variable
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

        $destination_file = ''; // Initialize destination_file variable
        //audio file
        if (!empty($_FILES['file']['name'])) {

            $folder = "uploads/";
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
                file_put_contents($folder . "index.php", "");
            }

            $allowed = ['audio/mpeg', 'audio/mp3', 'audio/wav'];

            if ($_FILES['file']['error'] == 0 && in_array($_FILES['file']['type'], $allowed)) {
                $destination_file = $folder . $_FILES['file']['name']; // Fixed variable name

                move_uploaded_file($_FILES['file']['tmp_name'], $destination_file);

            } else {
                $errors['file'] = "file not valid. Allowed types are " . implode(",", $allowed);
            }
        } else {
            $errors["file"] = "an audio file is required";
        }

        if (empty($errors)) {

            $values = [];
            $values['title'] = trim($_POST['title']);
            $values['image'] = $destination;
            $values['file'] = $destination_file;
            $values['user_id'] = user('id');
            $values['date'] = date("Y-m-d H:i:s");
            $values['views'] = 0;
            $values['slug'] = str_to_url($values['title']);
            $values['category_id'] = $_POST['category_id'];
            $values['artist_id'] = $_POST['artist_id'];

            // Build query - Fixed: Removed duplicate file handling
            $fields = ['title', 'image', 'file', 'user_id', 'category_id', 'artist_id', 'date', 'views', 'slug'];
            $placeholders = [':title', ':image', ':file', ':user_id', ':category_id', ':artist_id', ':date', ':views', ':slug'];

            $query = "insert into songs (" . implode(',', $fields) . ") values (" . implode(',', $placeholders) . ")";
            db_query($query, $values);

            message("song created successfully");
            redirect('admin/songs');
        }
    }
} else if ($action == 'edit') {

    $query = "select * from songs where id = :id limit 1";
    $row = db_query_one($query, ['id' => $id]);

    if ($_SERVER['REQUEST_METHOD'] == "POST" && $row) {

        $errors = [];

        //data validation
        if (empty($_POST['title'])) {
            $errors['title'] = "a title is required";
        } else
            if (!preg_match("/^[a-zA-Z0-9 \'\.\&\-]+$/", $_POST['title'])) {
                $errors['title'] = "a title can only letters & spaces";
            }

        // Validate category_id - FIXED: Made it required
        if (empty($_POST['category_id'])) {
            $errors['category_id'] = "a category is required";
        } else if (!is_numeric($_POST['category_id'])) {
            $errors['category_id'] = "Please select a valid category";
        }

        // Validate artist_id - FIXED: Made it required
        if (empty($_POST['artist_id'])) {
            $errors['artist_id'] = "an artist is required";
        } else if (!is_numeric($_POST['artist_id'])) {
            $errors['artist_id'] = "Please select a valid artist";
        }

        //image handling for edit
        $destination_image = '';
        if (!empty($_FILES['image']['name'])) {
            $folder = "uploads/";
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
                file_put_contents($folder . "index.php", "");
            }

            $allowed = ['image/jpeg', 'image/png'];

            if ($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed)) {
                $destination_image = $folder . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], $destination_image);

                //delete old image
                if (file_exists($row['image'])) {
                    unlink($row['image']);
                }
            } else {
                $errors['image'] = "image not valid. Allowed types are " . implode(",", $allowed);
            }
        }

        //audio file handling for edit
        $destination_file = '';
        if (!empty($_FILES['file']['name'])) {
            $folder = "uploads/";
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
                file_put_contents($folder . "index.php", "");
            }

            $allowed = ['audio/mpeg', 'audio/mp3', 'audio/wav']; // Fixed: Changed from 'file/jpeg' to proper audio types
            if ($_FILES['file']['error'] == 0 && in_array($_FILES['file']['type'], $allowed)) {
                $destination_file = $folder . $_FILES['file']['name'];

                move_uploaded_file($_FILES['file']['tmp_name'], $destination_file);

                //delete old file
                if (file_exists($row['file'])) {
                    unlink($row['file']);
                }
            } else {
                $errors['file'] = "file not valid. allowed types are " . implode(",", $allowed); // Fixed: Changed 'name' to 'file'
            }
        }

        if (empty($errors)) {
            $values = [];
            $values['title'] = trim($_POST['title']);
            $values['category_id'] = trim($_POST['category_id']);
            $values['artist_id'] = trim($_POST['artist_id']);
            $values['user_id'] = user('id');
            $values['id'] = $id;

            $query = "update songs set title = :title, user_id = :user_id, category_id = :category_id, artist_id = :artist_id";

            if (!empty($destination_image)) {
                $query .= ", image = :image";
                $values['image'] = $destination_image;
            }

            if (!empty($destination_file)) {
                $query .= ", file = :file";
                $values['file'] = $destination_file;
            }

            $query .= " where id = :id limit 1";

            db_query($query, $values);

            message("song edited successfully");
            redirect('admin/songs');
        }
    }
} else if ($action == 'delete') {

    $query = "select * from songs where id = :id limit 1";
    $row = db_query_one($query, ['id' => $id]);

    if ($_SERVER['REQUEST_METHOD'] == "POST" && $row) {

        $errors = [];

        if (empty($errors)) {

            $values = [];
            $values['id'] = $id;
            $query = "delete from songs where id = :id limit 1";
            db_query($query, $values);

            //delete image
            if (file_exists($row['image'])) {
                unlink($row['image']);
            }

            //delete audio file
            if (file_exists($row['file'])) {
                unlink($row['file']);
            }

            message("songs deleted successfully");
            redirect('admin/songs');
        }
    }
}

?>
<?php require page('includes/admin-header') ?>

<section class="admin-content" style="min-height: 200px;">
    <?php if (isset($action) && $action == 'add'): ?>
        <div style="max-width: 500px; margin: auto">
            <form method="post" enctype="multipart/form-data">

                <h3>Add New Song</h3>

                <div style="margin-bottom: 15px;">
                    <input name="title" class="form-control" value="<?= set_value('title') ?>" type="text"
                        placeholder="song title" style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                    <?php if (!empty($errors['title'])): ?>
                        <small class="error"><?= $errors['title'] ?></small>
                    <?php endif; ?>
                </div>

                <?php
                // Query untuk mengambil data kategori dari database dengan error handling
                $query = "select * from categories order by category asc";
                $categories = db_query($query);
                ?>

                <select name="category_id" class="form-control my-1">
                    <option value="">--Select Category--</option>

                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <option <?= set_select('category_id', $cat['id']) ?> value="<?= $cat['id'] ?>"><?= $cat['category'] ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <?php if (!empty($errors['category_id'])): ?>
                    <small class="error"><?= $errors['category_id'] ?></small>
                <?php endif; ?>

                <?php
                // Query untuk mengambil data artist dari database dengan error handling
                $query = "select * from artists order by name asc";
                $artist = db_query($query);
                ?>
                <div style="margin-bottom: 15px;">
                    <select name="artist_id" class="form-control my-1"
                        style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                        <option value="">--Select Artist--</option>
                        <?php if (!empty($artist)): ?>
                            <?php foreach ($artist as $cat): ?>
                                <option <?= set_select('artist_id', $cat['id']) ?> value="<?= $cat['id'] ?>"><?= $cat['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>

                    <?php if (!empty($errors['artist_id'])): ?>
                        <small class="error"><?= $errors['artist_id'] ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-control my-1">
                    <div>Image:</div>
                    <input class="form-control my-1" type="file" name="image">

                    <?php if (!empty($errors['image'])): ?>
                        <small class="error"><?= $errors['image'] ?></small>
                    <?php endif; ?>

                </div>

                <div class="form-control my-1">
                    <div>Audio:</div>
                    <input class="form-control my-1" type="file" name="file">
                    <?php if (!empty($errors['file'])): ?>
                        <small class="error"><?= $errors['file'] ?></small>
                    <?php endif; ?>
                </div>

                <button class="btn bg-orange" type="submit" style="border-radius: 6px; padding: 8px 16px;">Create</button>
                <a href="<?= ROOT ?>/admin/songs">
                    <button type="button" class="float-end btn" style="border-radius: 6px; padding: 8px 16px;">Back</button>
                </a>
            </form>
        </div>
    <?php elseif (isset($action) && $action == 'edit'): ?>
        <div style="max-width: 500px; margin: auto">
            <form method="post" enctype="multipart/form-data">
                <h3>Edit Song</h3>

                <?php if (!empty($row)): ?>
                    <div style="margin-bottom: 15px;">
                        <input class="form-control" value="<?= set_value('title', $row['title']) ?>" type="text" name="title"
                            placeholder="song title" style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                        <?php if (!empty($errors['title'])): ?>
                            <small class="error"><?= $errors['title'] ?></small>
                        <?php endif; ?>
                    </div>

                    <?php
                    // Query untuk mengambil data kategori dari database dengan error handling
                    $query = "select * from categories order by category asc";
                    $categories = db_query($query);
                    ?>

                    <select name="category_id" class="form-control my-1">
                        <option value="">--Select Category--</option>

                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <option <?= set_select('category_id', $cat['id'], $row['category_id']) ?> value="<?= $cat['id'] ?>">
                                    <?= $cat['category'] ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <?php if (!empty($errors['category_id'])): ?>
                        <small class="error"><?= $errors['category_id'] ?></small>
                    <?php endif; ?>

                    <?php
                    // Query untuk mengambil data artist dari database dengan error handling
                    $query = "select * from artists order by name asc";
                    $artist = db_query($query);
                    ?>
                    <div style="margin-bottom: 15px;">
                        <select name="artist_id" class="form-control my-1"
                            style="width: 100%; border-radius: 6px; padding: 8px 12px;">
                            <option value="">--Select Artist--</option>
                            <?php if (!empty($artist)): ?>
                                <?php foreach ($artist as $art): ?>
                                    <option <?= set_select('artist_id', $art['id'], $row['artist_id']) ?> value="<?= $art['id'] ?>">
                                        <?= $art['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>

                        <?php if (!empty($errors['artist_id'])): ?>
                            <small class="error"><?= $errors['artist_id'] ?></small>
                        <?php endif; ?>
                    </div>

                    <img src="<?= ROOT ?>/<?= $row['image'] ?>" style="width:200px;height: 200px;object-fit: cover;">

                    <input class="form-control" type="file" name="image">
                    <?php if (!empty($errors['image'])): ?>
                        <small class="error"><?= $errors['image'] ?></small>
                    <?php endif; ?>

                    <div class="form-control my-1">
                        <div>Audio:</div>
                        <div><?= $row['file'] ?></div>
                        <input class="form-control my-1" type="file" name="file">
                        <?php if (!empty($errors['file'])): ?>
                            <small class="error"><?= $errors['file'] ?></small>
                        <?php endif; ?>
                    </div>

                    <button class="btn bg-orange" type="submit" style="border-radius: 6px; padding: 8px 16px;">Update</button>
                    <a href="<?= ROOT ?>/admin/songs">
                        <button type="button" class="float-end btn" style="border-radius: 6px; padding: 8px 16px;">Back</button>
                    </a>
                <?php else: ?>
                    <div class="alert">That record was not found</div>
                    <a href="<?= ROOT ?>/admin/songs">
                        <button type="button" class="float-end btn" style="border-radius: 6px; padding: 8px 16px;">Back</button>
                    </a>
                <?php endif; ?>
            </form>
        </div>

    <?php elseif (isset($action) && $action == 'delete'): ?>

        <div style="max-width: 500px; margin: auto">
            <form method="post">
                <h3>Delete Song</h3>
                <?php if (!empty($row)): ?>
                    <div style="margin-bottom: 15px;">
                        <div class="form-control"><?= set_value('title', $row['title']) ?></div>
                        <?php if (!empty($errors['title'])): ?>
                            <small class="error"><?= $errors['title'] ?></small>
                        <?php endif; ?>
                    </div>

                    <button class="btn bg-red" type="submit" style="border-radius: 6px; padding: 8px 16px;">Delete</button>
                    <a href="<?= ROOT ?>/admin/songs">
                        <button type="button" class="float-end btn" style="border-radius: 6px; padding: 8px 16px;">Back</button>
                    </a>
                <?php else: ?>
                    <div class="alert">That record was not found</div>
                    <a href="<?= ROOT ?>/admin/songs">
                        <button type="button" class="float-end btn" style="border-radius: 6px; padding: 8px 16px;">Back</button>
                    </a>
                <?php endif; ?>
            </form>
        </div>  
    <?php else: ?>

        <?php
            $limit  = 20;
            $offset = ($page - 1) * $limit;

            $query = "select * from songs order by id asc limit $limit offset $offset";
            $rows = db_query($query);
        ?>

        <h3>Song
            <a href="<?= ROOT ?>/admin/songs/add">
                <button class="float-end btn bg-purple" style="border-radius: 6px; padding: 8px 16px;">Add New</button>
            </a>
        </h3>

        <table class="table">

            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Image</th>
                <th>Category</th>
                <th>Artist</th>
                <th>Audio</th>
                <th>Action</th>
            </tr>

            <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['title'] ?></td>
                        <td><img src="<?= ROOT ?>/<?= $row['image'] ?>" style="width:100px;height: 100px;object-fit: cover;"></td>
                        <td><?= get_category($row['category_id']) ?></td>
                        <td><?= get_artist($row['artist_id']) ?></td>
                        <td>
                            <?php if (!empty($row['file'])): ?>
                                <audio controls>
                                    <source src="<?= ROOT ?>/<?= $row['file'] ?>" type="audio/mpeg">
                                </audio>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= ROOT ?>/admin/songs/edit/<?= $row['id'] ?>">
                                <img class="bi" src="<?= ROOT ?>/assets/icons/pencil-square.svg">
                            </a>
                            <a href="<?= ROOT ?>/admin/songs/delete/<?= $row['id'] ?>">
                                <img class="bi" src="<?= ROOT ?>/assets/icons/trash3.svg">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

        </table>
    <?php endif; ?>

    <div class="mx-2">
        <a href="<?=ROOT?>/admin/songs?page=<?=$prev_page?>">
            <button class="btn bg-orange">Prev</button>
        </a>
        <a href="<?=ROOT?>/admin/songs?page=<?=$next_page?>">
            <button class="float-end btn bg-orange">Next</button>
        </a>
    </div>

</section>
<?php require page('includes/admin-footer') ?>