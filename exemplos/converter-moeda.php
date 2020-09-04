<?php

/**
 * Arquivo de suporte para o plugin SedexUtilities. Instrui como converter valores para outras moedas.
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

// Passe o valor com virgula (,). Ele sera convertido para a moeda configurada no arquivo config.php na pasta raiz. O padrão é Real (R$) brasileiro.
$resultado = $sedex->converteMoeda('20,00');

// Para mostrar na tela. Meramente demonstrativo.
echo $resultado