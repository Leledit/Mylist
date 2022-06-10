<?php

class Usuarios extends Controller{

    public function __construct(){
        $this->usuarioModel = $this->model('Usuario');
    }

    public function perfil(){
        $this->view('Usuario/perfil');
    }

    public function usuarios()
    {
        $resultados = $this->usuarioModel->buscalAll();
        $dados= [
            'vals' => $resultados,
        ];
        $this->view('adm/usuarios',$dados);
    }

    public function desativar(){
      

        $indicador = $this->usuarioModel->deletar($_SESSION["usu_id"]);
        if($indicador == true):
            utilities::mensagenAlerta('perfil','Sua conta foi excluida com sucesso');
            $this->logof();
        else:
             utilities::mensagenAlerta('perfil','Um erro desconhecido aconteceu, por favor entre em contato com os administradores');
             utilities::redirecionar('./Usuarios/perfil');
        endif;
      
    }

    public function logof(){

       unset($_SESSION["usu_id"]);
       unset($_SESSION["usu_nome"]);
       unset($_SESSION["usu_email"]);
       unset($_SESSION["usu_nivel"]);
       session_destroy();
       utilities::redirecionar('');
        exit();

    }
    
    public function alterar(){

        $formulario = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        if(isset($formulario)):
            $dados = [
                'senha' => trim($formulario['nome']),
                'email' => trim($formulario['email']),
                'senha_erro' =>'',
                'email_erro' => '',
            ];
        
            //Verificando se a array esta vazia
            if(in_array("",$formulario)):

                //verificando se o campo email esta vazio 
                if(empty($formulario['nome'])):
                    utilities::mensagenAlerta('perfil','O campo nome nao pode estar vazio','alert alert-danger');
                    utilities::redirecionar('./Usuarios/perfil');
                endif;
                 //verificando se o campo email esta vazio 
                 if(empty($formulario['email'])):
                    utilities::mensagenAlerta('perfil','O campo e-mail nao pode estar vazio','alert alert-danger');
                    utilities::redirecionar('./Usuarios/perfil');
                endif;
            else:
                 //caso nao seja vazia, pode ser feitas outras verificaçoes 

                 //verificando se  o campo email tem entre 5 e 64 caracteres 
                 if(Validar::tamanhoPermit($formulario['email'])):
                    utilities::mensagenAlerta('perfil','O campo email Deve posuir entre 5 e 64 caracteres','alert alert-danger');
                    utilities::redirecionar('./Usuarios/perfil');
                    //verificando o campo email, posui um email mesmo
                elseif(Validar::emailValid($formulario['email'])):
                    utilities::mensagenAlerta('perfil','Insira um email valido ','alert alert-danger');
                    utilities::redirecionar('./Usuarios/perfil');
                else:
                    //fim das validaçoes
                    $dados =[
                        'nome'=>$formulario['nome'],
                        'email'=>$formulario['email'],
                        'id'=> $_SESSION["usu_id"]
                    ];
                    $Usuario = $this->usuarioModel->alterar($dados);
                    if($Usuario):
                        utilities::mensagenAlerta('perfil','Dados alterados com sucesso ','alert alert-success');

                    else:
                        utilities::mensagenAlerta('perfil','Erro ao alterar os dados ','alert alert-danger');

                    endif;
                    $this->logof();
                endif;
            endif;
        endif;
      
    
    }

