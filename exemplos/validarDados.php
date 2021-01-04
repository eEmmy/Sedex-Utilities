<?php

/*
|--------------------------------------------------------------------------------------
| Validação de dados.
|--------------------------------------------------------------------------------------
|
| Esse exemplo visa demonstrar como usar a biblioteca SedexUtilities validar dados 
| referentes aos serviços da Empresa Brasileira de Correios e Telégrafos.
|
*/

// Inclua o arquivo autoload.php do seu projeto
require_once "../vendor/autoload.php";

// Carrega o arquivo de configurações
require_once "../config.php";

// Importa o namespace da classe
use SedexUtilities\Validar;

// Validação de CEP. Retorna um booleano
Validar::cep("xxxxx-xxx");

// Validação de código de serviço dos Correios. Retorna o nome do serviço informado se o código for valido ou um booleano falso caso não seja
Validar::servico("xxxxx");

// Validação das informações de um produto, que serão usadas na hora de calcular uma entrega. Retorna um booleano
Validar::produto($array);

?>