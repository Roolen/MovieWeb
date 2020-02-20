<link rel="stylesheet" href="<?= base_url(); ?>/css/me.css" />
<div id="me-app">
    <main class="main">
        <section class="user-block">
            <div class="user-info">
                <div class="image-user">
                    <img src="<?= $user_image; ?>" :class="{'default-image':!isAvatar}" alt="user image" />
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
                    <button v-if="!isSubscribe" @click="subscribe()" class="default-button sub-icon">Subscribe</button>
                    <button v-else @click="describe()" class="default-button unsub-icon">Describe</button>
                <?php else : ?>
                    <label for="fileInput" class="default-button image-icon">Change Image</label>
                    <input @change="changeImage" id="fileInput" class="file-input" type="file" accept=".jpg, .jpeg, .png" />
                    <button @click="addPost()" class="default-button">Add Post</button>
                <?php endif ?>
            </div>
        </section>
        <section v-bind:class="{ 'line-top': countPosts }" class="posts-block">
            <div class="counter-posts">{{ countPosts }} Posts</div>
            <div class="posts-container">
                <div v-for="post in posts" class="post">
                    
                    <?=
                        view('Templates/postBlock', ['user_image' => '\''.$user_image.'\'',
                                                     'user_nick' => $user_nick,
                                                     'date_publish' => "{{ post.date_publish }}",
                                                     'path_image' => "post.path_image",
                                                     'isImage' => "post.isImage",
                                                     'title' => "{{ post.title }}",
                                                     'text' => "{{ post.text_post }}",
                                                     'comments' => "comments",
                                                     'adress' => 'post.address',
                                                     'address_user' => '\''.base_url().'/me/'.$user_nick.'\'']);
                    ?>
                </div>
            </div>
        </section>
    </main>
    <script>
        const baseUrl = "<?= base_url(); ?>"
        const user = "<?= $user_nick ?>"
        const description = "<?= $user_desc; ?>"
        const isAvatar = <?= ($isAvatar)?1:0 ?>
    </script>
</div>
<script src="<?= base_url(); ?>/js/vue.min.js"></script>
<script src="<?= base_url(); ?>/js/me.js"></script>