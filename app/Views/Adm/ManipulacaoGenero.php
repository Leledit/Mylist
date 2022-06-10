<!-- incluindo o menu superior do usuario-->
<?php include '../app/Views/componente/menu_adm.php'; ?>
<!-- verificando o segmento atual do site-->
<?php
if ($_SESSION['SEGMENT'] == 'ANIMES') :
    $indicaçãoSegmento = 'animes';

else :
    $indicaçãoSegmento = 'filmes';

endif;
?>
<div class="container-fluid">
	<div class="row">
		<!--Nessa coluna sera armazenada a barra de açoes do administrador-->
		<div class="col-xl-3 col-md-4 col-sm-4  adm-bar">
			<?php include '../app/Views/componente/barra-adm.php'; ?>
		</div>
		<!-- Nesta coluna esta sendo armazenada os dados armazenados em banco-->
		<div class="col-xl-9 col-md-8 col-sm-8">
        <div class="row">
                <div class="col-xl-2 col-lg-1 col-md-1 col-sm-12"></div>
                <div class="col-xl-8 col-lg-9 col-md-10 col-sm-12">
                    <div class="adm-forme container mx-2 ">
                        <div class="adm-espacing">.</div>
                        <h1 class="mt-2">Cadastrando Genero (para <?=$indicaçãoSegmento?>)</h1>
                        <form action="<?= URL ?>/Generos/ManipulacaoGenero/<?= $dados['acao'] ?>/<?= isset($dados['id']) ? $dados['id'] : '' ?> " method="POST" name="cadastroUsu" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nomeGInput" class="form-label">Nome:<span>*</span></label>
                                <input type="text" class="form-control" id="nomeGInput" aria-describedby="nome genero" name="nomeG" value="<?= $dados["nome"] ?>">
                                <div class="form-text"><?= $dados["nome_erro"] ?></div>
                            </div>
                            
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="inputGroupFile01">Adicionar imagem</label>
                                <input type="file" name="imagenG" id="img-genero" class="form-control" id="inputGroupFile01" >
                            </div>
                            <div class="row mt-4 ms-3 ">
                                <div class="col  "><a class="btn btn-outline-secondary" href="<?= URL ?>/Animes/index">Voltar</a></div>
                                <div class="col"></div>
                                <div class="col"><button class="btn btn-outline-success" type="submit">Proximo</button></div>
                            </div>
                            <div class="adm-espacing">.</div>

                        </form>
                    </div><!-- fechamento adm-forme-->
                </div>
                <div class="col-xl-2 col-lg-1 col-md-1 col-sm-12"></div>
            </div>
        </div>
    </div>
</div>