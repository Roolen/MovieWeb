<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <link rel="stylesheet" href="<?= base_url(); ?>/css/reset.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>/css/global.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>/css/header.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>/css/footer.css"/>

    <script src="<?= base_url(); ?>/js/vue.min.js"></script>
</head>
<body>
    <?php
        $user = new App\Libraries\User();
        $meLink = ($user->has())
                  ? base_url().'/me/'.$user->getNickname()
                  : base_url();
    ?>
    <header class="header">
        <div class="logo"><img src="<?= base_url(); ?>/images/Logo.svg" alt="logo"/></div>
        <button class="header-menu" id="header_menu">Новости</button>
        <a class="header-link" href="<?= $meLink; ?>"> <div id="i_am_link">Я</div> </a>
        <a class="header-link" href="<?= base_url(); ?>/news"> <div id="news_link">Новости</div> </a>
        <a class="header-link" href="<?= base_url(); ?>/search"> <div id="search_link">Поиск</div> </a>
        <a class="header-link" href="<?= base_url(); ?>/mail"> <div id="messages_link">Сообщения</div> </a>
        <a class="header-link" href="<?= base_url(); ?>/me/logout"> <div id="messages_link">Выход</div> </a>
        <a class="settings-button" href="<?= base_url(); ?>/settings" id="settings_button"></a>
    </header>