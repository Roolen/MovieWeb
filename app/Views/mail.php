<link rel="stylesheet" href="<?= base_url(); ?>/css/mail.css" />
<div id="mail-app">
    <aside class="senders-block">
        <div @click="getMessages(sender.nickname)" v-for="sender in senders" class="sender">
            <div class="avatar"><img :src="sender.avatar" alt="avatar"/></div>
            <div class="nick">{{ sender.nickname }}</div>
        </div>
    </aside>
    <main class="main">
        <div v-if="!isMessages" class="empty-text">Нажмите на пользователя в меню слево</div>
        <div class="messages-block" id="messagesBlock">
            <div v-for="message in messages" :class="{'user-message':message.isUser}" class="message">
                <div class="nick">{{ nickSender(message.isUser) }}</div>
                <div class="text">{{ message.text }}</div>
                <div class="date">{{ message.date }}</div>
            </div>
        </div>
        <div v-if="isMessages" class="write-block">
            <textarea v-model="textMessage" type="text" class="edit-field"></textarea>
            <button @click="sendMessage()" class="default-button">Send</button>
        </div>
    </main>
</div>
<?php
    $user = new App\Libraries\User();
?>
<script>
    const baseUrl = "<?= base_url(); ?>"
    const userNick = "<?= $user->getNickname(); ?>"
</script>
<script src="<?= base_url(); ?>/js/vue.min.js"></script>
<script src="<?= base_url(); ?>/js/mail.js"></script>