<link rel="stylesheet" href="<?= base_url(); ?>/css/write.css"/>
<div id="write-app">
    <main class="main">
        <h2 class="title-label">Новая статья</h2>
        <input v-model="title" type="text" class="default-field title-field" placeholder="Заголовок">
        <h2 class="text-label">Текст</h2>
        <textarea v-model="text" class="text-field" placeholder="Напишите текст поста..." required></textarea>
        <input v-model="tags" type="text" class="default-field tag-field" placeholder="Тэги">
        <div class="tag-message">Тэги пишуться через запятую</div>
        <label for="file-input" class="default-button add-image">Добавить изображение</label>
        <input @change="changeImage" class="file-input" id="file-input" type="file" accept=".jpg, .png, .jpeg" />
        <div :style="messageStyle" class="message-publish">{{ messagePublish }}</div>
        <button @click="createPost()" class="default-button publish-button">Опубликовать</button>
    </main>
</div>
<script>
    const baseUrl = "<?= base_url(); ?>"
</script>
<script src="<?= base_url(); ?>/js/vue.min.js"></script>
<script src="<?= base_url(); ?>/js/write.js"></script>