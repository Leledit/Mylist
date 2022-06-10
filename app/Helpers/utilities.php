<?php

class utilities
{

    public static function redirecionar($url)
    {
        //header - Envia um cabeçalho HTTP
        //DIRECTORY_SEPARATOR - coloca o caracter barra que é o separador de diretorio
        header("Location:" . URL . DIRECTORY_SEPARATOR . $url);
    }

    public static function trocarSession(){
        if(($_SESSION['SEGMENT'] == 'ANIMES')):
            $_SESSION['SEGMENT'] = 'FILMESSERIES';
        else:
            $_SESSION['SEGMENT'] = 'ANIMES';
        endif;
    }
    public static function resumirTexto($texto, $limite, $continue = null)
    {

        $textoLimpo = strip_tags(trim($texto));
        $limiteTexto = (int) $limite;
        $array = explode(' ', $textoLimpo);
        $totalPalavras = count($array);
        $textoResumido = implode(' ', array_slice($array, 0, $limiteTexto));
        $lerMais = (empty($continue) ? ' ...' : ' ' . $continue);
        $resultado = ($limite < $totalPalavras ? $textoResumido . $lerMais : $texto);

        return $resultado;
    }
    public static function verifiUsuarioSessao()
    {

        if (isset($_SESSION['usu_nivel'])) :
            if ($_SESSION['usu_nivel'] != 1) :
                header('Location: ../Usuarios/login');
            endif;
        else :
            header('Location: ../Usuarios/login');
        endif;
    }

    public static function mensagenAlerta($nome, $mensagem = null, $classe = null)
    {
        if (!empty($nome)) :
            if (!empty($mensagem) && empty($_SESSION[$nome])) :
                if (!empty($_SESSION[$nome])) :
                    unset($_SESSION[$nome]);
                endif;
                $_SESSION[$nome] = $mensagem;
                $_SESSION[$nome . 'classe'] = $classe;

            elseif (!empty($_SESSION[$nome]) && empty($mensagem)) :
                $classe = !empty($_SESSION[$nome . 'classe']) ?  $_SESSION[$nome . 'classe'] : 'alert alert-success';
                echo '<div class="' . $classe . '">' . $_SESSION[$nome] . '</div>';

                unset($_SESSION[$nome]);
                unset($_SESSION[$nome . 'classe']);

            endif;
        endif;
    }
}
