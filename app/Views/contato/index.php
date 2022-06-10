<div class="page_contente">


  <div class="row align-items-start">
    <div class="col-lg col-md col-sm">
    </div>
    <div class="contat col-lg-6 col-md-7 col-sm-9">
      <h1>Contato</h1>
      <P>Bem vindo a pagina de contato, aqui é possível enviar uma mensagem os admiradores do site..fique a vontade para mandar suas criticar e sugestões.</P>
      <form action="<?= URL ?>/contato" method="POST" name="contato">
        <div class="mb-3">
          <label for="InputNome" class="form-label">Nome: <span>*</span></label>
          <input type="text" class="form-control" id="InputNome" autofocus placeholder="Insira seu nome" name="nome" value="<?= $dados['nome'] != '' ? $dados['nome'] : '' ?>">
          <div class="content-form-camp-error">
            <?= $dados["nome_erro"] ?>
          </div>


        </div>
        <div class="mb-3">
          <label for="InputEmail1" class="form-label">Email: <span>*</span> </label>
          <input type="email" class="form-control" id="InputEmail1" placeholder="Insira seu email" name="email" value="<?= $dados['email'] != '' ? $dados['email'] : '' ?>">
          <div class="content-form-camp-error">
            <?= $dados["email_erro"] ?>
          </div>
        </div>
        <div class="mb-3">
          <label for="InputAssunto" class="form-label">Assunto: <span>*</span></label>
          <input type="text" class="form-control" id="InputAssunto" name="assunto" value="<?= $dados['assunto'] != '' ? $dados['assunto'] : '' ?>" placeholder="Insira o assunto">
          <div class="content-form-camp-error">
            <?= $dados["assunto_erro"] ?>
          </div>
        </div>
        <div class="mb-3">
          <label for="TextareaMensagem" class="form-label">Mensagem: <span>*</span></label>
          <textarea class="form-control" id="TextareaMensagem" rows="3" placeholder="Insira a mensagem" name="mensagem"><?= $dados['mensagem'] != '' ? $dados['mensagem'] : '' ?></textarea>
          <div class="content-form-camp-error">
            <?= $dados["mensagem_erro"] ?>
          </div>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end btn-lg">
          <button type="submit" class="btn btn-primary mb-3 " value="Enviar">Enviar</button>
        </div>
      </form>

    </div>
    <div class="col-lg col-md col-sm">
    </div>
  </div>
</div>
</div>
<!--fechamento da div pricipal da pagina-->