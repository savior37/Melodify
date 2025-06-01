<!--start music card-->
<div class="music-card-full" style="max-width: 800px;">
    
    <h2 class="card-title"><?= esc($row['name']) ?></h2>

    <center>
        
        <div style="">
            <img src="<?= ROOT ?>/<?= $row['image'] ?>">
        </div>
    </center>
    <div class="card-content">    

        <div class="card-meta">
            <span class="play-count">3.2M plays</span>
            <span class="card-badge">Popular</span>
        </div>

        <div><?=esc($row['bio'])?></div>

        <div>Artist Songs:</div>
        <div style="display: flex;flex-wrap: wrap;justify-content: center;">
            <?php

                $query = "select * from songs where artist_id = :artist_id order by views desc limit 20";
                $songs = db_query($query,['artist_id'=>$row['id']]);
            ?>
            <?php if (!empty($songs)): ?>
                <?php foreach ($songs as $row): ?>
                    <?php include page('includes/song') ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>