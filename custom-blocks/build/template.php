<?php 
if($post_query->have_posts() ) {
    while($post_query->have_posts() ) {
        $post_query->the_post();
        $post_meta = get_fields(get_the_ID());
        ?>
        <h2>
            <a href="<?php the_permalink() ?>">
                <?php the_title(); ?>
            </a>
        </h2>
        <div>
            <?= get_the_post_thumbnail() ?>
        </div>
        <div>Autor: <?= $post_meta['picsum-photos_author'] ?></div>
        <div><a target="_blank" href="<?= $post_meta['picsum-photos_url'] ?>">PiscumPhotos link</a> </div>
        <br>
        <br>
        <hr>
        <br>
        <br>
    <?php
    }
}