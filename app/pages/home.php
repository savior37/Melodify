<?php require page('includes/header') ?>

<!-- Hero Section -->
<section class="hero-section">
    <img class="hero-image" src="<?= ROOT ?>/assets/images/kaset.jpg" alt="Music collection background">
    <div class="hero-overlay">
        <div class="hero-content">
            <h1 class="hero-title">Your Music Journey Starts Here</h1>
            <p class="hero-subtitle">Discover, explore, and enjoy thousands of tracks in one place</p>
            <a href="trending.html" class="hero-btn">Explore Trending</a>
        </div>
    </div>
</section>

<main class="container">
    <!-- Featured Tracks Section -->
    <section class="content-section">
        <div class="section-header">
            <h2 class="section-title">Featured Tracks</h2>
            <a href="featured.html" class="view-all">View All</a>
        </div>

        <div class="music-grid">
            <?php
            $rows = db_query("select * from songs where featured = 1 order by id desc limit 16");
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