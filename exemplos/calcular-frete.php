<?php

/**
 * Arquivo de suporte para o plugin SedexUtilities. Instrui como realizar o calculo de frete.
 *
 * @author Emmy Gomes <aou-emmy@outlook.com>
 * @version 1.0
 */

// Na versão baixada do github, precisa incluir o arquivo SedexUtilities na pasta src. Ele é o core do plugin, então sem ele o plugin não funcionará.
require_once "../src/SedexUtilites.php";

// Na versão do composer, carregue o autoload dele e use o namespace Plugins\SedexUtilities.
use Plugins\SedexUtilites;

// Para poder acessar as utilidades, primeiro instancie a classe.
$sedex = new SedexUtilites();

/**
 * Para realizar o calculo, a função necessita de 2 parametros, um array contendo informações do produto e uma string com o cep destinatario.
 *
 * 'peso': deve ser passado em quilogramas, separar casas decimais com ponto (.)
 * 'comprimento': deve ser passado em centimetros e considerar o tamanho da embalagem, arredondar para cima
 * 'altura': deve ser passado em centimetros e considerar o tamanho da embalagem, arredondar para cima
 * 'largura': deve ser passado em centimetros e considerar o tamanho da embalagem, arredondar para cima
 * 'diametro': deve ser passado em centimetros e considerar o tamanho da embalagem, arredondar para cima
 */

$info_produto = array(
	'peso' => '0.9',
	'comprimento' => '30',
	'altura' => '30',
	'largura' => '30',
	'diametro' => '100'
);

// A função retornara um array, por isso sua execução deve ser armazenada em uma variavel.
$resultado = $sedex->calcularFrete($info_produto, '06660570');

// Para exibir na tela. Meramente demostrativo.
foreach($resultado as $key => $value) {
	echo $key . ': ' . $value . '<br>';
}

?>