<div class="music-card-full" style="max-width: 800px;">
    <center>
        <h3 class="card-title"><?= esc($row['title']) ?></h3>
        <div style="">
            <a href="<?= ROOT ?>/song/<?= $row['slug'] ?>"><img src="<?= ROOT ?>/<?= $row['image'] ?>"></a>
        </div>
    </center>
    <div class="card-content">
        <p class="card-subtitle"><?= esc(get_artist($row['artist_id'])) ?></p>
        <div class="card-meta">
            <span class="play-count">3.2M plays</span>
            <span class="card-badge">Popular</span>
        </div>
    </div>
</div>