<?php

class Usuario{

    private $_db, $_nomeSessao, $_estaLogado, $_dados;
    public function __construct($usuario = null)
    {
        $this->_db = Database::instance();
        $this->_nomeSessao = Config::get('sessao,nomeSessao');

        if(!$usuario)
        {
            if(Sessao::existe($this->_nomeSessao)){
                $usuario = Sessao::get($this->_nomeSessao);
                
                if($this->search($usuario))
                {
                    $this->_estaLogado = true;
                }else{
                    self::logout();
                }
            }
            
        }else{
            $this->search($usuario);
        }
    }
    
    public function create($campos = array())
    {
        if(!$this->_db->insert('usuarios',$campos))
        {
            throw new Exception("Houve um problena na criação de sua conta.");
        }
    }
    
    public function search($user = null){
        
        if($user)
        {
            $campo = (is_numeric($user)) ? 'id' : 'username'; // é possivel encontrar o user por id ou username
            $dados = $this->_db->get('usuarios', array($campo,'=',$user));            

            
            if($dados->count()){
                $this->_dados = $dados->first();
                return true;
                
            }
        }
        return false;
    }

    public function update($campos = array(), $id = null){
        if(!$id && $this->estaLogado())
        {
            $id = $this->_dados->id;
        }
        if(!$this->_db->update('usuarios', $id, $campos))
        {
            throw new Exception("Não foi possível atualizar as informações no banco de dados");
        }
    }

    public function login($username = null, $password = null){
        if(!$username && !$password && $this->existe())
        {
            Sessao::put($this->_nomeSessao, $this->_dados->id);
        }else{
            $usuario = $this->search($username);
            if($usuario)
            {
                if($this->dados()->password === Criptografia::criar($password,$this->dados()->salt))
                {
                    Sessao::put($this->_nomeSessao, $this->dados()->id);
                    return true;
                }
            }
        }
        return false;
    }

    public function existe(){
        return(!empty($this->_dados)) ? true : false;
    }

    public function logout(){
        Sessao::delete($this->_nomeSessao);
    }

    public function dados()
    {
        return $this->_dados;
    }

    public function estaLogado()
    {
        return $this->_estaLogado;
    }
}
