<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Hello</title>

	<link rel="stylesheet" href="<?= base_url(); ?>/css/reset.css"/>
	<link rel="stylesheet" href="<?= base_url(); ?>/css/hello.css"/>
	<link rel="stylesheet" href="<?= base_url(); ?>/css/footer.css"/>
</head>
<body>
	<header class="header">
		<div class="hello-label">
			<div class="label-number">02</div>
		</div>
		<div class="menu">
			<ul class="menu-list">
				<li class="menu-item"><button id="future_button">Future</button></li>
				<li class="menu-item"><button id="contacts_button">Contacts</button></li>
				<li class="menu-item"><button id="authorize_button">Authorize</button></li>
			</ul>
		</div>
	</header>
	<main class="main">
		<div class="head-section">
			<div class="head-hello">
				<h1>
					Hello <br/>
					This Site Dedicated To Movies <br/>
					And Serials
				</h1>
			</div>
			<div class="head-info">
				<button class="registration-button" id="registration_button">Registration</button>
				<div class="info">
					<div class="info-text">
						<p>
						Donec sollicitudin molestie malesuada. 
						Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; 
						Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
						</p>
					</div>
					<div class="social-container">
            			<a class="social-link twitter" href="#"></a>
            			<a class="social-link facebook" href="#"></a>
            			<a class="social-link vk" href="#"></a>
        			</div>
				</div>
			</div>
			<div class="head-monument"></div>
		</div>

		<div class="future-section">
			<div class="future">
				<div class="image-future"><img src="<?= base_url(); ?>/images/Hello/image_1.png" alt="screen of post"/></div>
				<div class="info-future">
					<h2 class="head-future">Share critic</h2>
					<p class="text-future">
						Quisque velit nisi, pretium ut lacinia in, elementum id enim. 
						Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. 
						Vivamus suscipit tortor eget felis porttitor volutpat. Praesent sapien massa, 
						convallis a pellentesque nec, egestas non nisi.
					</p>
					<button class="button-future">Registration</button>
				</div>
			</div>
			<div class="future">
				<div class="info-future">
					<h2 class="head-future">Write comments</h2>
					<p class="text-future">
						Donec rutrum congue leo eget malesuada. Praesent sapien massa, 
						convallis a pellentesque nec, egestas non nisi. 
						Donec rutrum congue leo eget malesuada. 
						Curabitur aliquet quam id dui posuere blandit.
					</p>
					<button class="button-future">Registration</button>
				</div>
				<div class="image-future"><img src="<?= base_url(); ?>/images/Hello/image_2.png" alt="screen of comments"/></div>
			</div>
			<div class="future">
				<div class="image-future"><img src="<?= base_url(); ?>/images/Hello/image_3.png" alt="screen of news"/></div>
				<div class="info-future">
					<h2 class="head-future">Search critic posts</h2>
					<p class="text-future">
						Quisque velit nisi, pretium ut lacinia in, elementum id enim. 
						Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. 
						Vivamus suscipit tortor eget felis porttitor volutpat. 
						Praesent sapien massa, convallis a pellentesque nec, egestas non nisi.
					</p>
					<button class="button-future">Registration</button>
				</div>
			</div>
		</div>

		<div class="registration-section">
			<h2 class="title">Registration</h2>
			<input type="text" class="field" id="name_field" placeholder="name">
			<input type="text" class="field" id="nickname_field" placeholder="nickname">
			<input type="email" class="field" id="email_field" placeholder="email">
			<input type="password" class="field" id="password_field" placeholder="password">
			<input type="tel" class="field" id="phone_field" placeholder="phone number">
			<button type="submit" class="button" id="register_button">Register</button>
			<button type="button" class="button-authorize">Authorize</button>
		</div>
	</main>
	
	<?= view('Share/footer'); ?>
</body>
</html>