<?php

/*
|--------------------------------------------------------------------------------------
| Busca de informações através de CEP.
|--------------------------------------------------------------------------------------
|
| Esse exemplo visa demonstrar como usar a biblioteca SedexUtilities para obter 
| informações completas sobre a localização de um determinado CEP.
|
*/

// Inclua o arquivo autoload.php do seu projeto
require_once "../vendor/autoload.php";

// Carrega o arquivo de configurações
require_once "../config.php";

// Importa o namespace da classe
use SedexUtilities\SedexUtils;

// Guarda o CEP a ser buscado
$cep = "06660-570";

// Faz a busca
$dados = SedexUtils::buscarCep($cep);

/**
 * Formato de retorno:
 *
 * [
 * 	 "cep" => "xxxxx-xx"
 *	 "rua" => "Nome da rua"
 * 	 "bairro" => "Nome do bairro"
 * 	 "cidade" => "Nome da cidade"
 *	 "estado" => "UF"
 * ]
 */

?>