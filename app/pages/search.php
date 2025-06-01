<?php require page('includes/header') ?>

<main class="container">
    <!-- Featured Tracks Section -->
    <section class="content-section">

    <div class="section-header">
            <h2 class="section-title">Searched for: <?=$_GET['find']?></h2>
        </div>

        <div class="music-grid">
            <?php
                $title = $_GET['find'] ?? null; 
                if(!empty($title)) {
                    
                    $title = "%$title%";
                    $query = "select * from songs where title like :title order by views desc limit 24"; 
                    $rows = db_query($query,['title'=>$title]);

                }
                
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