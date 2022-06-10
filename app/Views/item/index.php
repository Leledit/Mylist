<div class="container">
  <div class="container-fluid content-item  ">
    <div class="row">
      <!-- titulo vivivel em dispostivos menores-->
      <div class="title-resp">
        <h1 class="my-2"><?= $dados['info']->nome ?></h1>
      </div>
      <!-- aqui sera armazenado a imagem do item-->
      <div class="col-xl-3 col-lg-3 col-md-10 col-sm-11 content-img ms-md-5  mt-4 ms-4 " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        <img src="<?= URL ?>/<?= $dados['info']->imgID == 0 ? 'img/padrao.jpg' : $dados['info']->url  ?>">
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
                <div class="col-8"><img src="<?= URL ?>/<?= $dados['info']->imgID == 0 ? 'img/padrao.jpg' : $dados['info']->url  ?>"></div>
                <div class="col-2"></div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <!-- fim do modal-->

      <!-- aqui sera armazenado o nome do item e os seus generos-->
      <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-1 content-one mt-4  ">
        <h1><?= $dados['info']->nome ?></h1>
        <h2>Generos</h2>
        <div class="row">
          <?php foreach ($dados['infoGeneros'] as $info) : ?>
            <div class="col-xl-3 col-md-5 col-sm-5 gen-iten mx-3 my-2">
              <?= $info->nome ?>
            </div>
          <?php endforeach; ?>
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
        <p><?= $dados['info']->sinops ?></p>
      </div>
    </div>
  </div><!-- fechamento da class "content-item"  <?= $dados['info']->estado == 'nunca visto' ? 'content-item-dager' : 'content-item'?>-->
  <div class="container content-item">
    <div class="row ">
      <div class="col-xl-5 col-md-12 my-3 mx-4">
        <b>Nome:</b> <?= $dados['info']->nome ?>
      </div>
      <?php if ($_SESSION['SEGMENT'] == 'ANIMES') : ?>
        <div class="col-xl-5 col-md-12  my-3 mx-4">
          <b>Status de visualização: </b><?= $dados['info']->estado ?>
        </div>
      <?php endif; ?>
      <div class="col-xl-5 col-md-12 my-3 mx-4">
        <b>Lançamento: </b><?= $dados['info']->lancamento ?>
      </div>
      <?php if (($_SESSION['SEGMENT'] == 'ANIMES') && $dados['info']->filmes != 0) : ?>
        <div class="col-xl-5 col-md-12 my-3 mx-4">
          <b>Filme: </b><?= $dados['info']->filmes ?>
        </div>
      <?php endif; ?>
      <?php if ($_SESSION['SEGMENT'] == 'ANIMES') : ?>
        <div class="col-xl-5 col-md-12 my-3 mx-4">
          <b>Formato: </b><?= $dados['info']->formato ?>
        </div>
      <?php endif; ?>
      <?php if (($_SESSION['SEGMENT'] == 'ANIMES') && $dados['info']->qtd_episodios != 0) : ?>
        <div class="col-xl-5 col-md-12 my-3 mx-4">
          <b>Quantidade de episodios:</b> <?= $dados['info']->qtd_episodios ?>
        </div>
      <?php endif; ?>
      <?php if ($_SESSION['SEGMENT'] != 'ANIMES') : ?>
        <div class="col-xl-5 col-md-12 my-3 mx-4">
          <b>Duração: </b><?= $dados['info']->duracao ?>
        </div>
      <?php endif; ?>

    </div>
    <?php if ($_SESSION['SEGMENT'] == 'ANIMES') : ?>
      <div class="row">
        <div class="col-xl-5 col-md-12 my-3 mx-4">
          <b>Temporada anterior: </b>
          <?php if ($dados['info']->anterior_temp != 'ND') :
            if ($dados['erroConsulta'] == 'ant') :
              echo 'Nao encontrada';
            else : ?>
              <a href="<?= URL ?>/item/<?= $dados['anterior_temp_id']->id ?>" class="nav-link"><?= $dados['info']->anterior_temp ?></a>
          <?php
            endif;
          else :
            echo 'ND';
          endif; ?>
        </div>
        <div class="col-xl-5 col-md-12 my-3 mx-4">
          <b>Proxima temporada: </b>
          <?php
          if ($dados['info']->proxima_temp != 'ND') :
            if ($dados['erroConsulta'] == 'pro') :
              echo 'ND';
            else : ?>
              <a href="<?= URL ?>/item/<?= $dados['proxima_temp_id']->id ?>" class="nav-link"><?= $dados['info']->proxima_temp ?></a>
          <?php
            endif;
          else :
            echo 'ND';
          endif;
          ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
  <!--fechamento da class content-item-->
  <?php if ($_SESSION['SEGMENT'] == 'ANIMES') : ?>
    <div class="container-fluid content-item  ">
      <div class="row">
        <h3>Abertura(s)</h3>
        <?php if (isset($dados['VideoOpening']) == null) : ?>
          <p>Opss! Nao existem nenhuma abertura disponivel</p>
        <?php else : ?>
          <div class="col-xl-11 col-md-11 mt-xl-4 ms-xl-5  ">
            <div class="row content-video">
              <?php foreach ($dados['VideoOpening'] as $dado) : ?>
                <div class="col-xl-6 col-md-11 col-sm-11 mt-2 ms-md-5 ms-xl-0">
                  <iframe src="<?= $dado->url_video ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
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


      </div>
      <div class="row">
      </div>
    </div>
    <!--fechamento da class content-item-->
  <?php endif; ?>
</div>
<!--fechamento do container que armazena todo conteudo da pagina-->
</div>