<?php

class Upload
{

    private  $extencao_arquivo;
    private $destino;
    private $tipo;
    private $tamanho;
    private $arquivo;
    private $resultado;
    private $erro;
    private $nometyp;
    private $nomeImg;

    public function __construct()
    {
    }

    public function imagem($imagem, $destino, $nomeImg)
    {
        $this->arquivo = (array)$imagem;

        $this->tamanho = $this->arquivo['size'];
        $this->tipo = $this->arquivo['type'];
        $this->extencao_arquivo = strtolower(substr($this->arquivo['name'], -4));
        $this->destino = 'C:\wamp64\www\MyList\public\img' . DIRECTORY_SEPARATOR . $destino . DIRECTORY_SEPARATOR;
        $this->nometyp = $this->arquivo['tmp_name'];
        $this->nomeImg = $nomeImg;

        $extensaoValida = [
            '.png',
            '.PNG',
            '.jPG',
            '.jpg',
            '.jpeg',
            '.JPEG',
        ];
        $tipoValido = [
            'image/png',
            'image/PNG',
            'image/JPG',
            'image/jpg',
            'image/jpeg',
        ];

        if (!in_array($this->tipo, $tipoValido)) :
            $this->erro = 'Formato invalido';
        else :
            if (!in_array($this->extencao_arquivo, $extensaoValida)) :
                $this->erro = 'Extensao invalida';
            else :
                if ($this->tamanho > 2 * (1024 * 1024)) :
                    $this->erro = 'Arquivo muito grande';
                else :
                    $this->moverArquivo();
                endif;
            endif;
        endif;
    }


    public function getResultado()
    {
        return $this->resultado;
    }

    public function getErro()
    {
        return $this->erro;
    }

    private function moverArquivo()
    {
        if (move_uploaded_file($this->nometyp, $this->destino . $this->nomeImg . $this->extencao_arquivo)) :
            //se chegou aqui, quer dizer que passou por tudo
            $this->resultado = 'Pode enviar';
        else :
            $this->erro = 'erro desconhecido ao mover a imagem';
        endif;
    }
}
