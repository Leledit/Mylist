<?php
if ($_SESSION['SEGMENT'] == 'ANIMES') :
    $indicadorControler = 'Animes';
else :
    $indicadorControler = 'FilmesSeries';
endif;
?>
<div class="content-fluid ">
    <!-- mensagem de boas vindas-->
    <div class="content adm-bar-msg">
        <h1> Bem vindo Administrador: <b> <?= $_SESSION['usu_nome'] ?></b></h1>
    </div>
    <!-- sessoes do site-->
    <div class="content adm-bar-sessao">
        <h1>Sessão</h1>
        <a href="<?= URL ?>/Animes/index">
            <div class="adm-bar-unit <?= $_SESSION['SEGMENT'] == 'ANIMES' ? "unit-select" : "" ?>">
                Animes
            </div>
        </a>
        <a href="<?= URL ?>/FilmesSeries/index">
            <div class="adm-bar-unit <?= $_SESSION['SEGMENT'] == 'FILMESSERIES' ? "unit-select" : "" ?>">
                Filmes/Series
            </div>
        </a>
    </div>
    <hr>
    <!-- açoes da pagina administrativa-->
    <div class="content adm-bar-acoes">
        <h1>Ações</h1>
        <a href="<?= URL ?>/<?= $indicadorControler ?>/parteUm/cadastro">
            <div class="adm-bar-unit">
                Cadastrar
            </div>
        </a>

        <?php if ($_SESSION['SEGMENT'] != 'FANARTS') : ?>
            <a href="<?= URL . "/Generos" ?>">
                <div class="adm-bar-unit">
                    Generos
                </div>
            </a>
        <?php endif; ?>

        <a href="<?= URL . "/adm/filtros/0/all" ?>">
            <div class="adm-bar-unit">
                Aplicar filtros
            </div>
        </a>

        <a href="<?= URL . "/Usuarios/usuarios" ?>">
            <div class="adm-bar-unit">
                Usuarios
            </div>
        </a>
        <a href="<?= URL . "/Videos/index/Opening" ?>">
            <div class="adm-bar-unit">
                Opening
            </div>
        </a>
        <a href="<?= URL . "/Videos/index/Closure" ?>">
            <div class="adm-bar-unit">
                Closure
            </div>
        </a>
    </div>

    <hr>
</div>