    public function login(){

        $formulario = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        if(isset($formulario)):
            $dados = [
                'senha' => trim($formulario['senha']),
                'email' => trim($formulario['email']),
                'senha_erro' =>'',
                'email_erro' => '',
            ];

          
            //Verificando se a array esta vazia
            if(in_array("",$formulario)):

                //verificando se o campo email esta vazio 
                if(empty($formulario['email'])):
                    $dados['email_erro'] = 'O campo e-mail nao pode estar vazio';
                endif;

                //verificando se o campo senha esta vazio
                if(empty($formulario['senha'])):
                    $dados['senha_erro'] = 'O campo senha nao pode estar vazio';
                endif;

            else:
                //caso nao seja vazia, pode ser feitas outras verificaçoes 

                 //verificando se  o campo email tem entre 5 e 64 caracteres 
                 if(Validar::tamanhoPermit($formulario['email'])):
                    $dados['email_erro'] = 'O campo email Deve posuir entre 5 e 64 caracteres';
                
                     //verificando o campo email, posui um email mesmo
                elseif(Validar::emailValid($formulario['email'])):
                    $dados['email_erro'] = 'Insira um email valido ';

                    //verificando se  o campo senha tem entre 5 e 64 caracteres 
                elseif(Validar::tamanhoPermit($formulario['senha'])):
                    $dados['senha_erro'] = 'O campo senha Deve posuir entre 5 e 64 caracteres';
                
                else:

               
                    $Usuario = $this->usuarioModel->logar($formulario['email'],$formulario['senha']);
                   
                   
                    if($Usuario):
                       $this->criarSessaoUsuario($Usuario);
                      
                       if($Usuario->nivel == 1):
                    
                        utilities::redirecionar('Animes/index');
                       else:
                        utilities::redirecionar('./');
                       endif;  
                       exit();
                    else:
                       utilities::mensagenAlerta('usuario','Usuario ou senha invalidos','alert alert-fall');
                      //  echo ("Usuario ou senha invalidos <hr>") ;

                     
                    endif;
                endif;
            endif;
        else:
            $dados = [
                'senha' => '',
                'email' => '',
                'senha_erro' =>'',
                'email_erro' => '',
            ]; 
        endif;
        
        $this->view('Usuario/login',$dados);
    
    }
    public function cadastro(){

        $formulario = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        if(isset($formulario)):
            $dados = [
                'nome' => trim($formulario['nome']),
                'email' => trim($formulario['email']),
                'senha' => trim($formulario['senha']),
                'confiSenha' => trim($formulario['confiSenha']),
                'nome_erro' => '',
                'email_erro' => '',
                'senha_erro' => '',
                'confiSenha_erro' => '',
                'nivel' => '',
            ];
           
            
            //Verificando se a array esta vazia
            if(in_array("",$formulario)):

                //verificando se o campo nome esta vazio
                if(empty($formulario['nome'])):
                    $dados['nome_erro'] = 'O campo nome nao pode estar vazio';
                endif;

                //verificando se o campo email esta vazio 
                if(empty($formulario['email'])):
                    $dados['email_erro'] = 'O campo email nao pode estar vazio';
                endif;

                //verificando se o campo senha esta vazio
                if(empty($formulario['senha'])):
                    $dados['senha_erro'] = 'O campo senha nao pode estar vazio';
                endif;

                //Verificando se o campo confirmar senha esta vazio
                if(empty($formulario['confiSenha'])):
                    $dados['confiSenha_erro'] = 'O campo confirmar senha nao pode estar vazio';
                endif;

            else:
               
                //verificando se  o campo nome tem entre 5 e 64 caracteres 
                if(Validar::tamanhoPermit($formulario['nome'])):
                    $dados['nome_erro'] = 'O campo nome Deve posuir entre 5 e 64 caracteres';

                    //Verifica se o campo nome possui numeros
                elseif(Validar::apenasCaracteres($formulario['nome'])):
                    $dados['nome_erro'] = 'Nao é permitido numeros no campo nome'; 
                     
               
                    //verificando se  o campo email tem entre 5 e 64 caracteres 
                elseif(Validar::tamanhoPermit($formulario['email'])):
                    $dados['email_erro'] = 'O campo email Deve posuir entre 5 e 64 caracteres';
                
                     //verificando o campo email, posui um email mesmo
                elseif(Validar::emailValid($formulario['email'])):
                    $dados['email_erro'] = 'Insira um email valido ';

                    //verificando se o email ja esta cadastrado no banco de dados
                elseif($this->usuarioModel->checarEmail($formulario['email'])):
                    $dados['email_erro'] = 'E-mmail ja cadastrado no sistema ';

                     //verificando se  o campo senha tem entre 5 e 64 caracteres 
                elseif(Validar::tamanhoPermit($formulario['senha'])):
                    $dados['senha_erro'] = 'O campo senha Deve posuir entre 5 e 64 caracteres';
                
                    //verificando se  o campo comfirmar senha  tem entre 5 e 64 caracteres 
                elseif(Validar::tamanhoPermit($formulario['confiSenha'])):
                    $dados['confiSenha_erro'] = 'O campo confirmar senha  Deve posuir entre 5 e 64 caracteres';
                    
                    //verificando se o campo senha e confirmar senha sao iguais
                elseif($formulario['senha'] != $formulario['confiSenha']):
                    $dados['confiSenha_erro'] = 'O campo confirmar senha  e senha devem ser iguais'; 
                
                else :

                    //Aparti daqui os dados ja podem ser enviados para o banco de dados
                    $dados['senha'] = password_hash($formulario['senha'],PASSWORD_DEFAULT);
                    $dados['nivel'] = 2;

                   // echo "dados:<br>",$dados['nome'],"<br>",$dados['email'],"<br>",$dados['senha'],"<br>",$dados['nivel'],"<br>";
                   
                    if ($this->usuarioModel->armazenar($dados)) :
                        
                        $Usuario =$this->usuarioModel->logar($formulario['email'],$formulario['senha']);
                   
                        if($Usuario):
                           $this->criarSessaoUsuario($Usuario);
                             
                           utilities::redirecionar('./');
                           exit();
                        else:
                            utilities::mensagenAlerta('usuarioCadastro','Um erro inesperado acomteceu','alert alert-fall');
                        endif;
                       exit();

                    else :
                        die("Erro ao armazenar usuario no banco de dados");
                    endif;
                endif;
            endif;
        else:
            $dados =[
                'nome' => '',
                'email' => '',
                'senha' => '',
                'confiSenha' => '',
                'nome_erro' => '',
                'email_erro' => '',
                'senha_erro' => '',
                'confiSenha_erro' => '',
                'nivel' => '',
            ];

        endif;
        $this->view('Usuario/cadastro' ,$dados); 
    }
  
    private function criarSessaoUsuario($usuario){

        $_SESSION["usu_id"] = $usuario->id;
        $_SESSION["usu_nome"] = $usuario->nome;
        $_SESSION["usu_email"] = $usuario->email;
        $_SESSION["usu_nivel"] = $usuario->nivel;

    }//Fechamento da funçao criarSessaoUsuario 
}
