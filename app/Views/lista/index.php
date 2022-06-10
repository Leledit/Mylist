<div class="page_contente">
	<!--Barra lateral visivel em dispositivos menores-->
	<div class="side_spacing sideBar_DPequeno ">
		<div class="contant">
			<div class="row">
				<div>
					<?php include "../app/Views/componente/sessoes.php" ?>
				</div>
			</div>
		</div>



		<!--
			 <?= $_SESSION['SEGMENT'] == 'ANIMES' ? "unit-select" : "" ?>">
				
			</div>
		
		
			<div class=" main-session-item  <?= $_SESSION['SEGMENT'] == 'FILMESSERIES' ? "unit-select" : "" ?>">
				
			</div>
		-->
	</div>

	<div class="row">

		<?php if (isset($_SESSION['buscarfall'])) : ?>
			<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
				<!--bloco de conteudo-->
				<div class="msg-fall msg container alert alert-danger">
					<?php if ($_SESSION['buscarfall'] == 1) : ?>
						<h3>Opss... campo busca vazio, nenhuma busca foi realizada !!</h3>
					<?php else : ?>
						<h3>Opss... nenhum resultado foi encontrado !!</h3>
					<?php endif; ?>
				</div>
			</div>


		<?php else : ?>

			<!--Conteudo da parte principal do site-->
			<div class=" col-xl-9 col-lg-12 col-md-12 col-sm-12">
				<!--bloco de conteudo-->
				<div class="list-content container ">
					<h4>Todos os titulos</h4>

					<?php
					if (isset($_SESSION['ListaGen'])) :

					?>
						<p>Todos os titulos do genero <span><?php echo $_SESSION['ListaGeNome']->nome ?></span></p>
					<?php endif; ?>

					<div class="row">

						<!-- item da pagina -->
						<?php foreach ($dados['ResultadosTotais'] as $dado) : ?>
							<div class="content-usu-unit col-xl-3 col-lg-3 col-md-4 col-sm-5">
								<a href="<?= URL ?>/item/<?= $dado->id ?>">
									<div class="content-usu-unit-img">
										<img src="<?= URL ?>/<?= $dado->imgID == 0 ? 'img/padrao.jpg' : $dado->url  ?>" class="">
									</div>
									<div class="content-usu-unit-name">
										<?= utilities::resumirTexto($dado->nome, 6)  ?>
									</div>
								</a>
							</div>
						<?php endforeach ?>
					</div>
					<?php  
					  if(!isset($_SESSION['busca'])):
					?>
					<div class="content-usu-pag">

					
						<p>Paginas </p>
						<?php
						if ($dados['pag'] > 3) :
							$inicio =  $dados['pag'] - 2;
						?>
							<div class="content-usu-pag-item <?= $dados['pag'] == 1 ? 'pag-item-active' : '' ?>">
								<a href="<?= URL ?>/lista/">1</a>
							</div>
						<?php
						else :
							$inicio =  1;
						endif;

						if ($dados['pag'] > 4) :
							echo '<p>...</p>';
						endif;
						if ($dados['qtd_pag'] - $dados['pag'] > 2) :
							$fim =  $dados['pag'] + 2;
						else :
							$fim =  $dados['qtd_pag'];
						endif;
						$cont = 1;
						//echo 'inicio: ' . $inicio . ' fim: ' . $fim . ' cont: ' . $cont;
						for ($i = $inicio; $i <= $fim; $i++) {
							$valor = $i;
						?>
							<div class="content-usu-pag-item <?= $dados['pag'] == $i ? 'pag-item-active' : '' ?>">
								<a href="<?= URL ?>/lista/<?= $valor  ?>"><?= $i ?></a>
							</div>

						<?php
						}
						if ($dados['qtd_pag'] - $dados['pag'] > 3) :
							echo '<p>...</p>';
						endif;
						if ($dados['qtd_pag'] - $dados['pag'] > 2) :
						?>
							<div class="content-usu-pag-item <?= $dados['pag'] == $dados['qtd_pag'] ? 'pag-item-active' : '' ?>">
								<a href="<?= URL ?>/lista/<?= $dados['qtd_pag'] ?>"><?= $dados['qtd_pag'] ?></a>
							</div>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>
				<!--fechamento do Segundo bloco de conteudo-->
			</div>
			<!--fechamento do container que armazena o conteudo do site-->

		<?php endif; ?>
		<!-- Barra lateral-->
		<div class="col-xl-2 ">
			<div class="sideBar_Dgrande">
				<?php include "../app/Views/componente/sessoes.php" ?>
				</a>
			</div>
		</div>
		<!--Barralateral visivel em dispositivos grandes-->
	</div>
	<!--container das colunas-->
</div>
<!--fechamento da div pricipal da pagina-->
</div>