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
            <div class="adm-filt">
                <div class="adm-espacing">.</div>
                <h1>Aplicando filtros</h1>
                <form action="<?= URL ?>/adm/filtros/0/busc" method="POST">
                    <div class="row">
                        <div class="col-xl-6 col-lg-5 col-md-10 col-sm-10 ms-md-4">
                            <h2>Buscar por</h2>
                            <input class="form-control " type="search" placeholder="Buscar" name="busca" id="filter-busc">
                        </div>
                        <div class="col-xl col-lg col-md col-sm ms-md-3 ms-md-4">
                            <h2>Parametros</h2>
                            <div class="row">
                                <div class="col form-chec">
                                    <input class="form-check-input" type="radio" checked name="indicadorBusca" value="Anime" id="anime">
                                    <label class="form-check-label" for="anime">
                                        Anime
                                    </label>
                                </div>
                                <div class="col form-chec">
                                    <input class="form-check-input" type="radio" name="indicadorBusca" value="Filme" id="filme">
                                    <label class="form-check-label" for="filme">
                                        Filmes
                                    </label>
                                </div>
                                <div class="col form-chec">
                                    <input class="form-check-input" type="radio" name="indicadorBusca" value="generos" id="generos">
                                    <label class="form-check-label" for="generos">
                                        Genero
                                    </label>
                                </div>

                            </div>
                            <h2>Limitador:</h2>
                            <select name="Limite" class="form-select" id="filter-limit">
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                            </select>


                        </div>
                    </div>

                    <div class="row mt-4 ms-3 ">
                        <div class="col-10"></div>
                        <div class="col"><button class="btn btn-outline-success" type="submit">Buscar</button></div>
                        <div class="col"></div>
                    </div>
                    <div class="adm-espacing">.</div>

                    <!-- <?= $_SESSION['FiltroListBusc'] ?>-->
                </form>

            </div>
            <!-- Inicio da parte de exibição dos dados-->



            <?php if ($_SESSION['FiltroList'] != 'all') : ?>
                <div class="adm-filt ">
                    <div class="adm-espacing">.</div>
                    <h2>Resultados:</h2>
                    <div class="mx-2 row">
                        <?php
                        if ($_SESSION['FiltroList'] == 'genero') :
                            foreach ($dados['valor'] as $dado) :
                        ?>
                                <div class="content-usu-unit col-xl-4 col-lg-5 col-md-5 col-sm-11  mx-md-3  mx-lg-0">
                                    <a href="<?= URL ?>/animes/item/<?= $dado->id ?>">
                                        <div class="content-usu-unit-img">
                                            <img src="<?= URL ?>/<?= $dado->imgID == 0 ? 'img/padrao.jpg' : $dado->url  ?>">
                                        </div>
                                        <!--fechamento da classe "content-usu-unit-img"-->
                                        <div class="content-usu-unit-name">
                                            <?= $dado->nome ?>
                                        </div>
                                    </a>
                                    <!--fechamento da classe "content-usu-unit-name-->
                                </div>
                                <!--fechamento da class"content-usu-unit"-->
                            <?php
                            endforeach;

                        elseif ($_SESSION['FiltroList'] == 'busc') :

                           
                            if (mb_strlen($_SESSION['FiltroListBusc']) == 0) :
                            ?>
                                <div class="alert alert-warning text-center" role="alert">
                                    O campo de busca nao pode estar vazio!!
                                </div>

                                <?php
                            else :
                                if ($dados['valor'] == null) :
                                ?>
                                    <div class="alert alert-warning text-center" role="alert">
                                        Ops parece que nao temos nada relacionado a isso
                                    </div>
                                    <?php
                                else :
                                    //verificando qual tipo de pesquisa foi escolhido, definindo valores referente ao funcionamento do mesmo
                                    if ($_SESSION['parametroBusck'] == 'Anime') :
                                        $paginaReds = "animes/item/";
                                        $imgItem = 'imgID';
                                        $refs = 'valor';
                                    elseif ($_SESSION['parametroBusck'] == 'Filme') :
                                        $paginaReds = "filmesSeries/item/";
                                        $imgItem = 'imgID';
                                        $refs = 'valor';
                                    elseif ($_SESSION['parametroBusck'] == 'generos') :
                                        $paginaReds = "Generos/verGenero/";
                                        $imgItem = 'id';
                                        $refs = 'generos';
                                    // $imgItem = 'imgID';
                                    endif;

                                    foreach ($dados['valor'] as $dado) :
                                    ?>
                                        <div class="content-usu-unit col-xl-4 col-lg-5 col-md-5 col-sm-11  mx-md-3  mx-lg-0">
                                            <a href="<?= URL ?>/<?= $paginaReds ?><?= $dado->id ?>">
                                                <div class="content-usu-unit-img">
                                                    <img src="<?= URL ?>/<?= $dado->$imgItem == 0 ? 'img/padrao.jpg' : $dado->url  ?>">
                                                </div>
                                                <!--fechamento da classe "content-usu-unit-img"-->
                                                <div class="content-usu-unit-name">
                                                    <?= $dado->nome ?>
                                                </div>
                                            </a>
                                            <!--fechamento da classe "content-usu-unit-name-->
                                        </div>
                                        <!--fechamento da class"content-usu-unit"-->
                        <?php
                                    endforeach;
                                endif;
                            endif;
                        endif;
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>