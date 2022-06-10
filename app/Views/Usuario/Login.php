<Script language="javaScript">
  function validarForm() {

    var email_receb = document.forms["formLogin"].email.value;
    var senha_receb = document.forms["formLogin"].senha.value;


    if (email_receb.length < 5 || email_receb.length > 64) {
      alert("o campo e-mail deve posuir entre 5 e 64 caracteres");
      return false;
    }
    if (email_receb.indexOf('@') == -1 || email_receb.indexOf('.') == -1) {
      alert("o campo e-mail deve ser prenchido de forma correta");
      return false;
    }
    if (senha_receb.length < 5 || senha_receb.length > 25) {
      alert("o campo senha deve posuir entre 5 e 25 caracteres");
      return false;
    }




    document.forms["formLogin"].submit();


  } //fechamento da funçao 
</Script>

<div class="page_contente">
  <div class="row align-items-start">



    <div class="col-lg col-md col-sm">
    </div>
    <div class="contat col-lg-6 col-md-7 col-sm-9">


      <h1>Login</h1>
      <P>Bem vindo!! para efetuar o seu logim basta entrar com o seu e-mail e sua senha .</P>
      <form action="<?= URL ?>/Usuarios/login/" method="POST" name="formLogin">
        <div class="mb-3 <?= $dados['email_erro'] ? 'forme-erro' : '' ?> ">
          <label for="InputEmail1" class="form-label">Email: <span>*</span> </label>
          <input type="email" class="form-control" id="InputEmail1" placeholder="Insira seu email" name="email" value="<?= $dados['email'] != '' ? $dados['email'] : '' ?>">
          <div class="content-form-camp-error">
            <?= $dados["email_erro"] ?>
          </div>
        </div>
        <div class="mb-3 <?= $dados['senha_erro'] ? 'forme-erro' : '' ?> ">
          <label for="InputSenha" class="form-label">Senha: <span>*</span></label>
          <input type="password" class="form-control" id="InputSenha" name="senha" value="<?= $dados['senha'] ?>">
          <div class="content-form-camp-error">
            <?= $dados['senha_erro'] ?>
          </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end btn-lg">
          <button type="button" class="btn btn-primary mb-3 " value="Login" onclick="validarForm()">Login</button>

        </div>
        <h6>Não posui conta? faça o seu cadastro <a href="<?= URL ?>/Usuarios/cadastro" class="nav-link">aqui</a>
          <h6>
            <!-- aqui sera exibido as possiveis mensagens de erro-->
            <?php if (isset($_SESSION['usuario'])) : ?>
              <div class="alert alert-danger" role="alert">
                <?= utilities::mensagenAlerta('usuario') ?>
              </div>
            <?php endif; ?>
      </form>

    </div>
    <div class="col-lg col-md col-sm">
    </div>
  </div>


</div>
<!--fechamento da div pricipal da pagina-->
</div>