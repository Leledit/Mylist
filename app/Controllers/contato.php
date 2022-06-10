<?php

class contato extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {
        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($formulario)) :
            $dados = [
                'nome' => $formulario['nome'],
                'email' => $formulario['email'],
                'assunto' => $formulario['assunto'],
                'mensagem' => $formulario['mensagem'],
                'nome_erro' => '',
                'email_erro' => '',
                'assunto_erro' => '',
                'mensagem_erro' => '',
            ];
            if (Validar::apenasCaracteres($dados['nome'])) :
                $dados['nome_erro'] = 'so é permitido caracteres';
            else :
                if (Validar::tamanhoPermit($dados['nome'])) :
                    $dados['nome_erro'] = 'Quantidade de caracteres invalida';
                else :
                    if (Validar::tamanhoPermit($dados['email'])) :
                        $dados['email_erro'] = 'Quantidade de caracteres invalida';
                    else :
                        if (Validar::tamanhoPermit($dados['assunto'])) :
                            $dados['assunto_erro'] = 'Quantidade de caracteres invalida';
                        else :
                            if (Validar::tamanhoPermitTextArea($dados['mensagem'])) :
                                $dados['mensagem_erro'] = 'Quantidade de caracteres invalida';
                            else :
                                $subject = "Assunto".$dados['assunto']." De:".$dados['nome']." E-mail:".$dados['email'];
                               if(mail('leandro_ricardo99@outlook.com', $subject, $dados['mensagem'])):
                                utilities::mensagenAlerta('contato','mensagem enviado com sucesso') ;
                                utilities::redirecionar('contato');
                               else:
                                utilities::mensagenAlerta('Admitem', 'Erro Desconhecido ao enviar a mensagem', 'alert alert-fall');
                                utilities::redirecionar('contato');
                                endif;
                                echo 'cheguei aqui';
                            endif; //verificação de qtd mensagme
                        endif; //verificação de qtd assunto
                    endif; //verificação de qtd email
                endif; //verificação de qtd caracteres nome
            endif; //verificação de caracteres nome
        else :
            $dados = [
                'nome' => '',
                'email' => '',
                'assunto' => '',
                'mensagem' => '',
                'nome_erro' => '',
                'email_erro' => '',
                'assunto_erro' => '',
                'mensagem_erro' => '',
            ];
        endif;
        $this->view('contato/index', $dados);
    }
}
