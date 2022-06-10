<?php

class Usuario
{
    private $db;


    public function __construct()
    {

        $this->db = new Database();
    } //fechamento do metodo contrutor


    public function buscalAll()
    {
        $this->db->query("SELECT email, nome, id FROM usuarios where nivel = 2");
        return $this->db->resultados();
    }

    public function deletar($id)
    {
        $this->db->query(" delete from usuarios where id = :id");
        $this->db->bind("id", $id);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }

    public function checarEmail($email)
    {
        $this->db->query("SELECT email FROM usuarios where email = :email");
        $this->db->bind("email", $email);
        if ($this->db->resultado()) :
            return true;
        else :
            return false;
        endif;
    } //fim da função checarEmail

    public function logar($email, $senha)
    {
        $this->db->query("SELECT * FROM usuarios where email = :email");
        $this->db->bind("email", $email);
        if ($this->db->resultado()) :
            $resultado = $this->db->resultado();

            if (password_verify($senha, $resultado->senha)) :
                return $resultado;
            else :
                return false;
            endif;
        else :
            return false;
        endif;
    }

    public function alterar($dados)
    {
        $this->db->query("UPDATE usuarios set nome =:nome , email = :email where id= :id");
        $this->db->bind("nome", $dados['nome']);
        $this->db->bind("email", $dados['email']);
        $this->db->bind("id", $dados['id']);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }
    public function armazenar($dados)
    {
        $this->db->query("INSERT INTO usuarios(nome,email,senha,nivel) VALUES(:nome, :email, :senha, :nivel) ");
        $this->db->bind("nome", $dados['nome']);
        $this->db->bind("email", $dados['email']);
        $this->db->bind("senha", $dados['senha']);
        $this->db->bind("nivel", $dados['nivel']);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    } //fechamento da função de armazenagem dos dados


}
