<!-- incluindo o menu superior do usuario-->
<?php include '../app/Views/componente/menu_adm.php'; ?>
<?php
if ($_SESSION['SEGMENT'] == 'ANIMES') :
  $indicadorDados = 'infoAnime';
  $indicadorControler = 'Animes';
  $atualizar_gen = 'Animes/parteTres';
  $atualizar_info = 'Animes/parteDois';

else :
  $indicadorDados = 'infofilmes';
  $indicadorControler = 'FilmesSeries';
  $atualizar_gen = 'filmesSeries/parteDois';
  $atualizar_info = 'filmesSeries/parteUm';
endif;
?>
<div class="container-fluid">
  <div class="row">
    <!--Nessa coluna sera armazenada a barra de açoes do administrador-->
    <div class="adm-bar col-xl-3 col-md-4 col-sm-4 ">
      <?php include '../app/Views/componente/barra-adm.php'; ?>
    </div>
    <!-- Nesta coluna esta sendo armazenada os dados armazenados em banco-->
    <div class="col-xl-9 col-md-8 col-sm-8">
      <div class="container">
        <div class="mt-4" role="alert">
          <?= utilities::mensagenAlerta('AdmVideo') ?>
        </div>
        <div class="container-fluid content-item-adm mt-5  ">
          <div class="row">
            <!-- titulo vivivel em dispostivos menores-->
            <div class="title-resp mt-4">
              <h1><?= $dados[$indicadorDados]->nome ?></h1>
            </div>
            <!-- aqui sera armazenado a imagem do item-->
            <div class="col-xl-3 col-lg-3 col-md-10 col-sm-11 content-img ms-md-5  mt-4 ms-4 " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
              <img src="<?= URL ?>/<?= $dados[$indicadorDados]->imgID == 0 ? 'img/padrao.jpg' : $dados[$indicadorDados]->url  ?>">
            </div>
            <!-- Inicio do modal -->
            <div class="modal fade img-modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row mt-4">
                      <div class="col-2"></div>
                      <div class="col-8"><img src="<?= URL ?>/<?= $dados[$indicadorDados]->imgID == 0 ? 'img/padrao.jpg' : $dados[$indicadorDados]->url  ?>"></div>
                      <div class="col-2"></div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <!-- fim do modal-->

            <!-- aqui sera armazenado o nome do item e os seus generos-->
            <div class="col-xl-8 col-lg-8 col-md-11 col-sm-12 col-xs-1 content-one mt-4  ">
              <h1><?= $dados[$indicadorDados]->nome ?></h1>
              <h2>Generos</h2>
              <div class="row">

                <?php foreach ($dados['infoGeneros'] as $info) : ?>
                  <div class="col-xl-5 col-md-5 col-sm-10 gen-iten mx-1 my-2">
                    <?= $info->nome ?>
                  </div>
                <?php endforeach; ?>
              </div>
              <div class="mt-3 row ">
                <div class="col">
                  <a class="text-decoration-none" href="<?= URL ?>/<?= $atualizar_gen ?>/editar/<?= $dados[$indicadorDados]->id  ?>">
                    <div class="adm-item-op">
                      Atualizar Generos
                    </div>
                    <!--fechamento da class"adm-item-op"-->
                  </a>
                </div>
                <div class="col">
                  <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#excluirItem" href="#">
                    <div class="adm-item-op">
                      Excluir titulo
                    </div>
                    <!--fechamento da class"adm-item-op"-->
                  </a>
                </div>
              </div>
              <!-- Modal que pede a confirmação para a exclusao do item-->
              <div class="modal fade" id="excluirItem" tabindex="-1" aria-labelledby="excluirItemlLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="excluirItemlLabel">Excluir item?</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Deseja realmente excluir o item: <span><?= $dados[$indicadorDados]->nome ?></span>
                    </div>
                    <div class="modal-footer">
                      <a href="<?= URL ?>/<?= $indicadorControler ?>/excluirItem/<?= $dados[$indicadorDados]->id  ?>" type="button" class="btn btn-primary">Excluir</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--Container que separa os conteudos da pagina-->
            <div class="row mt-4">
              <div class="col"></div>
              <div class="container-separt col-9"></div>
              <div class="col"></div>
            </div>
            <!-- container que armazena a sinops-->
            <div class="container ">
              <p><?= $dados[$indicadorDados]->sinops ?></p>
            </div>
            <!--opçao de alterar a sinopse do item-->
            <?php if ($_SESSION['SEGMENT'] == 'ANIMES') : ?>
              <div class="container">
                <a class="text-decoration-none" href="<?= URL ?>/Animes/parteUm/editar/<?= $dados[$indicadorDados]->id  ?>">
                  <div class="adm-item-op">
                    Atualizar informaçoes
                  </div>
                  <!--fechamento da class"adm-item-op"-->
                </a>
              </div>
            <?php endif; ?>
          </div>
        </div><!-- fechamento da class ".content-item-adm"-->
        <div class="content-item-adm container   ">
          <div class="row ">
            <div class="col-xl-5 col-md-12 my-3 mx-4">
              <b>Nome:</b> <?= $dados[$indicadorDados]->nome  ?>
            </div>
            <?php if ($_SESSION['SEGMENT'] == 'ANIMES') : ?>
              <div class="col-xl-5 col-md-12  my-3 mx-4">
                <b>Status de visualização: </b><?= $dados[$indicadorDados]->estado ?>
              </div>
            <?php endif; ?>
            <div class="col-xl-5 col-md-12 my-3 mx-4">
              <b>Lançamento: </b><?= $dados[$indicadorDados]->lancamento ?>
            </div>
            <?php if (($_SESSION['SEGMENT'] == 'ANIMES') && $dados[$indicadorDados]->filmes != 0) : ?>
              <div class="col-xl-5 col-md-12 my-3 mx-4">
                <b>Filme: </b><?= $dados[$indicadorDados]->filmes ?>
              </div>
            <?php endif; ?>
            <?php if ($_SESSION['SEGMENT'] == 'ANIMES') : ?>
              <div class="col-xl-5 col-md-12 my-3 mx-4">
                <b>Formato: </b><?= $dados[$indicadorDados]->formato ?>
              </div>
            <?php endif; ?>
            <?php if (($_SESSION['SEGMENT'] == 'ANIMES') && $dados[$indicadorDados]->qtd_episodios != 0) : ?>
              <div class="col-xl-5 col-md-12 my-3 mx-4">
                <b>Quantidade de episodios:</b> <?= $dados[$indicadorDados]->qtd_episodios ?>
              </div>
            <?php endif; ?>
            <?php if ($_SESSION['SEGMENT'] != 'ANIMES') : ?>
              <div class="col-xl-5 col-md-12 my-3 mx-4">
                <b>Duração: </b><?= $dados[$indicadorDados]->duracao ?>
              </div>
            <?php endif; ?>

          </div>
          <?php if ($_SESSION['SEGMENT'] == 'ANIMES') : ?>
            <div class="row">
              <div class="col-xl-5 col-md-12 my-3 mx-4">
                <b>Temporada anterior: </b><a href="#" class="nav-link"><?= $dados[$indicadorDados]->anterior_temp ?></a>
              </div>
              <div class="col-xl-5 col-md-12 my-3 mx-4">
                <b>Proxima temporada: </b><a href="#" class="nav-link"><?= $dados[$indicadorDados]->proxima_temp ?></a>
              </div>
            </div>
          <?php endif; ?>
          <!-- aqui é possivel ir para a pagina de alteraçoes dos itens-->
          <div class="container mb-4">
            <a class="text-decoration-none" href="<?= URL ?>/<?= $atualizar_info ?>/editar/<?= $dados[$indicadorDados]->id  ?>">
              <div class="adm-item-op">
                Atualizar informaçoes
              </div>
              <!--fechamento da class"adm-item-op"-->
            </a>
          </div>
          <div class="adm-espacing">
            .
          </div>

        </div>
        <!--fechamento da class content-item-adm-->
        <?php if ($_SESSION['SEGMENT'] == 'ANIMES') : ?>
          <div class="container-fluid content-item-adm  ">
            <div class="row">
              <h3>Abertura(s)</h3>
              <?php if (isset($dados['VideoOpening']) == null) : ?>
                <p>Opss! Nao existem nenhuma abertura disponivel</p>
              <?php else : ?>
                <div class="col-xl-11 col-md-11 mt-xl-4 ms-xl-5  ">
                  <div class="row content-video">
                    <?php foreach ($dados['VideoOpening'] as $dado) : ?>
                      <div class="col-xl-6 col-md-11 col-sm-11 mt-2 ms-md-5 ms-xl-0">
                        <iframe src="<?=$dado->url_video ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endif; ?>
              <div class="container">
                <a href="<?= URL ?>/Videos/cadastro/Opening/<?= $_SESSION['idItem'] ?>" class="text-decoration-none">
                  <div class="adm-item-op">
                    Adicionar novo
                  </div>
                  <!--fechamento da class"adm-item-op"-->
                </a>
              </div>

              <h3>Encerramento(s)</h3>
              <?php if (isset($dados['VideoClosure']) == null) : ?>
                <p>Opss! Nao existem nenhuma Encerramento disponivel</p>
              <?php else : ?>
                <div class="col-xl-11 col-md-11 mt-xl-4 ms-xl-5  ">
                  <div class="row content-video">
                    <?php foreach ($dados['VideoClosure'] as $dado) :
                    ?>
                      <div class="col-xl-6 col-md-11 col-sm-11 mt-2 ms-md-5 ms-xl-0">
                        <iframe src="<?= $dado->url_video  ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                      </div>


                    <?php endforeach; ?>
                  </div>
                </div>

              <?php endif; ?>


              <div class="container">
                <a href="<?= URL ?>/Videos/cadastro/Closure/<?= $_SESSION['idItem'] ?>" class="text-decoration-none">
                  <div class="adm-item-op">
                    Adicionar novo
                  </div>
                  <!--fechamento da class"adm-item-op"-->
                </a>
              </div>

            </div>
            <div class="row">
            </div>
          </div>
          <!--fechamento da class content-item-adm-->
        <?php endif; ?>
      </div>
      <!--fechamento do container que armazena todo conteudo da pagina-->
    </div>
  </div>
</div>
</div>