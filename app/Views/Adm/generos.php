<!-- incluindo o menu superior do usuario-->
<?php include '../app/Views/componente/menu_adm.php'; ?>
<div class="container-fluid">
	<div class="row">
		<!--Nessa coluna sera armazenada a barra de açoes do administrador-->
		<div class="col-xl-3 col-md-4 col-sm-4  adm-bar">
			<?php include '../app/Views/componente/barra-adm.php'; ?>
		</div>
		<!-- Nesta coluna esta sendo armazenada os dados armazenados em banco-->
		<div class="col-xl-9 col-md-8 col-sm-8">
			<div class="mt-4" role="alert">
				<?= utilities::mensagenAlerta('MainGenero') ?>
			</div>
			<div class="list-content-adm container ">
				<div class="adm-add-record row">
					<div class="col-xl-10 col-md-9 col-sm-8  ">
						<h4>Listar por genero</h4>
					</div>

					<div class=" col-xl col-md col-sm " id="adm-add-record-add">
						<a href="<?= URL ?>/Generos/ManipulacaoGenero/Cadastro">Adicionar</a>
					</div>
				</div>


				<div class="row">

					<!-- item da pagina -->
					<?php if (isset($dados['generos'])) :
						foreach ($dados['generos'] as $gen) :

							
					?>
							<div class="content-usu-unit col-xl-3 col-lg-4 col-md-5 col-sm-11 ms-md-4 ms-sm-4 ms-xl-0 mx-lg-0">
								<a href="<?= URL ?>/Generos/verGenero/<?= $gen->id ?>">

									<div class="content-usu-unit-img">
										<img src="<?= URL ?>/<?= $gen->url ?>" class="">
									</div>
									<div class="content-usu-unit-name">
										<?= $gen->nome   ?>
									</div>
								</a>
							</div>
						<?php endforeach;
					else : ?>
						<div class="adm-mensagens-alert"> Nao ha generos para essa sessao</div>
					<?php endif; ?>

				</div>

				<div class="content-usu-pag">
					<p>Paginas </p>
					<?php
					if ($dados['pag'] > 3) :
						$inicio =  $dados['pag'] - 2;
					?>
						<div class="content-usu-pag-item <?= $dados['pag'] == 1 ? 'pag-item-active' : '' ?>">
							<a href="<?= URL ?>/Generos/index/">1</a>
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
							<a href="<?= URL ?>/Generos/index/<?= $valor  ?>"><?= $i ?></a>
						</div>

					<?php
					}
					if ($dados['qtd_pag'] - $dados['pag'] > 3) :
						echo '<p>...</p>';
					endif;
					if ($dados['qtd_pag'] - $dados['pag'] > 2) :
					?>
						<div class="content-usu-pag-item <?= $dados['pag'] == $dados['qtd_pag'] ? 'pag-item-active' : '' ?>">
							<a href="<?= URL ?>/Generos/index/<?= $dados['qtd_pag'] ?>"><?= $dados['qtd_pag'] ?></a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>