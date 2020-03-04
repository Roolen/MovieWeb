<a :href="<?= $url; ?>">
    <div class="image-user"><img :class="{'default-image':!<?= $isAvatar; ?>}" :src="<?= $avatar; ?>" alt="avatar"/></div>
</a>
<div class="user-info">
    <a :href="<?= $url; ?>"><h2 class="title-user"><?= $nick; ?></h2></a>
    <div class="email-user"><?= $email; ?></div>
    <div class="description"><?= $description; ?></div>
</div>