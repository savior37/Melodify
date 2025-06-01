<?php

    db_query("update songs set views = views + 1 where id = :id limit 1",['id'=>$row['id']]);
?>

<!--start music card-->
<div class="music-card-full" style="max-width: 800px;">
    
    <h2 class="card-title"><?= esc($row['title']) ?></h2>

    <center>
        
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
        <center>
            <audio controls style="width: 100%">
                <source src="<?= ROOT ?>/<?= $row['file'] ?>" type="audio/mpeg">
            </audio>
        </center>
        <div>Views: <?=$row['views']?></div>
        <div>Date added: <?=get_date($row['date'])?></div>

        <a href="<?=ROOT?>/download/<?=$row['slug']?>">
            <button class="btn bg-purple">Download</button>
        </a>
    </div>
</div>