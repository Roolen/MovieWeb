<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?= base_url(); ?>/css/reset.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>/css/global.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>/css/header.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>/css/footer.css"/>

    <script src="<?= base_url(); ?>/js/vue.min.js"></script>
</head>
<body>
    <header class="header">
        <div class="logo"><img src="<?= base_url(); ?>/images/Logo.svg" alt="logo"/></div>
        <button class="header-menu" id="header_menu">Новости</button>
        <a class="header-link" href="#"> <div id="i_am_link">Я</div> </a>
        <a class="header-link" href="#"> <div id="news_link">Новости</div> </a>
        <a class="header-link" href="#"> <div id="search_link">Поиск</div> </a>
        <a class="header-link" href="#"> <div id="messages_link">Сообщения</div> </a>
        <div class="settings-button" id="settings_button"></div>
    </header>