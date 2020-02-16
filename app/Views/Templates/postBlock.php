<div class="image-post"><img v-bind:src="<?= $path_image ?>" alt="image of post" /></div>
    <?=
        view('Templates/authorBlock', ['user_image' => $user_image,
                                       'user_nick' => $user_nick,
                                       'date_publish' => $date_publish]);
    ?>
<div class="post-info">
    <h3 class="title-post"><?= $title ?></h3>
    <div class="rating-line"></div>
    <div class="text-post"><?= $text ?></div>
    <div class="count-comments"><?= $comments ?></div>
</div>