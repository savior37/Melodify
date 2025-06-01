<div class="music-card" style="max-width: 800px;">
    <div class="card-image-container">
        <a href="<?= ROOT ?>/artist/<?= $row['id'] ?>"><img src="<?= ROOT ?>/<?= $row['image'] ?>"></a>
    </div>
    <div class="card-content">
        <h3 class="card-title"><?=esc(ucwords($row['name'])) ?></h3>
        <p class="card-subtitle" style="font-size: 11px;"><?=esc(substr($row['bio'], 0, 50)) ?></p>
        <div class="card-meta">
            <span class="play-count">3.2M plays</span>
            <span class="card-badge">Popular</span>
        </div>
    </div>
</div>