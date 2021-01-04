<?php

namespace SedexUtilities;

/**
 * Classe para consumo da API de serviços da Empresa Brasileira de Correios e Telégrafos a fim de realizar calculo de fretes.
 *
 * @author Emmy Gomes <aou-emmy@outlook.com>
 */
class SedexUtils
{
	/**
	 * Guarda os códigos de todos os serviços.
	 *
	 * @var Array $servicos
	 */
	protected static $servicos;

	/**
	 * Guarda os serviços que serão utilizados, já no formato da API.
	 *
	 * @var String $servicosUtilizados
	 */
	public static $servicosUtilizados;

	/**
	 * Define as propriedades da classe.
	 *
	 * @return void
	 */
	public static function init()
	{
		// Define os serviços
		self::$servicos = array(
			// Sedex
			"sedex" => "40010",
			"sedex10" => "40215",
			"sedexHoje" => "40290",
			// PAC
			"pac1" => "41106",
			"pac2" => "41211",
			// eSedex
			"esedex1" => "81019",
			"esedex2" => "81027",
			"esedex3" => "81035"
		);

		// Monta a string de servicos
		self::$servicosUtilizados = self::definirServicos();
	}

	/**
	 * Define os serviços que serão utilizados.
	 *
	 * @return String $servicosUtilizados
	 */
	protected static function definirServicos()
	{
		// Verifica se as configurações de serviços existem
		if (!isset($GLOBALS["servicos"])) {
			// Gera um erro
			throw new Exception("Nenhum serviço foi passado. Tem certeza que o arquivo de configurações foi carregado devidamente?");

			return false;
		}

		// Guarda os serviços
		$servicos = $GLOBALS["servicos"];

		// Guarda a string de serviços
		$servicosUtilizados = "";

		// Loop em self::$servicos
		foreach (self::$servicos as $servico => $codigo) {
			// Verifica se o serviço atual foi configurado para ser usado
			if ($servicos[$servico] == 1) {
				// Adiciona o código do servico para a string de serviços
				$servicosUtilizados .= $codigo;

				// Remove a chave de $serviçosUtilizados
				unset($servicos[$servico]);

				// Verifica se há mais algum serviço a ser utilizado
				if (array_search(1, $servicos) !== false) {
					// Adiciona uma virgula a string de serviços
					$servicosUtilizados .= ",";
				}
				else {
					// Encerra o loop
					break;
				}
			}
		}

		// Retorna a string com os serviços
		return $servicosUtilizados;
	}

	/**
	 * Retorna a data completa de entrega.
	 *
	 * @param String $dia
	 *
	 * @return String $dataEntrega
	 */
	protected static function prazo($dia)
	{
		// Guarda a data de entrega
		$dataEntrega = "";

		// Verifica se o dia é anterior ao dia 10
		if (intval($dia) < 10) {
			// Adiciona um zero (0) na frente do numero do dia.
			$dia = "0" . $dia;
		}

		// Verifica se o dia se refere a esse mês ou ao próximo
		if (intval($dia) <= intval(date("d"))) {  // Próximo mês
			// Monta string no formato dd/mm
			$dataEntrega = $dia . "/" . date("m", strtotime("+1 month"));
		}
		else {  // Mês atual
			// Monta a string no formato dd/mm
			$dataEntrega = $dia . "/" . date("m");
		}

		// Retorna a data de entrega
		return $dataEntrega;
	}

