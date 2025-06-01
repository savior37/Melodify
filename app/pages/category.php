<?php require page('includes/header') ?>

<main class="container">
    <!-- Featured Tracks Section -->
    <section class="content-section">
        <div class="section-header">
            <h2 class="section-title">Category</h2>
        </div>

        <div class="music-grid">
            <?php
                $category = $URL[1] ?? null; 
                $query = "select * from songs where category_id in (select id from categories where category = :category) order by views desc limit 24"; 

                $rows = db_query($query,['category'=>$category]);
            ?>
            <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $row): ?>
                    <?php include page('includes/song') ?>
                <?php endforeach; ?>
            <?php else:?>
                    <div class="m-2">No songs found</div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php require page('includes/footer') ?>