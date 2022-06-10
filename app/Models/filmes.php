<?php

class filmes
{
    private $db;


    public function __construct()
    {

        $this->db = new Database();
    } //fechamento do metodo contrutor

    public function UltimoRegistro()
    {
        $this->db->query("SELECT id FROM filmes order by id DESC LIMIT 1");
        return $this->db->resultados();
    }

    public function Cadastrar($dados)
    {
        $this->db->query("INSERT INTO filmes( `id_img`, `nome`, `sinops`, `duracao`, `lancamento`)
     VALUES (:id_img,:nome,:sinops,:duracao,:lancamento)");
        $this->db->bind("id_img", $dados['id_img']);
        $this->db->bind("nome", $dados['nome']);
        $this->db->bind("sinops", $dados['sinops']);
        $this->db->bind("duracao", $dados['duracao']);
        $this->db->bind("lancamento", $dados['lancamento']);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    } //fechamento da função de armazenagem dos dados

    public function buscarRegistros($limite, $inicio)
    {
        $this->db->query("SELECT fil.id , fil.nome,img.url , img.id as imgID FROM filmes fil
     left outer join imagens img on fil.id_img = img.id ORDER BY  fil.id DESC  LIMIT " . $inicio . "," . $limite . " ");
        return $this->db->resultados();
    }

    public function buscar($buscar, $limite, $inicio)
    {
        $this->db->query("SELECT fil.id , fil.nome,img.url , img.id as imgID FROM filmes fil
     left outer join imagens img on fil.id_img = img.id where (fil.nome LIKE '%' :buscar '%') ORDER BY  fil.id DESC LIMIT " . $inicio . "," . $limite . " ");
        $this->db->bind("buscar", $buscar);
        return $this->db->resultados();
    }
    public function buscarqtd($buscar)
    {
        $this->db->query("SELECT fil.id , fil.nome,img.url , img.id as imgID FROM filmes fil
     left outer join imagens img on fil.id_img = img.id where (fil.nome LIKE '%' :buscar '%') ORDER BY  fil.id DESC ");
        $this->db->bind("buscar", $buscar);
        $this->db->executa();
        return $this->db->totalResultados();
    }

    public function buscarPorGenero($id, $limite, $inicio)
    {
        $this->db->query("SELECT fil.nome ,fil.id, img.id as imgID, img.url FROM filmes fil LEFT OUTER JOIN
         imagens img on img.id = fil.id_img INNER JOIN filme_has_genero filGen on
          filGen.id_filme = fil.id INNER join genero gen on gen.id = filGen.id_genero WHERE gen.id = :id
    ORDER BY  fil.id DESC  LIMIT " . $inicio . "," . $limite . " ");
        $this->db->bind("id", $id);
        return $this->db->resultados();
    }

    public function buscarPorGeneroQtd($id)
    {
        $this->db->query("SELECT fil.nome ,fil.id, img.id as imgID, img.url FROM filmes fil LEFT OUTER JOIN
         imagens img on img.id = fil.id_img INNER JOIN filme_has_genero filGen on filGen.id_filme = fil.id
          INNER join genero gen on gen.id = filGen.id_genero WHERE gen.id = :id
    ORDER BY  fil.id DESC");
        $this->db->bind("id", $id);
        $this->db->executa();
        return $this->db->totalResultados();
    }
    public function retornarQtdRegistro()
    {
        $this->db->query("SELECT fil.id , fil.nome,img.url , img.id as imgId FROM filmes fil left outer join imagens img on fil.id_img = img.id  ");
        $this->db->executa();
        // $this->db->query("SELECT * FROM animes ");
        return $this->db->totalResultados();
    }

    public function buscarPorID($id)
    {
        $this->db->query("SELECT fil.id , fil.nome,img.url , img.id as imgID,
    fil.sinops ,fil.duracao ,fil.lancamento FROM filmes fil left outer join
     imagens img on fil.id_img = img.id WHERE fil.id = :id");
        $this->db->bind("id", $id);
        return $this->db->resultado();
    }

    public function buscarIDimg($id)
    {
        $this->db->query("SELECT img.id ,img.url FROM filmes fil left outer join
    imagens img on fil.id_img = img.id WHERE fil.id = :id");
        $this->db->bind("id", $id);
        return $this->db->resultado();
    }

    public function atualizarDados($dados)
    {
        $this->db->query("UPDATE filmes SET nome = :nome , sinops = :sinops,
    duracao=:duracao,lancamento=:lancamento WHERE  id = :id");
        $this->db->bind("nome", $dados['nome']);
        $this->db->bind("sinops", $dados['sinops']);
        $this->db->bind("duracao", $dados['duracao']);
        $this->db->bind("lancamento", $dados['lancamento']);
        $this->db->bind("id", $dados['id']);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }

    public function deletar($id)
    {
        $this->db->query("DELETE FROM filmes  WHERE  id = :id");
        $this->db->bind("id", $id);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }
}
