<div class="container">
    <div class="" role="alert">
        <?= utilities::mensagenAlerta('perfil') ?>
    </div>
    <div class="perfil">
        <h4>Dados pessoais</h4>
        <div class="perfil-dados">
            <div class="perfil-item"><b>Nome:</b> <?= $_SESSION['usu_nome'] ?></div>
            <div class="perfil-item"><b>Email:</b> <?= $_SESSION['usu_email'] ?></div>
            <div class="perfil-item"><b>Senha:</b> ************</div>
            <div class="perfil-item"><b>Status conta:</b> Ativa</div>
        </div>
        <div class="perfil-ops mb-5">
            <div class="perfil-op col-xl-2 col-lg-3 col-md-5 col-sm-5" data-bs-toggle="modal" data-bs-target="#alterarDados"><a href="# " class="nav-link">Alterar dados</a></div>
            <div class="perfil-op col-xl-2 col-lg-3 col-md-5 col-sm-5  " data-bs-toggle="modal" data-bs-target="#desativar"><a href="#" class="nav-link">Excluir conta</a></div>
            <div class="space">.</div>
        </div>
    </div>
</div>

<!---- modal de alteração dos dados -->

<div class="modal fade" id="alterarDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alterar Dados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= URL ?>/Usuarios/alterar" method="post" name="perfil">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Nome:</label>
                        <input type="text" name="nome" class="form-control" id="nome" value="<?= $_SESSION['usu_nome'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">E-mail:</label>
                        <input type="text" name="email" class="form-control" id="email" value="<?= $_SESSION['usu_email'] ?>">
                    </div>
                    <div class="mb-3">
                        <P>Infelismente ainda nao é possivel alterar sua senha..</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary mb-3" value="Enviar">Alterar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</div>
<!--Modal para a desativação da conta -->
<div class="modal" tabindex="-1" id="desativar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir conta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Voce deseja realmente excluira sua conta? </p>
            </div>
            <div class="modal-footer">
                <a href="<?= URL ?>/Usuarios/desativar" class="btn btn-secondary">Excluir</a>
            </div>
        </div>
    </div>
</div>