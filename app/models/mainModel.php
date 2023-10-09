<?php
	
	namespace app\models;
	use \PDO;

	if(file_exists(__DIR__."/../../config/server.php")){
		require_once __DIR__."/../../config/server.php";
	}

	class mainModel{

		private $server		=DB_SERVER;
		private $db			=DB_NAME;
		private $user		=DB_USER;
		private $pass		=DB_PASS;


		/*----------  Função para conectar com o banco de dados  ----------*/
		protected function conectar(){
			$conexion = new PDO("mysql:host=".$this->server.";dbname=".$this->db,$this->user,$this->pass);
			$conexion->exec("SET CHARACTER SET utf8");
			return $conexion;
		}


		/*----------  Função que executa as query  ----------*/
		protected function runQuery($consulta){
			$sql=$this->conectar()->prepare($consulta);
			$sql->execute();
			return $sql;
		}


		/*----------  Função para limpar as strings e evitar a injeção SQL  ----------*/
		public function cleanString($string){

			$words		=["<script>","</script>","<script src","<script type=","SELECT * FROM","SELECT "," SELECT ","DELETE FROM","INSERT INTO","DROP TABLE","DROP DATABASE","TRUNCATE TABLE","SHOW TABLES","SHOW DATABASES","<?php","?>","--","^","<",">","==","=",";","::"];

			$string		=trim($string);
			$string		=stripslashes($string);

			foreach($words as $word){
				$string	=str_ireplace($word, "", $string);
			}

			$string		=trim($string);
			$string		=stripslashes($string);

			return $string;
		}


		/*---------- Função para verificar dados ----------*/
		protected function verificarDados($filtro,$string){
			if(preg_match("/^".$filtro."$/", $string)){
				return false;
            } else {
                return true;
            }
		}


		/*----------  Função para executar o INSERT  ----------*/
		protected function savingDatas($table,$dados){

			$query="INSERT INTO $table (";

			$C=0;
			foreach ($dados as $senha){
				if($C>=1){ $query.=","; }
				$query.=$senha["campo_nombre"];
				$C++;
			}
			
			$query.=") VALUES(";

			$C=0;
			foreach ($dados as $senha){
				if($C>=1){ $query.=","; }
				$query.=$senha["campo_marcador"];
				$C++;
			}

			$query.=")";
			$sql=$this->conectar()->prepare($query);

			foreach ($dados as $senha){
				$sql->bindParam($senha["campo_marcador"],$senha["campo_valor"]);
			}

			$sql->execute();

			return $sql;
		}


		/*---------- Função que executa um SELECT dos dados ----------*/
        public function selecionarDados($tipo,$table,$campo,$id){
			$tipo		=$this->cleanString($tipo);
			$table		=$this->cleanString($table);
			$campo		=$this->cleanString($campo);
			$id			=$this->cleanString($id);

            if($tipo=="Unico"){
                $sql=$this->conectar()->prepare("SELECT * FROM $table WHERE $campo=:ID");
                $sql->bindParam(":ID",$id);
            } elseif ($tipo=="Normal"){
                $sql=$this->conectar()->prepare("SELECT $campo FROM $table");
            }
            $sql->execute();

            return $sql;
		}


		/*----------  Função que executa um UPDATE  ----------*/
		protected function updateDatas($table,$dados,$condition){
			
			$query="UPDATE $table SET ";

			$C=0;
			foreach ($dados as $senha){
				if($C>=1){ $query.=","; }
				$query.=$senha["campo_nombre"]."=".$senha["campo_marcador"];
				$C++;
			}

			$query.=" WHERE ".$condition["condicion_campo"]."=".$condition["condicion_marcador"];

			$sql=$this->conectar()->prepare($query);

			foreach ($dados as $senha){
				$sql->bindParam($senha["campo_marcador"],$senha["campo_valor"]);
			}

			$sql->bindParam($condition["condicion_marcador"],$condition["condicion_valor"]);

			$sql->execute();

			return $sql;
		}


		/*---------- Função para deletar registro ----------*/
        protected function deletarRegistro($table,$campo,$id){
            $sql=$this->conectar()->prepare("DELETE FROM $table WHERE $campo=:id");
            $sql->bindParam(":id",$id);
            $sql->execute();
            
            return $sql;
        }


		/*---------- Paginador de tabelas ----------*/
		protected function paginadorTabelas($pagina,$numeroPaginas,$url,$botoes){
	        $table='<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

	        if($pagina<=1){
	            $table.='
	            <a class="pagination-previous is-disabled" disabled >Anterior</a>
	            <ul class="pagination-list">
	            ';
	        } else {
	            $table.='
	            <a class="pagination-previous" href="'.$url.($pagina-1).'/">Anterior</a>
	            <ul class="pagination-list">
	                <li><a class="pagination-link" href="'.$url.'1/">1</a></li>
	                <li><span class="pagination-ellipsis">&hellip;</span></li>
	            ';
	        }


	        $ci=0;
	        for($i=$pagina; $i<=$numeroPaginas; $i++){

	            if($ci>=$botoes){
	                break;
	            }

	            if($pagina==$i){
	                $table.='<li><a class="pagination-link is-current" href="'.$url.$i.'/">'.$i.'</a></li>';
	            } else {
	                $table.='<li><a class="pagination-link" href="'.$url.$i.'/">'.$i.'</a></li>';
	            }

	            $ci++;
	        }


	        if($pagina==$numeroPaginas){
	            $table.='
	            </ul>
	            <a class="pagination-next is-disabled" disabled >Próxima</a>
	            ';
	        } else {
	            $table.='
	                <li><span class="pagination-ellipsis">&hellip;</span></li>
	                <li><a class="pagination-link" href="'.$url.$numeroPaginas.'/">'.$numeroPaginas.'</a></li>
	            </ul>
	            <a class="pagination-next" href="'.$url.($pagina+1).'/">Próxima</a>
	            ';
	        }

	        $table.='</nav>';
	        return $table;
	    }
	    
	}