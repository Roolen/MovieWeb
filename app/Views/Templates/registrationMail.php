<style>
    .mail {
        padding: 10px;
        border-radius: 15px;
        background: #1B1D2A;
    }
    h1 {
        margin-bottom: 50px;
        font-family: 'Open Sans';
        font-size: 24px;
        color: #e9e9e9;
    }
    main {
        font-family: 'Roboto';
        font-size: 18px;
        color: #e9e9e9;
    }
    a, .mail .info-block .ref {
        color: #8f8fa5;
        text-decoration: none;
    }
    .footer {
        margin-top: 20px;
        font-family: 'Roboto';
        font-size: 16px;
        color: #e9e9e9;
    }
    .data-block {
        width: 30%;
        padding: 10px;
        border-radius: 10px;
        background: #e9e9e9;
    }
    .info-block {
        margin-top: 30px;
        color: #e9e9e9;
    }
</style>
<div class="mail">
    <h1>Здравствуйте, вы зарегистрировались на сате <a href="<?= base_url(); ?>">critics.fun</a>.</h1>
    <main>
        <div class="data-block">
            Ваш логин: <?= $nick; ?><br>
            Ваш пароль: <?= $password; ?>
        </div>
        <div class="info-block">
            По всем вопросам пишите на <span class="ref">admin@critics.fun</span>
        </div>
    </main>
    <div class="footer">
        Администрация сайта critics.fun
    </div>
</div>