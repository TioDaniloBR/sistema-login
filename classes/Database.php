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

    public function delete($tabela, $where){
        //realiza um delete no banco
        return $this->action('DELETE', $tabela, $where);

    }

    public function insert($tabela, $campos = array()){
        //realiza um insert no banco
        if(count($campos))
        {
            $chave_campo = array_keys($campos);
            $valor = null;
            $x = 1;

            foreach($campos as $campo)
            {
                $valor .= '?';
                if($x < count($campos))
                {
                    $valor .= ', ';
                }
                $x++;
            }
            $sql = "INSERT INTO {$tabela} (`".implode('`,`', $chave_campo)."`) VALUES ({$valor})";

            if(!$this->query($sql, $campos)->error())
            {
                return true;
            }
        }
        return false;
    }

    public function update($tabela, $id, $campos = array()){
        //realiza um update no banco
        $set    = '';
        $x      = 1;

        foreach($campos as $nome_campo=>$valor)
        {
            $set .= "{$nome_campo} = ?";
            if($x < count($campos)){
                $set .= ", ";
            }
            $x++;
        }
        $sql = "UPDATE {$tabela} SET {$set} WHERE id = {$id}";
        if(!$this->query($sql, $campos)->error())
        {
            return true;
        }
        return false;

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

    public function first()
    {
        return $this->_results[0];
    }
}