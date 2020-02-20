<a :href="<?= $adress; ?>">
    <div class="image-post">
        <img v-bind:class="{'default-image':!<?= $isImage ?>}" v-bind:src="<?= $path_image ?>" alt="image of post" />
    </div>
        <?=
            view('Templates/authorBlock', ['user_image' => $user_image,
                                           'user_nick' => $user_nick,
                                           'date_publish' => $date_publish]);
        ?>
    <div class="post-info">
        <h3 class="title-post"><a :href="<?= $adress; ?>"><?= $title ?></a></h3>
        <div class="rating-line"></div>
        <div class="text-post"><?= $text ?></div>
        <div class="count-comments"><?= $comments ?></div>
    </div>
</a>