<div class="music-card" style="max-width: 800px;">
    <div class="card-image-container">
        <a href="<?= ROOT ?>/song/<?= $row['slug'] ?>"><img src="<?= ROOT ?>/<?= $row['image'] ?>"></a>
    </div>
    <div class="card-content">
        <h3 class="card-title"><?= esc($row['title']) ?></h3>
        <p class="card-subtitle"><?= esc(get_artist($row['artist_id'])) ?></p>
        <div class="card-meta">
            <span class="play-count">3.2M plays</span>
            <span class="card-badge">Popular</span>
        </div>
    </div>
</div>