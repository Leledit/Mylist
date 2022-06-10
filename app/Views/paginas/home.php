<div class="page_contente">
	<!--Barra lateral visivel em dispositivos menores-->
	<div class="side_spacing sideBar_DPequeno ">
		<div class="contant">
			<div class="row">
				<div class="col">
					<?php include "../app/Views/componente/sessoes.php" ?>
				</div>
			</div>
		</div>



	</div>

	<div class="row">
		<!--Conteudo da parte principal do site-->
		<div class="col-xl-9 ">
			<?php
			if ($dados['qtdContainer'] == 2) :

			?>
				<!--primeiro bloco de conteudo-->
				<div class="container">
					<h4>Ultimas publicações</h4>
					<div class="row">

						<!-- item da pagina -->
						<?php foreach ($dados['ultimasPublicacoes'] as $dado) : ?>
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
					<div class="content-usu-btn-vermais">
						<a href="<?= URL ?>/lista/">Lista completa </a>
					</div>
				</div>
			<?php endif; ?>
			<!--Segundo bloco de conteudo-->
			<div class="spacing_top10 container ">
				<h4>Todos os titulos</h4>
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

				<div class="content-usu-pag">
					<p>Paginas </p>
					<?php
					if ($dados['pag'] > 3) :
						$inicio =  $dados['pag'] - 2;
					?>
						<div class="content-usu-pag-item <?= $dados['pag'] == 1 ? 'pag-item-active' : '' ?>">
							<a href="<?= URL ?>/Paginas/index/">1</a>
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
							<a href="<?= URL ?>/Paginas/index/<?= $valor  ?>"><?= $i ?></a>
						</div>

					<?php
					}
					if ($dados['qtd_pag'] - $dados['pag'] > 3) :
						echo '<p>...</p>';
					endif;
					if ($dados['qtd_pag'] - $dados['pag'] > 2) :
					?>
						<div class="content-usu-pag-item <?= $dados['pag'] == $dados['qtd_pag'] ? 'pag-item-active' : '' ?>">
							<a href="<?= URL ?>/Paginas/index/<?= $dados['qtd_pag'] ?>"><?= $dados['qtd_pag'] ?></a>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<!--fechamento do Segundo bloco de conteudo-->



		</div>
		<!--fechamento do container que armazena o conteudo do site-->
		<!-- Barra lateral-->
		<div class="col-xl-2 ">
			<div class="sideBar_Dgrande">
				<?php include "../app/Views/componente/sessoes.php" ?>
			</div>
		</div>
		<!--Barralateral visivel em dispositivos grandes-->

	</div>
	<!--container das colunas-->
</div>
<!--fechamento da div pricipal da pagina-->
</div>