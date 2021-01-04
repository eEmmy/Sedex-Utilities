<?php

namespace SedexUtilities;

/**
 * Classe para a validação de dados referentes a API de serviços da Empresa Brasileira de Correios e Telégrafos.
 *
 * @author Emmy Gomes <aou-emmy@outlook.com>
 */
class Validar
{
	/**
	 * Valida CEP's.
	 *
	 * @param String $cep
	 *
	 * @return Bool
	 */
	public static function cep($cep)
	{
		// Remove espaços em branco
		$cep = str_replace(" ", "", $cep);

		// Remove o hífen (-) caso haja
		$cep = str_replace("-", "", $cep);

		// Verifica se a quantidade de caracteres é igual a oito (8)
		if (strlen($cep) != 8) {
			// Retorna false para cep invalido
			return false;
		}

		// Verifica se a numeração está correta
		if (!preg_match("/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/", $cep)) {
			// Retorna false para cep invalido
			return false;
		}

		// Retorna true para cep valido
		return true;
	}

	/**
	 * Valida os dados de um produto.
	 *
	 * @param Array $produto
	 *
	 * @return Bool
	 */
	public static function produto($produto)
	{
		// Verifica a existencia dos inidices do produto
		if (count($produto) !== 5) {
			// Retorna falso
			return false;
		}

		// Retorna true
		return true;
	}

	/**
	 * Valida um serviço e retorna seu nome.
	 *
	 * @param String $codigo
	 *
	 * @return void
	 */
	public static function servico($codigo)
	{
		// Monta os serviços
		$servicos = array(
			"Sedex" => "40010",
			"Sedex 10" => "40215",
			"Sedex Hoje" => "40290",
			"PAC" => "41106",
			"PAC" => "41211",
			"eSedex 1" => "81019",
			"eSedex 2" => "81027",
			"eSedex 3" => "81035",
		);

		// Guarda o nome do serviço
		$servico = "";

		// Verifica se o codigo existe dentro de $servicos
		if (in_array($codigo, $servicos)) {
			// Retorna o nome do serviço
			return array_search($codigo, $servicos);
		}
		else {
			// Retorna falso
			return false;
		}
	}
}