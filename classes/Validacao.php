<?php
 class Validacao
 {
     private $_passou = false, $_erros = array(), $_db;

     public function __construct()
     {
         $this->_db = Database::instance();
     }

     public function checar($fonte, $itens)
     {
        foreach($itens as $item => $regras)
        {
            foreach($regras as $regra => $valorRegra)
            {
                $valor = trim($fonte[$item]);
                

                if($regra === 'required' && empty($valor))
                {
                    $this->adicionarErro("{$item} é um campo obrigratório");
                }else if(!empty($valor)){
                    switch($regra)
                    {
                        case 'min':
                            if(strlen($valor) < $valorRegra)
                            {
                                $this->adicionarErro("{$item} precisa ter no mínimo {$valorRegra} caracteres.");
                            }
                        break;
                        case 'max':
                            if(strlen($valor) > $valorRegra)
                            {
                                $this->adicionarErro("{$item} precisa ter no máximo {$valorRegra} caracteres.");
                            }
                        break;
                        case 'unico':
                            $checar = $this->_db->get($valorRegra, array($item,'=',$valor));
                            if($checar->count())
                            {
                                $this->adicionarErro("Usuário {$valor} já está em uso.");
                            }
                        break;
                        case 'igual':
                            if($valor != $fonte[$valorRegra])
                            {
                                $this->adicionarErro("O {$valorRegra}s digitados nos campos prencisam ser iguais.");
                            }
                    }
                }
            }
        }
        if(empty($this->_erros))
        {
            $this->_passou = true;
        }
        return $this;
     }

     public function passou()
     {
         return $this->_passou;
     }
     public function erros()
     {
         return $this->_erros;
     }
     private function adicionarErro($erro)
     {
         $this->_erros[] = $erro;
     }


 }