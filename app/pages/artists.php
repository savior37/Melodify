<?php require page('includes/header') ?>

<main class="container">
    <!-- Featured Tracks Section -->
    <section class="content-section">
        <div class="section-header">
            <h2 class="section-title">Music</h2>
        </div>

        <div class="music-grid">
            <?php
            $rows = db_query("select * from artists order by id desc limit 24");
            ?>
            <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $row): ?>
                    <?php include page('includes/artist') ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php require page('includes/footer') ?>