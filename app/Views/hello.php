<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Hello</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="<?= base_url(); ?>/css/reset.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>/css/hello.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>/css/footer.css" />

</head>

<body>
	<div id="hello-app">
		<header class="header" id="header">
			<div class="hello-label">
				<div class="label-number">02</div>
			</div>
			<div class="menu">
				<ul class="menu-list">
					<li class="menu-item"><button id="future_button">Планируется</button></li>
					<li class="menu-item"><button id="contacts_button">Контакты</button></li>
					<li class="menu-item"><button @click="modalOpen" id="authorize_button">Авторизация</button></li>
				</ul>
			</div>
		</header>
		<main class="main" id="main">
			<div class="head-section">
				<div class="head-hello">
					<h1>
						Будь<br>
						В мире<br>
						Кино!<br>
						 
					</h1>
				</div>
				<div class="head-info">
					<button class="registration-button" id="registration_button" ><a href="#reg">Регистрация</a></button>
					<div class="info">
						<div class="info-text">
							<p>
								Социальные сети играют немаловажную роль в жизни человека.
								Поэтому мы есть везде! Переходи на нас в социальных сетях и наслаждайся. <br>
								Не ограничивай себя в общении и развлечениях!
							</p>
						</div>
						<div class="social-container">
							<a class="social-link twitter" href="#"></a>
							<a class="social-link facebook" href="#"></a>
							<a class="social-link vk" href="#"></a>
						</div>
					</div>
				</div>
				<div class="head-monument">
					<p>
						Смотри<br>Делись<br>Обсуждай
					</p>
				</div>
			</div>

			<div class="future-section">
				<div class="future">
					<div class="image-future"><img src="<?= base_url(); ?>/images/Hello/image_1.png" alt="screen of post" /></div>
					<div class="info-future">
						<h2 class="head-future">Делись мыслями</h2>
						<p class="text-future">
							После просмотра фильма, мультфильма или сериала в нас находится безконечное количество
							эмоций и впечатлений. Чтобы скорее поделиться ими, просто садись и пиши! Твои подписчики уже ждут
							новых и интересных рецензий.
						</p>
						<button class="button-future" ><a href="#reg">Регистрация</a></button>
					</div>
				</div>
				<div class="future">
					<div class="info-future">
						<h2 class="head-future">Обсуждай</h2>
						<p class="text-future">
							Вышел новый фильм, и к нему вышло уже много рецензий, но вы с ними не согласны?
							Или наоборот полностью поддерживаете данную рецензию? Тогда открывай комментарии и пиши свое мнение!
						</p>
						<button class="button-future" ><a href="#reg">Регистрация</a></button>
					</div>
					<div class="image-future"><img src="<?= base_url(); ?>/images/Hello/image_2.png" alt="screen of comments" /></div>
				</div>
				<div class="future">
					<div class="image-future"><img src="<?= base_url(); ?>/images/Hello/image_3.png" alt="screen of news" /></div>
					<div class="info-future">
						<h2 class="head-future">Ищи посты по тегам</h2>
						<p class="text-future">
							Чтобы не терять время на листание ленты новостей в поисках нужных постов, просто найти через
							поиск интересующие тебя посты по тегам.
						</p>
						<button class="button-future" ><a href="#reg">Регистрация</a></button>
					</div>
				</div>
			</div>

			<div class="registration-section">
				<h2 class="title"><a name="reg">Регистрация</a></h2>

				<div class="info-warning">{{ nameWarning }}</div>
				<input v-model="firstName" type="text" class="field" id="name_field" placeholder="name">

				<div class="info-warning">{{ nickWarning }}</div>
				<input v-model="nickname" type="text" class="field" id="nickname_field" placeholder="nickname">

				<div class="info-warning">{{ emailWarning }}</div>
				<input v-model="email" type="email" class="field" id="email_field" placeholder="email">

				<div class="info-warning">{{ passwordWarning }}</div>
				<input v-model="password" type="password" class="field" id="password_field" placeholder="password">

				<div class="info-warning">{{ phoneWarning }}</div>
				<input v-model="phone" type="tel" class="field" id="phone_field" placeholder="phone number">

				<button v-on:click="registration" type="submit" class="button" id="register_button">Регистрация</button>
				<button @click="modalOpen" type="button" class="button-authorize">Авторизация</button>
			</div>
		</main>

		<div v-bind:class="{ 'modal-on': modal }" class="modal-auth" id="modalAuth">
			<div class="modal-dialog">
				<button @click="modalClose" type="button" class="close-modal"></button>
				<header>
					<h2 class="modal-title">Авторизация</h2>
				</header>
				<div class="modal-form">
					<input v-model="nickname" type="text" class="field" placeholder="login">
					<input v-model="password" type="password" class="field" placeholder="password">
					<div class="info-warning">{{ authWarning }}</div>
					<button @click="authorize" type="button" class="button">Вход</button>
				</div>
			</div>
		</div>

		<?= view('Share/footer'); ?>
	</div>

	<script> const baseUrl = "<?= base_url(); ?>"; </script>
	<script src="<?= base_url(); ?>/js/vue.min.js"></script>
	<script src="<?= base_url(); ?>/js/hello.js"></script>
</body>

</html>