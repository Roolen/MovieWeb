<link rel="stylesheet" href="<?= base_url(); ?>/css/me.css" />
<div id="me-app">
    <main class="main">
        <section class="user-block">
            <div class="user-info">
                <div class="image-user">
                    <img src="<?= $user_image; ?>" alt="user image" />
                    <div class="counter-describers">
                        <div class="count">{{ countSubs }}</div>
                        <div class="subscribers">Subscribers</div>
                    </div>
                </div>
                <div class="user-detail">
                    <h2 class="user-nick"><?= $user_nick; ?></h2>
                    <textarea v-if="isEditDesc" class="user-desc" v-model="description" maxlength="451" required></textarea>
                    <div v-if="!isEditDesc" class="user-desc">{{ description }}</div>
                    <?php if (! $isYou) : ?>
                        <button class="default-button write-icon" id="writeButton">Write</button>
                    <?php else : ?>
                        <button v-if="!isEditDesc" @click="isEditDesc = true"
                         class="default-button desc-icon">Change Description</button>
                        <button v-else @click="changeDesc()" class="default-button desc-icon">Apply</button>
                    <?php endif ?>
                </div>
            </div>
            <div class="user-manage">
                <?php if (! $isYou) : ?>
                    <button v-if="!isSubscribe" @click="subscribe()" class="default-button">Subscribe</button>
                    <button v-else class="default-button">Describe</button>
                <?php else : ?>
                    <button class="default-button">Change Image</button>
                <?php endif ?>
            </div>
        </section>
        <section v-bind:class="{ 'line-top': countPosts }" class="posts-block">
            <div class="counter-posts">{{ countPosts }} Posts</div>
            <div class="posts-container">
                <div v-for="post in posts" class="post">
                    <?=
                        view('Templates/postBlock', ['user_image' => $user_image,
                                                     'user_nick' => $user_nick,
                                                     'date_publish' => "{{ post.date_publish }}",
                                                     'path_image' => "post.path_image",
                                                     'title' => "{{ post.title }}",
                                                     'text' => "{{ post.text_post }}",
                                                     'comments' => "comments",
                                                     'adress' => '\''.base_url().'/post/\''.' + post.title']);
                    ?>
                </div>
            </div>
        </section>
    </main>
    <script>
        const baseUrl = "<?= base_url(); ?>"
        const user = "<?= $user_nick ?>"
        const description = "<?= $user_desc; ?>"
    </script>
</div>
<script src="<?= base_url(); ?>/js/vue.min.js"></script>
<script src="<?= base_url(); ?>/js/me.js"></script>