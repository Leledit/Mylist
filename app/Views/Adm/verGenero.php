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
      <div class="row ">

        <div class="col-xl-2 col-lg-1 col-md-1 col-sm-12"></div>
        <div class="content-item-adm mt-4 col-xl-8 col-lg-9 col-md-10 col-sm-12 ">
          <div class="row">
            <h1 class="mt-4">Informaçoes do genero: <?= $dados[0]->nome ?></h1>

            <div class="content-img col-smp-80 col-xl-5 col-lg-5 col-md-10 col-sm-11 ms-md-5  mt-4 ms-4 " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
              <img src="<?= URL ?>/<?= $dados[0]->url ?>">

            </div>
            <div class="col-xl col-lg col-md col-sm mt-3">
              <div class="col">
                <h2>Opçoes</h2>
                <a class="text-decoration-none " href="<?= URL ?>/Generos/ManipulacaoGenero/editar/<?= $dados[0]->id ?> ">
                  <div class="adm-item-op ">
                    Atualizar
                  </div>
                  <!--fechamento da class"adm-item-op"-->
                </a>
              </div>
              <div class="col">
                <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#excluirGenero" href="#" >
                  <div class="adm-item-op">
                    Deletar
                  </div>
                  <!--fechamento da class"adm-item-op"-->
                </a>
              </div>
              <!-- Modal que pede a confirmação para a exclusao do item-->
              <div class="modal fade" id="excluirGenero" tabindex="-1" aria-labelledby="excluirItemlLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="excluirItemlLabel">Excluir item?</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Deseja realmente excluir o genero: <span><?= $dados[0]->nome?></span>
                    </div>
                    <div class="modal-footer">
                      <a  href="<?= URL ?>/Generos/deletarGnero/<?= $dados[0]->id ?>/ <?= $dados[0]->id_img ?> " type="button" class="btn btn-primary">Excluir</a>
                    </div>                       
                  </div>
                </div>
              </div>
            
              <div class="col">
                <a class="text-decoration-none" href="<?= URL ?>/adm/filtros/<?= $dados[0]->id ?>/genero">
                  <div class="adm-item-op"> 
                    Listar titulos
                  </div>
                  <!--fechamento da class"adm-item-op"-->
                </a>
              </div>
            </div>
            <div class="adm-espacing">.</div>
          </div>
          <div class="col-xl-2 col-lg-1 col-md-1 col-sm-12"></div>

        </div>
      </div>
    </div>
  </div>
</div>
