<link rel="stylesheet" href="<?= base_url(); ?>/css/settings.css" />
<div id="settings-app">
    <main class="main">
        <h1 class="user-nick"><?= $nick ?> settings</h1>
        <div class="settings-block">
            <div class="option">
                <label for="hiddenEmail" class="option-label">Hidden Email</label>
                <input v-model="settings.is_hidden_email" type="checkbox" class="option-check" id="hiddenEmail"/>
            </div>
            <div class="option">
                <label for="hiddenPhone" class="option-label">Hidden Phone</label>
                <input v-model="settings.is_hidden_phone" value="true" type="checkbox" class="option-check" id="hiddenPhone"/>
            </div>
            <div class="option">
                <label for="sendNotif" class="option-label">Send Notifications</label>
                <input v-model="settings.is_send_notifications" type="checkbox" class="option-check" id="sendNotif"/>
            </div>
        </div>
        <div :style="messageStyle" class="accept-message">{{ acceptMessage }}</div>
        <button @click="acceptSettings()" class="default-button">Accept</button>
    </main>
</div>
<script>
    const baseUrl = "<?= base_url(); ?>"
</script>
<script src="<?= base_url(); ?>/js/vue.min.js"></script>
<script src="<?= base_url(); ?>/js/settings.js"></script>