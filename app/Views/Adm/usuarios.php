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
            <div class="adm-usuario">
                <div class="adm-espacing">.</div>
                <h1>Todos os usuarios</h1>
                <?php foreach ($dados['vals'] as $valor) : ?>
                    <div class="adm-usuario-item">
                        <div class="row mx-2">
                            <div class="col-xl-1 col-lg-2 col-md-2 col-px-2 "> <b>Id: </b> <?= $valor->id ?></div>
                            <div class="col-xl-4 col-lg-4 col-md-5 col-px-6"><b>Nome: </b> <?= $valor->nome ?></div>
                            <div class="col-xl-6 col-lg-5 col-md-12 col-px-12"> <b>Email: </b> <?= $valor->email ?></div>

                        </div>
                    </div>
                <?php endforeach ?>
                <div class="adm-espacing">.</div>
            </div>
        </div>
    </div>
</div>