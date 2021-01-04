<?php

/*
|--------------------------------------------------------------------------------------
| Calculo de entrega.
|--------------------------------------------------------------------------------------
|
| Esse exemplo visa demonstrar como usar a biblioteca SedexUtilities para calcular 
| prazo e valor de uma entrega.
|
*/

// Inclua o arquivo autoload.php do seu projeto
require_once "../vendor/autoload.php";

// Carrega o arquivo de configurações
require_once "../config.php";

// Importa o namespace da classe
use SedexUtilities\SedexUtils;

// Monta o array com as informações do produto
$produto = array(
	"altura" => "30",
	"comprimento" => "30",
	"diametro" => "39",
	"largura" => "30",
	"peso" => "1"
);

// Guarda o CEP do destinatário
$cepDestino = "06660-570";

// Faz a busca
$dados = SedexUtils::calcularEntrega($produto, $cepDestino);

/**
 * Formato de retorno:
 *
 * [0] => [
 *		"servico" => "Nome do Servico",
 *		"valor" => "00.00",
 * 		"prazo" => "dd/mm",
 *		"entregaSabado" => "Sim/Não"
 * ]
 */