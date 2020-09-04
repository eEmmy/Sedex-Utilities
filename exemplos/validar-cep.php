<?php

/**
 * Arquivo de suporte para o plugin SedexUtilities. Instrui como validar um CEP
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

// Retorna um booleano true para valido e false para invalido. Passar o CEP sem o hífen
$cep_valido = $sedex->validaCep('06660570');

// Para exibir na tela. Meramente demostrativo.
if ($cep_valido == true) {
	echo "CEP é valido";
}

else {
	echo "CEP não é valido";
}

?>