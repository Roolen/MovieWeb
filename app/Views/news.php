<link rel="stylesheet" href="<?= base_url(); ?>/css/news.css" />
<div id="news-app">
    <main class="main">
        <div v-if="posts.length < 1" class="empty-news">Новостей нет</div>
        <div class="posts-container">
            <div v-for="post in posts" class="post">
                <?=
                    view('Templates/postBlock', ['user_image' => "post.authorAvatar",
                                                 'user_nick' => '{{ post.author }}',
                                                 'date_publish' => '{{ post.date_publish }}',
                                                 'path_image' => 'post.path_image',
                                                 'isImage' => $isImage,
                                                 'title' => '{{ post.title }}',
                                                 'text' => '{{ post.text_post }}',
                                                 'comments' => "comments",
                                                 'adress' => '\''.base_url().'/post/\''.' + post.title',
                                                 'address_user' => '\''.base_url().'/me/\''.' + post.author']);
                ?>
            </div>
        </div>
    </main>
</div>
<script src="<?= base_url(); ?>/js/vue.min.js"></script>
<script src="<?= base_url(); ?>/js/news.js"></script>