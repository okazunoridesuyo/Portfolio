<?php get_header(); ?>

<main id="stream" class="single">
    <?php if (have_posts()): ?>
        <?php while (have_posts()): the_post(); ?>
            <div class="inner">

                <h1 class="title">
                    <?php the_title(); ?>
                </h1>

                <?php $stream_img = get_post_meta(get_the_ID(), 'stream_img', true); ?>
                <?php if ($stream_img): ?>
                    <div class="stream__img_area">
                        <img class="" src="<?php echo $stream_img; ?>" alt="">
                        <a href="<?php echo $stream_img; ?>" target="_blank"></a>
                    </div>
                <?php endif; ?>

                <?php
                $stream_content = get_post_meta(get_the_ID(), 'stream_content', true);
                $file_info = wp_check_filetype($stream_content);
                $file_name = basename($stream_content);
                ?>
                <?php if ($stream_content): ?>
                    <div class="stream__play_area">
                        <?php if (str_contains($file_info['type'], 'audio')): ?>
                            <audio class="stream__play_area--audio" src="<?php echo $stream_content; ?>" controls controlslist="nodownload" playsinline></audio>
                        <?php elseif (str_contains($file_info['type'], 'video')): ?>
                            <video class="stream__play_area--video" src="<?php echo $stream_content; ?>" controls playsinline></video>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php $stream_lyric = get_post_meta(get_the_ID(), 'stream_lyric', true); ?>
                <?php if ($stream_lyric): ?>
                    <div class="stream__lyric">
                        <p><span class="index">作詞： </span><?php echo $stream_lyric; ?></p>
                    </div>
                <?php endif; ?>

                <?php $stream_music = get_post_meta(get_the_ID(), 'stream_music', true); ?>
                <?php if ($stream_music): ?>
                    <div class="stream__music">
                        <p><span class="index">作曲： </span><?php echo $stream_music; ?></p>
                    </div>
                <?php endif; ?>

                <?php $stream_arrangement = get_post_meta(get_the_ID(), 'stream_arrangement', true); ?>
                <?php if ($stream_arrangement): ?>
                    <div class="stream__arrangement">
                        <p><span class="index">編曲： </span><?php echo $stream_arrangement; ?></p>
                    </div>
                <?php endif; ?>

                <?php $stream_edit = get_post_meta(get_the_ID(), 'stream_edit', true); ?>
                <?php if ($stream_edit): ?>
                    <div class="stream__edit">
                        <p><span class="index">編集： </span><?php echo $stream_edit; ?></p>
                    </div>
                <?php endif; ?>

                <?php $stream_genre = get_the_terms(get_the_ID(), 'media_genre'); ?>
                <?php if ($stream_genre): ?>
                    <div class="stream__genre">
                        <span class="index">ジャンル： </span>
                        <?php foreach ($stream_genre as $genre): ?>
                            <span class="stream__genre--item">
                                <?php echo $genre->name; ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php $stream_detail = get_post_meta(get_the_ID(), 'stream_detail', true); ?>
                <?php if ($stream_detail): ?>
                    <div class="stream__detail">
                        <p><span class="index">詳細： </span></p>
                        <p><?php echo nl2br($stream_detail); ?></p>
                    </div>
                <?php endif; ?>

                <?php $stream_lyrics_text = get_post_meta(get_the_ID(), 'stream_lyrics_text', true); ?>
                <?php if ($stream_lyrics_text): ?>
                    <div class="stream__lyrics_text">
                        <p><span class="index">歌詞： </span></p>
                        <p><?php echo nl2br($stream_lyrics_text); ?></p>
                    </div>
                <?php endif; ?>

                <?php if (get_the_content()): ?>
                    <div class="the_content">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>