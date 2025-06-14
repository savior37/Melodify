<?php require page('includes/header') ?>

<main class="container">
    <!-- Featured Tracks Section -->
    <section class="content-section">
        <div class="section-header">
            <h2 class="section-title">Music</h2>
        </div>

        <div class="music-grid">
            <?php
                $limit  = 20;
                $offset = ($page - 1) * $limit;
                

                $rows = db_query("select * from songs order by views desc limit $limit offset $offset");
            ?>
            <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $row): ?>
                    <?php include page('includes/song') ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
 
    </section>

    <div class="mx-2">
        <a href="<?=ROOT?>/music?page=<?=$prev_page?>">
            <button class="btn bg-orange">Prev</button>
        </a>
        <a href="<?=ROOT?>/music?page=<?=$next_page?>">
            <button class="float-end btn bg-orange">Next</button>
        </a>
    </div>
</main>
<?php require page('includes/footer') ?>