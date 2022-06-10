<?php

if ($_SESSION != null) :
    if ($_SESSION['usu_nivel'] != 1) :
        header('Location: ../paginas/usuario');
    endif;
else :
    header('Location: ../Usuarios/login');
endif;

?>

<?php include '../app/Views/componente/menu_adm.php'; ?>

<?php include '../app/Views/componente/barra-adm.php'; ?>


<div class="adm-container-main">
    <div class="content-form--adm">
        <h1>Cadastrando anime (parte Final)</h1>
        <form action="<?= URL ?>/Animes/cadastroParteQuatro" method="POST" name="cadastroAnime" enctype="multipart/form-data">

            <div class="form-adm-two-list">
                <h2>Adicionar</h2>
                <div class="form-adm-two-list-one">
                    <div class="content-form-camp content-form-camp--100">
                        <label> Abertura</label>
                        <label for="abertura-anime">
                            <img src="<?= URL ?>/img/icones/Upload.png">
                        </label>
                        <input type="file" name="abertura" id="abertura-anime">
                    </div>
                </div>
                <!--fechamento da class"form-adm-two-list-one"-->

                <div class="form-adm-two-list-two">
                    <div class="content-form-camp content-form-camp--100">
                        <label>Enceramento</label>
                        <label for="enceramento-anime">
                            <img src="<?= URL ?>/img/icones/Upload.png">
                        </label>
                        <input type="file" name="enceramento" id="enceramento-anime">

                    </div>
                </div>
                <!--fechmento da class"form-adm-two-list-two"-->
            </div>
            <!--fechamento da class"form-adm-two-list"-->

            <div class="content-form-btns">
                <div class="content-form-btns-voltar">
                    <a href="<?= URL ?>/Animes/cadastroParteTres">
                        <img src="<?= URL ?>/img/icones/anterior.png">
                    </a>
                </div>
                <!--fechamento da class"content-form-btns-voltar"-->
                <div class="content-form-btns-proximo">
                    <label for="proximo">
                        <img src="<?= URL ?>/img/icones/proximo.png">
                    </label>

                    <input type="submit" id="proximo">

                </div>
                <!--fechamento da class"content-form-btns-proximo-->
            </div>
        </form>
    </div>
    <!--fechamento da class"content-form"-->
</div>
<!--fechamento da classe "adm-container-main" -->