<link rel="stylesheet" href="<?= base_url(); ?>/css/search.css" />
<div id="search-app">
    <main class="main">
        <div class="search-block">
            <input v-model="textSearch" type="text" class="default-field" placeholder="Введите слово..."/>
            <button @click="searchPosts()" class="default-button search-icon">Search</button>
        </div>
        <div v-if="isLoad" class="load-screen"></div>
        <div v-if="!isFind" class="empty-text">Ничего не найдено</div>
        <div class="posts-block">
            <div v-for="post in posts" class="post">
                <?=
                    view('Templates/postBlock', ['user_image' => "post.authorAvatar",
                                                 'user_nick' => '{{ post.author }}',
                                                 'date_publish' => '{{ post.date_publish }}',
                                                 'path_image' => 'post.path_image',
                                                 'isImage' => 'post.isImage',
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
<script>
    const baseUrl = "<?= base_url(); ?>"
</script>
<script src="<?= base_url(); ?>/js/vue.min.js"></script>
<script src="<?= base_url(); ?>/js/search.js"></script>