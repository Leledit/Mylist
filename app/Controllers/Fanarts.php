<?php

class Fanarts extends Controller
{

    public function __construct()
    {
        //função que verifica se o usuario é um adm, se nao for ele é redirecionado
        utilities::verifiUsuarioSessao();
        //definindo qual
    }

    public function index()
    {
        $_SESSION['SEGMENT'] = 'FANARTS';
        $this->view('Adm/Fanarts/index');
    }
    public function cadastro()
    {
        $this->view('Adm/Fanarts/cadastro');
    }
}
