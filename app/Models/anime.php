<?php

class anime
{
    private $db;


    public function __construct()
    {

        $this->db = new Database();
    } //fechamento do metodo contrutor


    public function buscarNomeGenero($id)
    {

        $this->db->query("select nome from genero where id = :id");
        $this->db->bind("id", $id);
        $result = $this->db->resultado();
        return $result;
    }

    public function UltimoRegistro()
    {
        $this->db->query("SELECT id FROM animes order by id DESC LIMIT 1");
        return $this->db->resultados();
    }

    public function buscarPorID($id)
    {
        $this->db->query("SELECT img.id as imgID,img.url,an.estado ,an.formato ,an.qtd_episodios,an.anterior_temp,an.filmes,an.sinops,an.proxima_temp ,an.lancamento, an.nome, an.id, an.qtd_oval  FROM animes an LEFT OUTER JOIN imagens img on img.id = an.id_imagem WHERE an.id = :id");
        $this->db->bind("id", $id);
        return $this->db->resultado();
    }

    public function buscarInfoImg($id)
    {
        $this->db->query("SELECT img.id ,img.url FROM animes an LEFT OUTER JOIN imagens img on img.id = an.id_imagem WHERE an.id = :id");
        $this->db->bind("id", $id);
        return $this->db->resultado();
    }

    public function buscar($valor)
    {
        $this->db->query("SELECT img.id as imgID,img.url,an.estado ,an.formato ,an.qtd_episodios,
    an.anterior_temp,an.filmes,an.sinops,an.proxima_temp ,an.lancamento, an.nome , an.id,
     an.qtd_oval  FROM animes an LEFT OUTER JOIN imagens img on img.id = an.id_imagem 
     where (an.nome LIKE '%' :busca '%') ");
        $this->db->bind("busca", $valor);
        return $this->db->resultados();
        //or (an.sinops LIKE '%' :busca '%')
    }

    public function qtdBusca($valor)
    {
        $this->db->query("SELECT img.id as imgID,img.url,an.estado ,an.formato ,an.qtd_episodios,
    an.anterior_temp,an.filmes,an.sinops,an.proxima_temp ,an.lancamento, an.nome as aniNome, an.id,
     an.qtd_oval  FROM animes an LEFT OUTER JOIN imagens img on img.id = an.id_imagem 
     where (an.nome LIKE '%' :busca '%') ");
        $this->db->bind("busca", $valor);
        $this->db->executa();
        return $this->db->totalResultados();
    }



    public function alterarDados($dados, $part)
    {
        if ($part == 1) :
            //aqui seram feita as alteraçoes das primeiras infomaçoes do anime
            $this->db->query("UPDATE animes SET id_imagem = :id_imagem, nome = :nome, sinops =  :sinops  WHERE id = :id");
            $this->db->bind("id_imagem", $dados['id_img']);
            $this->db->bind("nome", $dados['nome']);
            $this->db->bind("sinops", $dados["sinops"]);
            $this->db->bind("id", $dados["id"]);
        elseif ($part == 2) :
            //aqui seram feita as alteraçoes nas infomaçoes do anime
            $this->db->query("UPDATE animes SET qtd_episodios = :qtd_episodios, filmes =  :filmes, lancamento = :lancamento,
        proxima_temp = :proxima_temp, anterior_temp =:anterior_temp , estado = :estado ,formato = :formato ,qtd_oval = :qtdOvais
        WHERE id = :id");
            $this->db->bind("qtd_episodios", $dados['eps']);
            $this->db->bind("filmes", $dados["filmes"]);
            $this->db->bind("lancamento", $dados["lancamento"]);
            $this->db->bind("proxima_temp", $dados["proxTemp"]);
            $this->db->bind("anterior_temp", $dados["tempAnterior"]);
            $this->db->bind("estado", $dados["situacao"]);
            $this->db->bind("formato", $dados["formato"]);
            $this->db->bind("id", $dados["id"]);
            $this->db->bind("qtdOvais", $dados['qtdOvais']);
        endif;

        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }
    public function buscarGenero($genero, $limite, $inicio)
    {
        $this->db->query("SELECT img.id as imgID , img.url, an.nome , an.id ,gen.nome as geNome  FROM animes an LEFT OUTER JOIN 
    imagens img on img.id = an.id_imagem inner join anime_has_genero anGen on anGen.id_anime = an.id inner join 
    genero gen on gen.id = anGen.id_genero where gen.id = :genero LIMIT " . $inicio . "," . $limite . "");
        $this->db->bind("genero", $genero);
        return $this->db->resultados();
    }

    public function retornarQtdRegistroBusca($genero)
    {
        $this->db->query("SELECT img.id as imgID , img.url, an.nome as aniNome, an.id ,gen.nome FROM animes an 
    LEFT OUTER JOIN imagens img on img.id = an.id_imagem inner join anime_has_genero anGen on anGen.id_anime 
    = an.id inner join genero gen on gen.id = anGen.id_genero where gen.id = :genero");
        $this->db->bind("genero", $genero);
        $this->db->executa();
        return $this->db->totalResultados();
    }

    public function buscarRegistros($limite, $inicio)
    {
        $this->db->query("SELECT img.id as imgID , img.url, an.nome, an.id  FROM animes an LEFT OUTER JOIN imagens img on img.id = an.id_imagem ORDER BY  an.id DESC LIMIT " . $inicio . "," . $limite . " ");
        return $this->db->resultados();
    }

    public function retornarQtdRegistro()
    {
        $this->db->query("SELECT img.id as imgID , img.url, an.nome, an.id  FROM animes an LEFT OUTER JOIN imagens img on img.id = an.id_imagem  ");
        $this->db->executa();
        // $this->db->query("SELECT * FROM animes ");
        return $this->db->totalResultados();
    }

    public function buscarPorNome($nome){
        $this->db->query("SELECT an.id  FROM animes an LEFT OUTER JOIN imagens img on img.id = an.id_imagem WHERE an.nome = :nome");
        $this->db->bind("nome", $nome);
        return $this->db->resultado();
    }

    public function Cadastrar($dados)
    {
        $this->db->query("INSERT INTO animes ( id_imagem,qtd_episodios,filmes,lancamento,
    nome,sinops,proxima_temp, anterior_temp, estado,formato,qtd_oval) 
    VALUES (:id_imagem ,:qtd_episodios,:filmes,:lancamento,:nome,:sinops,:proxima_temp,
    :anterior_temp,:estado,:formato,:qtdOvais )");
        $this->db->bind("id_imagem", $dados['id_imagem']);
        $this->db->bind("qtd_episodios", $dados['qtd_episodios']);
        $this->db->bind("filmes", $dados['filmes']);
        $this->db->bind("lancamento", $dados['ano_lancamento']);
        $this->db->bind("nome", $dados['nome']);
        $this->db->bind("sinops", $dados['sinops']);
        $this->db->bind("proxima_temp", $dados['proxima_temp']);
        $this->db->bind("anterior_temp", $dados['anterior_temp']);
        $this->db->bind("estado", $dados['estado']);
        $this->db->bind("formato", $dados['formato']);
        $this->db->bind("qtdOvais", $dados['qtdOvais']);

        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    } //fechamento da função de armazenagem dos dados

    public function deletar($id)
    {
        $this->db->query("DELETE FROM animes WHERE id = :id");
        $this->db->bind("id", $id);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }
}
