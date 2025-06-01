<?php require page('includes/header') ?>

<main class="content">
    <!-- Featured Tracks Section -->
    <section class="content">
        <center>
            <div class="section-title">Artist Profile
            </div>


            <div class="content">
                <?php
                $id = $URL[1] ?? null;
                $query = "SELECT * FROM artists WHERE id = ? LIMIT 1";
                $row = db_query_one($query, [$id]);
                ?>
                <?php if (!empty($row)): ?>
                    <?php include page('artist-full') ?>
                <?php endif; ?>
            </div>
        </center>
    </section>
</main>
<?php require page('includes/footer') ?>