<?php

class genero
{
    private $db;


    public function __construct()
    {

        $this->db = new Database();
    } //fechamento do metodo contrutor

    public function Cadastrar($dados, $idImg)
    {
        $this->db->query("INSERT INTO genero(nome,categoria,id_img) VALUES(:nome, :categoria, :id_img) ");
        $this->db->bind("nome", $dados['nome']);
        $this->db->bind("categoria", $dados['categoria']);
        $this->db->bind("id_img", $idImg[0]->id);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    } //fechamento da função de armazenagem dos dados

    public function atualizar($nome, $id)
    {
        $this->db->query("UPDATE genero SET nome =:nome WHERE id = :id");
        $this->db->bind("nome", $nome);
        $this->db->bind("id", $id);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }

    public function exibir($categoria, $limite, $inicio)
    {
        $this->db->query("SELECT gen.id, gen.nome,img.url FROM genero gen INNER JOIN imagens img on gen.id_img = img.id where gen.categoria = :categoria LIMIT " . $inicio . "," . $limite . " ");
        $this->db->bind('categoria', $categoria);
        return $this->db->resultados();
    }
    public function exibirQtd($categoria)
    {
        $this->db->query("SELECT * FROM genero  where categoria = :categoria");
        $this->db->bind('categoria', $categoria);
        $this->db->executa();
        return $this->db->totalResultados();
    }

    public function exibirID($id)
    {
        $this->db->query("SELECT gen.id_img,gen.id, gen.nome,img.url FROM genero gen INNER JOIN imagens img on gen.id_img = img.id where  gen.id= :id ");
        $this->db->bind("id", $id);
        return $this->db->resultados();
    }

    public function buscar($busca, $indicacao)
    {
        $this->db->query("SELECT gen.id, gen.nome,img.url,img.id FROM genero gen INNER JOIN imagens img on gen.id_img = img.id  WHERE categoria = :indicacao AND (nome LIKE '%' :busca '%') ");
        $this->db->bind("busca", $busca);
        $this->db->bind("indicacao", $indicacao);
        return $this->db->resultados();
    }
    public function buscarNome($nome, $categoria)
    {
        $this->db->query("SELECT nome FROM genero  WHERE categoria = :categoria AND nome = :n");
        $this->db->bind("n", $nome);
        $this->db->bind("categoria", $categoria);
        $result = $this->db->resultados();
        return $result;
    }



    public function deletar($id)
    {
        $this->db->query(" DELETE FROM `genero` WHERE id = :id ");
        $this->db->bind("id", $id);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }
}
