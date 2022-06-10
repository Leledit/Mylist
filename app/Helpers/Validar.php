<?php

class Validar
{
    public static function tamanhoPermit($nome)
    {
        if (strlen($nome) < 2 || strlen($nome) > 64) {
            return true;
        } else {
            return false;
        }
    } //fechamento da função tamanho_5_64

    public static function tamanhoPermitTextArea($nome)
    {
        if (strlen($nome) < 3 || strlen($nome) > 1800) {
            return true;
        } else {
            return false;
        }
    } //fechamento da função tamanho_5_64

    public static function validarData($date)
    {
        $arrayDate = explode('-', $date);
        $dia = (int)$arrayDate[2];
        $mes = (int)$arrayDate[1];
        $ano = (int)$arrayDate[0];

        if (checkdate($mes, $dia, $ano)) :
            return true;
        else :
            return false;
        endif;
    }

    public static function apenasNumeros($numero)
    {
        if (!is_numeric($numero)) {
            return true;
        } else {
            return false;
        }
    }


    public static function emailValid($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) :
            return true;
        else :
            return false;
        endif;
    } //fechamento da função emailValid

    public static function qtdintNumero($numero, $tamanho)
    {

        if (strlen($numero) < $tamanho) :
            return true;
        else :
            return false;
        endif;
    }
    public static function apenasCaracteres($nome)
    {
        if (!preg_match('/^([áÁàÀãÃâÂéÉèÈêÊíÍìÌóÓòÒõÕôÔúÚùÙçÇ&0-9aA-zZ]+)+((\s[áÁàÀãÃâÂéÉèÈêÊíÍìÌóÓòÒõÕôÔúÚùÙçÇ&0-9aA-zZ]+)+)?$/', $nome)) :
            return true;
        else :
            return false;
        endif;
    }
}
