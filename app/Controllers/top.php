<?php

class top extends Controller{
   
    public function index(){  
        $dados = [
            'tituloPagina' => 'Top 10'
        ];
        $this->view('top10/index', $dados);
    }
}
