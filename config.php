<?php

/*
|--------------------------------------------------------------------------------------
| CEP de origem.
|--------------------------------------------------------------------------------------
|
| Aqui você deve definir qual o cep de origem da entrega. O valor pode ou não ser 
| passado com um hífen (-)
|
*/

$GLOBALS["origem"] = "01431-010";

/*
|--------------------------------------------------------------------------------------
| Formato da embalagem.
|--------------------------------------------------------------------------------------
|
| Aqui você deve definir qual o formato da embalagem a ser usada para o envio.
| As opções são:
|
| 1 = caixa/pacote
| 2 = rolo/prisma
|
*/

$GLOBALS["formatoEmbalagem"] = 1;

/*
|--------------------------------------------------------------------------------------
| Contrato.
|--------------------------------------------------------------------------------------
|
| Informa se existe um contrato do remetente com os Correios.
| As opções são: 
|
| 0 = Não existe um contrato
| 1 = Existe um contrato
|
*/

$GLOBALS["contrato"] = 0;

/*
|--------------------------------------------------------------------------------------
| Configurações de contrato.
|--------------------------------------------------------------------------------------
|
| Aqui você deve definir quais as configurações do seu contrato com o correio, caso
| exista um. Essas opções só serão relevadas caso a opção acima esteja configurada para
| um (1).
|
| As configurações são:
|
| [0] = Código disponibilizado pelos Correios para identificação da empresa.
| [1] = Senha para acesso aos serviços.
|
*/

$GLOBALS["parametrosContrato"] = [
	0 => "",
	1 => ""
];

/*
|--------------------------------------------------------------------------------------
| Serviços.
|--------------------------------------------------------------------------------------
|
| Aqui você deve definir quais os serviços dos Correios que pretende usar. Os que 
| deverão ser usados devem ser confiugurados como um (1), já os que não serão usados
| devem ser configurados como zero (0).
|
*/

$GLOBALS["servicos"] = [
	"sedex" => 1,
	"sedex10" => 0,
	"sedexHoje" => 0,
	"pac1" => 0,
	"pac2" => 0,
	"esedex1" => 0,
	"esedex2" => 0,
	"esedex3" => 0,
];

?>