	/**
	 * Calcula o valor de uma entrega.
	 *
	 * @param Array $produto
	 * @param String $cep
	 *
	 * @return Array $resultado
	 */
	public static function calcularEntrega($produto, $cep)
	{
		// Define as propriedades da classe
		self::init();

		// Verifica se o cep é valido
		if (Validar::cep($cep) === false) {
			// Gera um erro
			throw new Exception("O cep de destino não é valido.");
			
			return false;
		}

		// Verifica se as informações do produto são validas
		if (Validar::produto($produto) === false) {
			// Gera um erro
			throw new Exception("Há algo errado com os parametros do produto. Certifique-se de estar passando eles corretamente.");

			return false;
		}

		// Monta o array de parametros da API
		$parametros["sCepOrigem"] = $GLOBALS["origem"];
		$parametros["sCepDestino"] = $cep;
		$parametros["nVlPeso"] = $produto["peso"];
		$parametros["nCdFormato"] = $GLOBALS["formatoEmbalagem"];
		$parametros["nVlComprimento"] = $produto["comprimento"];
		$parametros["nVlAltura"] = $produto["altura"];
		$parametros["nVlLargura"] = $produto["largura"];
		$parametros["nVlDiametro"] = $produto["diametro"];
		$parametros["sCdMaoPropria"] = "n";
		$parametros["nVlValorDeclarado"] = 0;
		$parametros["sCdAvisoRecebimento"] = "n";
		$parametros["strRetorno"] = "xml";
		$parametros["nCdServico"] = self::$servicosUtilizados;

		// Verifica se foi definido o uso de um contrato
		if ($GLOBALS["contrato"] === 1) {
			// Define os parametros do contrato
			$parametros["nCdEmpresa"] = $GLOBALS["parametrosContrato"][0];
			$parametros["sDsSenha"] = $GLOBALS["parametrosContrato"][1];
		}
		else {
			// Define os parametros do contrato como vazios
			$parametros["nCdEmpresa"] = "08082650";
			$parametros["sDsSenha"] = "564321";
		}

		// Monta a url
		$url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?" . http_build_query($parametros);
		
		// Inicia a requisição
		$curl = curl_init($url);

		// Define os parametros da requisição
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		// Monta a variavel com os resultados
		$retorno = curl_exec($curl);
		$retorno = simplexml_load_string($retorno);
		
		// Converte de XML para JSON, e de JSON para Array
		$retorno = json_encode($retorno);
		$retorno = json_decode($retorno);

		// Guarda o array de saida
		$resultado = array();

		// Verifica se existe o indice zero (0) dentro de $retorno
		if (!isset($resultado[0])) {
			// Joga o objeto dentro do indice zero (0) para evitar erros no loop
			$retorno = [0 => $retorno];
		}

		// Variavel para controle de loop
		$i = 0;

		// Loop em $retorno
		foreach ($retorno as $servico => $parametros) {
			// Loop em $parametros
			foreach ($parametros as $parametro => $valor) {
				// Monta o resultado
				$resultado[$i]["servico"] = Validar::servico($valor->Codigo);
				$resultado[$i]["valor"] = $valor->Valor;
				$resultado[$i]["prazo"] = self::prazo($valor->PrazoEntrega);
				$resultado[$i]["entregaSabado"] = $valor->EntregaSabado == "S" ? "Sim" : "Não";

				// Incrementa a variavel de controle
				$i++;
			}
		}

		// Retorna os resultados formatados
		return $resultado;
	}

	/**
	 * Busca informações de um cep.
	 *
	 * @param String $cep
	 *
	 * @return Array $resultado
	 */
	public static function buscarCep($cep)
	{
		// Define as propriedades da classe
		self::init();

		// Verifica se o cep é valido
		if (Validar::cep($cep) === false) {
			// Gera um erro
			throw new Exception("O cep de destino não é valido.");
			
			return false;
		}

		// Monta a url
		$url = "http://viacep.com.br/ws/$cep/xml/";

		// Recupera a resposta
		$retorno = simplexml_load_file($url);

		// Converte de XML para JSON e de JSON para Array
		$retorno = json_encode($retorno);
		$retorno = json_decode($retorno);

		// Monta o resultado
		$resultado = array(
			"cep" => $cep,
			"rua" => $retorno->logradouro,
			"bairro" => $retorno->bairro,
			"cidade" => $retorno->localidade,
			"estado" => $retorno->uf
		);

		// Retorna o resultado
		return $resultado;
	}
}

?>