<link rel="stylesheet" href="<?= base_url(); ?>/css/search.css" />
<div id="search-app">
    <main class="main">
        <div class="search-block">
            <input v-model="textSearch" type="text" class="default-field" placeholder="Введите слово..."/>
            <button @click="search()" class="default-button search-icon">Поиск</button>
            <div class="search-selector-block">
                <input v-model="typeSearch" value="0" type="radio" name="search-selector" id="selector-posts" class="selector-hidden">
                <label for="selector-posts" class="search-selector"></label>
                <label for="selector-posts" class="selector-label">Посты</label>

                <input v-model="typeSearch" value="1" type="radio" name="search-selector" id="selector-users" class="selector-hidden">
                <label for="selector-users" class="search-selector"></label>
                <label for="selector-users" class="selector-label">Пользователи</label>

                <input v-model="typeSearch" value="2" type="radio" name="search-selector" id="selector-desc" class="selector-hidden">
                <label for="selector-desc" class="search-selector"></label>
                <label for="selector-desc" class="selector-label">Текст</label>
            </div>
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
        <div class="users-block">
            <div v-for="user in users" class="user">
                <?= view('Templates/userBlock', ['nick' => "{{ user.nickname }}",
                                                 'avatar' => "user.avatar",
                                                 'isAvatar' => "user.isAvatar",
                                                 'email' => "{{ user.email }}",
                                                 'description' => "{{ user.description }}",
                                                 'url' => '\''.base_url().'/me/\''.' + user.nickname']);
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