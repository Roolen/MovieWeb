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
                    <button class="default-button">Describe</button>
                <?php else : ?>
                    <button class="default-button">Change Image</button>
                <?php endif ?>
            </div>
        </section>
        <section v-bind:class="{ 'line-top': countPosts }" class="posts-block">
            <div class="counter-posts">{{ countPosts }} Posts</div>
            <div class="posts-container">
                <div v-for="post in posts" class="post">
                    <div class="image-post"><img v-bind:src="post.path_image" alt="image of post" /></div>
                    <?=
                        view('Templates/authorBlock', ['user_image' => $user_image,
                                                       'user_nick' => $user_nick,
                                                       'date_publish' => "{{ post.date_publish }}"]);
                    ?>
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
        const description = "<?= $user_desc; ?>"
    </script>
</div>
<script src="<?= base_url(); ?>/js/vue.min.js"></script>
<script src="<?= base_url(); ?>/js/me.js"></script>