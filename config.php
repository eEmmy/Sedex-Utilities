<?php
/**
 * Arquivo de configurações do plugin Correio-Utilities.
 *
 * @author Emmy Gomes <aou-emmy@outlook.com>
 * @version 1.0
 */

/* --- Configurações do usuario/empresa --- */

// Cep de origem
$cep_origem = '01310-000';

// Formato padrão que será usado nas embalagens
// As opções disponiveis são: 'caixa' e 'rolo'/'prisma'
$formato_embalagem_padrao = 'caixa';

// Informa se o usuario/empresa tem contrato com o correio
// As opções disponiveis são true (sim) ou false (não)
// Caso não tenha ou não saiba do que se trata apenas deixe as configurações padrões
$contrato = false;

// Caso tenha contrato, passe as informações aqui
$informacoes_contrato = array(
	'codigo_empresa' => 'codigo da empresa aqui',
	'senha_empresa' => 'senha da empresa aqui'
);

// Informa os serviços de entrega que o usuario/empresa deseja usar do correio
// Use 0 para não usar o serviço e 1 para usa-lo
// Não altere os códigos entre aspas. Isso gerara um erro no programa
// As limitações do correio limitam a apenas um serviço
$servicos_disponiveis = array(
	// Sedex comum
	'sedex' => ['40010' => 1],
	// Sedex 10
	'sedex10' => ['40215' => 0],
	// Sedex Hoje
	'sedexHoje' => ['40290' => 0],
	// PAC
	'pac-1' => ['41106' => 0],
	'pac-2' => ['41211' => 0],
	// e-Sedex
	'esedex-1' => ['81019' => 0],
	'esedex-2' => ['81027' => 0],
	'esedex-3' => ['81035' => 0],
);


/* --- Configurações do plugin -- */

// Formato para retorno das consultas
// Interfere na estrutura do plugin. Só deve ser alterado por programadores e necessita re-escrita do código fonte do programa
// Padrão é 'xml'
$retorno_padrao = 'xml';

// Define qual moeda apresentar
// As opções são: 
	// 'real' (Reais brasileiros), 'dolar' (Dolar estadunidense), 
	// 'libra' (Libra esterlina), 'euro' (Euro europeu)
$formato_moeda = 'dolar';

// Define se os ceps de destino serão filtrados no lado do servidor pelo plugin ou já serão passados no formato ideal
// Caso escolha deixar o plugin filtra-lo, os erros terão de ser tratados por você, o plugin apenas retornara que houve um erro no formato do cep
// Caso escolha passar o cep já filtrado o formato deve ser 'xxxxxxx', sem o hífen
// As opções são true (sim) e false (não)
$filtrar_cep_destino = true;
?>