<?php

class sobre extends Controller{
    public function index(){
        $dados = [
            'tituloPagina' => 'sobre'
        ];
        $this->view('sobre/index', $dados);
    }
}
