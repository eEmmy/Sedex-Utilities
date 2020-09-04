<?php

/**
 * Arquivo de suporte para o plugin SedexUtilities. Instrui como realizar a busca de informações através de um cep.
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

// O unico parametro necessário é o cep do qual deseja obter informações.
$resultado = $u->encontrar('06660-570');

// Para exibir na tela. Meramente demostrativo.
foreach ($resultado as $key => $value) {
	echo $key . ': ' . $value . '<br>';
}

?>