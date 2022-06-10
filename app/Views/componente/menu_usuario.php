<!--Nota!! a classe col-smp foi criada por min(para fazer adequaçoes em telas pequenas-->

<!--Menu do usuario-->
<div class="container-fluid">
	<!--Menu superior(1)-->
	<div class="row backgroundGrey  text-light  ">
		<div class="col-smp-20 col-xl-9 col-lg-8 col-md-5 col-sm-1  my-1 ">
			<?php

			if (isset($_SESSION['usu_id'])) :
				echo '<h5 class="text-white">Seja bem  vindo(a)  ' . $_SESSION['usu_nome'] . '</h5>';
			else :
				echo '<h5><a class="text-white  " href="' . URL . '" >MyList</a></h5>';
			endif;
			?>
		</div>
		<div class="col-smp-80  col-xl col-lg col-md col-sm my-2 ">
			<div class="row">
				<div class="col text-right border-end text-end">
					<?php
					if (isset($_SESSION['usu_id'])) :
						echo ' <a class=" text-white " href="' . URL . '/Usuarios/perfil">Perfil</a>';
					else :
						echo '<a  href="' . URL . '/Usuarios/login" class="text-white ">Logar</a>';
					endif;
					?>
				</div>
				<div class="col">
					<?php
					if (isset($_SESSION['usu_id'])) :
						echo ' <a class=" text-white  " href="' . URL . '/Usuarios/logof">Logof</a>';
					else :
						echo '<a class="text-white " href="' . URL . '/Usuarios/cadastro">Criar conta</a>';
					endif;
					?>
				</div>
			</div>

		</div>
	</div>
	<!--Fim do menu superior (1)-->
	<!-- Inicio da segunda parte do menu-->
	<div class="second-menu">
		<div class="container slider">
			<div class="content-slide">
				<div class="slider-item active" id="reset-carrosel">
					<img class="" src="<?= URL ?>/img/Banner/1.png">
				</div>
				<div class="slider-item">
					<img class="" src="<?= URL ?>/img/Banner/2.png">
				</div>
				<div class="slider-item">
					<img class="" src="<?= URL ?>/img/Banner/3.png">
				</div>
			</div>
			<div class="slider-prev">&laquo;</div>
			<div class="slider-next">&raquo;</div>
		</div>
		<!-- inicio da terceira parte do menu-->
		<div class=" third-menu">
			<nav class="navbar navbar-expand-xl  bg-light ">
				<div class="container-fluid">
					<a class="navbar-brand" href="<?= URL ?>">
						<img src="<?= URL ?>/img/logo.png">

					</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav mr-auto">
							<li class="nav-item active">
								<a class="nav-link text-dark mx-3 " href="<?= URL ?>">Inicio</a>
							</li>
							<li class="nav-item ">
								<a class="nav-link text-dark mx-3" href="<?= URL ?>/lista/">Lista completa</a>

							</li>
							<li class="nav-item ">
								<a class="nav-link text-dark  mx-3" href="<?= URL ?>/generos">Categorias</a>
							</li>
							<li class="nav-item ">
								<a class="nav-link text-dark mx-3" href="<?= URL ?>/sobre">Sobre</a>
							</li>
							<li class="nav-item ">
								<a class="nav-link  text-dark  mx-3" href="<?= URL ?>/contato">Contatos</a>
							</li>
						</ul>
						<form class="d-flex my-2 my-lg-0" action="<?= URL ?>/lista/busca" method="post">
							<input class="form-control me-2" type="search" name="buscar" aria-label="Pesquisar">
							<button class="btn " type="submit" name="enviar">Pesquisar</button>
						</form>
					</div>
				</div>
			</nav>


		</div>
		<!--Fim do Menu inferior(2)-->
	</div>