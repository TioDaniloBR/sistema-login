<?php

class Database{
    private static $_instance = null;
    private $_pdo, $_query, $_error = false, $_results, $_count = 0;

    private function __construct(){
        //realizar conexão com try catch
        try
        {
            $this->_pdo = new PDO(
                'mysql:host='.Config::get('mysql,host')
                .';dbname='.Config::get('mysql,db')
                ,Config::get('mysql,username')
                ,Config::get('mysql,password'));
        }catch(PDOException $e){
            echo $e;
        }
    }

    public static function instance(){
        //retorna uma instancia já criada ou cria uma nova
        if(!isset(self::$_instance))
        {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    public function query($sql, $params = array()){
        //executa as queries
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql))
        {
            $x = 1;

            if(count($params))
            {
                foreach($params as $param)
                {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
        }
        if($this->_query->execute())
        {
            $this->_results     = $this->_query->fetchAll(PDO::FETCH_OBJ);
            $this->_count       = $this->_query->rowCount();
        }else{
            $this->_error = true;
        }
        return $this;
    }

    public function action($acao, $tabela, $where = array()){
        //ação que sera executada na query
        if(count($where) === 3) //evita que faça operações sem condição, podendo afetar todos os registros da tabela
        {
            $operadores = array('=','>','<','>=','<=','<>');

            $campo = $where[0];
            $operador = $where[1];
            $valor = $where[2];

            if(in_array($operador, $operadores))
            {
                $sql = "{$acao} FROM {$tabela} WHERE {$campo} {$operador} ?";
                if(!$this->query($sql, array($valor))->error())
                {
                    return $this;
                }
            }
        }
        return false;       
    }

    public function get($tabela, $where){
        //realiza um select no banco
        return $this->action('SELECT *', $tabela, $where);
    }

    public function delete(){
        //realiza um delete no banco
    }

    public function insert($tabela, $campos = array()){
        //realiza um insert no banco
        $teste = ['teste1','teste2','teste3'];
        $this->query("INSERT INTO `{$tabela}`(`username`, `password`, `nome`, `email`) VALUES (?,?,?,?)"
        ,array('danilo','123','danilo silva','danilo@danilo.com'));
    }

    public function update(){
        //realiza um update no banco
    }

    public function results(){
        //retorna o resultado da query
        return $this->_results;
    }

    public function error(){
        //retorna o erro que ocorrer na query
        return $this->_error;
    }

    public function count(){
        //retorna a quantidade de linhas afetadas pela query
        return $this->_count;
    }
}