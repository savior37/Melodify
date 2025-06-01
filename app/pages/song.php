<?php require page('includes/header') ?>

<main class="content">
    <!-- Featured Tracks Section -->
    <section class="content">
        <center>
            <div class="section-title">Now Playing
            </div>


            <div class="content">
                <?php
                $slug = $URL[1] ?? null;
                $query = "SELECT * FROM songs WHERE slug = ? LIMIT 1";
                $row = db_query_one($query, [$slug]);
                ?>
                <?php if (!empty($row)): ?>
                    <?php include page('song-full') ?>
                <?php endif; ?>
            </div>
        </center>
    </section>
</main>
<?php require page('includes/footer') ?>