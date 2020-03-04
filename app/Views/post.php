<link rel="stylesheet" href="<?= base_url(); ?>/css/post.css"/>
<div id="post-app">
    <main class="main">
        <header class="header-post">
            <div class="image-post"><img :class="{'default-image':isPostImage}" src="<?= $image ?>" alt="Post image"/></div>
                <?=
                    view('Templates/authorBlock', ['user_image' => '\''.$imageAuthor.'\'',
                                                   'user_nick' => $nickAuthor,
                                                   'date_publish' => "{{ formatDate(\"".$date."\") }}",
                                                   'address_user' => '\''.base_url().'/me/'.$nickAuthor.'\'']);
                ?>
            <div class="tags-block"><?= implode(", ", $tags) ?></div>
            <div class="title-post"><?= $title ?></div>
            <?php if ($isAuthor) : ?>
                <button @click="editPost()" class="default-button edit-button">Изменить</button>
            <?php endif ?>
        </header>
        <section class="post">
            <div class="text-post"><?= $text ?></div>
            <div class="rating-button"></div>
        </section>
        <section class="comments-block">
            <div class="counter-comments">{{ countComments }} Комментариев</div>
            <div v-for="comment in comments" class="comment">
                <header class="comment-head">
                    <div class="avatar"><img :src="comment.avatar" alt="avatar"/></div>
                    <div class="info">
                        <div class="nick">{{ comment.author }}</div>
                        <div class="rating">{{ comment.rating }}<div class="rating-buttons"></div></div>
                    </div>
                </header>
                <div class="text-comment">{{ comment.text_comment }}</div>
            </div>
            <?php if (session()->has('isAuth')) : ?>
            <button v-if="!isEditComment" @click="isEditComment = !isEditComment" class="default-button">Написать комментарий</button>
            <?php endif ?>
            <div v-if="isEditComment" class="edit-comment-block">
                <div class="label-edit-comment">Напишите комментарий</div>
                <textarea @keyup="resizeField()" v-model="textComment" id="commentField" class="comment-field"></textarea>
                <button @click="writeComment()" class="default-button">Отправить</button>
            </div>
        </section>
    </main>
    <script>
        const baseUrl = "<?= base_url(); ?>"
        const title = "<?= $title ?>"
        const _isImage = <?= ($isImage)?1:0 ?>
    </script>
</div>
<script src="<?= base_url(); ?>/js/vue.min.js"></script>
<script src="<?= base_url(); ?>/js/post.js"></script>