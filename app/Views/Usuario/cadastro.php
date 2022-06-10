<Script laguage="javaScript">
  function validarFomr() {

    //iniciando as verificaçoes via js
    //verificando o campo nome
    var nome_reb = document.forms["cadastroUsu"].nome.value.length;

    if (nome_reb < 5 || nome_reb > 64) {
      alert("o campo nome deve ter entre 5 e 64 caracteres");
      return false;
    }

    //verificando o campo email
    var email_reb = document.forms["cadastroUsu"].email.value;

    if (email_reb.length < 5 || email_reb.length > 64) {
      alert("o campo email deve ter entre 5 e 64 caracteres");
      return false;
    }
    if (email_reb.indexOf('@') == -1 || email_reb.indexOf('.') == -1) {
      alert("o campo email deve ser prenchido de forma correta");
      return false;
    }

    //verificando o campo senha e confirmar senha
    var senha_reb = document.forms["cadastroUsu"].senha.value;
    var confiSenha_reb = document.forms["cadastroUsu"].confiSenha.value;

    if (senha_reb.length < 6 || senha_reb.length > 25) {
      alert("o campo senha deve posuir entre 6 e 24 caracteres");
      return false;
    }
    if (senha_reb != confiSenha_reb) {
      alert("o campo senha e confirmar senha devem ser iguais");
      return false;
    }

    document.forms["cadastroUsu"].submit();
  }
</Script>

<div class="page_contente">


  <div class="row align-items-start">
    <div class="col-lg col-md col-sm">
    </div>
    <div class="contat col-lg-6 col-md-7 col-sm-9">
      <h1>Cadastro</h1>
      <P>Bem vindo!! para realizar o seu cadastro é necessário preencher todos os campos abaixo.</P>
      <form action="<?= URL ?>/Usuarios/cadastro" method="POST" name="cadastroUsu">
        <div class="mb-3">
          <label for="InputNome" class="form-label">Nome: <span>*</span></label>
          <input type="text" class="form-control" id="InputNome" autofocus placeholder="Insira seu nome" name="nome" value="<?= $dados['nome'] != '' ? $dados['nome'] : '' ?>" required>
          <div class="content-form-camp-error">
            <?= $dados["nome_erro"] ?>
          </div>


        </div>
        <div class="mb-3">
          <label for="InputEmail1" class="form-label">Email: <span>*</span> </label>
          <input type="email" class="form-control" id="InputEmail1" placeholder="Insira seu email" name="email" value="<?= $dados['email'] != '' ? $dados['email'] : '' ?>" required>
          <div class="content-form-camp-error">
            <?= $dados["email_erro"] ?>
          </div>
        </div>
        <div class="mb-3">
          <label for="InputSenha" class="form-label">Senha: <span>*</span></label>
          <input type="password" class="form-control" id="InputSenha" name="senha" value="<?= $dados['senha'] ?>" placeholder="Insira sua senha" required>
          <div class="content-form-camp-error">
            <?= $dados['senha_erro'] ?>
          </div>
        </div>

        <div class="mb-3">
          <label for="InputConfSenha" class="form-label">Confirmar Senha: <span>*</span></label>
          <input type="password" class="form-control" id="InputConfSenha" placeholder="Confirme sua senha" name="confiSenha" value="<?= $dados['confiSenha'] ?>" required>
          <div class="content-form-camp-error">
            <?= $dados['confiSenha_erro'] ?>
          </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end btn-lg">
          <button type="submit" class="btn btn-primary mb-3 " value="Enviar">Enviar</button>
        </div>

        <h6>Ja posui conta? click<a href="<?= URL ?>/Usuario/login"> aqui </a> para fazer o login<h6>
            <!-- aqui sera exibido as possiveis mensagens de erro-->
            <?php if (isset($_SESSION['usuario'])) : ?>
              <div class="alert alert-danger" role="alert">
                <?= utilities::mensagenAlerta('usuarioCadastro') ?>
              </div>
            <?php endif ?>

      </form>

    </div>
    <div class="col-lg col-md col-sm">
    </div>
  </div>
</div>
<!--fechamento da div pricipal da pagina-->
</div>