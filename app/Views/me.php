<link rel="stylesheet" href="<?= base_url(); ?>/css/me.css" />
<div id="me-app">
    <main class="main">
        <section class="user-block">
            <div class="user-info">
                <div class="image-user">
                    <img src="<?= $user_image; ?>" alt="user image" />
                    <div class="counter-describers"></div>
                </div>
                <div class="user-detail">
                    <h2 class="user-nick"><?= $user_nick; ?></h2>
                    <div class="user-desc"><?= $user_desc; ?></div>
                    <button class="default-button" id="writeButton">Write</button>
                </div>
            </div>
            <div class="user-manage">
                <button class="default-button">Describe</button>
            </div>
        </section>
        <section class="posts-block">
            <div class="counter-posts">{{ countPosts }} Posts</div>
            <div class="posts-container">
                <div v-for="post in posts" class="post">
                    <div class="image-post"><img v-bind:src="post.path_image" alt="image of post" /></div>
                    <div class="author-block">
                        <div class="avatar"></div>
                        <div class="date-publish"></div>
                        <div class="nickname"></div>
                    </div>
                    <div class="post-info">
                        <h3 class="title-post">{{ post.title }}</h3>
                        <div class="rating-line"></div>
                        <div class="text-post">{{ post.text_post }}</div>
                        <div class="count-comments">comments</div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script>
        const baseUrl = "<?= base_url(); ?>"
        const user = "<?= $user_nick ?>"
    </script>
</div>
<script src="<?= base_url(); ?>/js/vue.min.js"></script>
<script src="<?= base_url(); ?>/js/me.js"></script>