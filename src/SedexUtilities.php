<?php

include_once "../config.php";

/**
 * Plugin para utilidades dos servições do Correio brasileiro
 *
 * @author Emmy Gomes
 * @version 1.0
 */
class SedexUtilities
{
	// Variaveis
	private $cep_origem;
	private $formato_embalagem_padrao;
	private $contrato;
	private $informacoes_contrato;
	private $servicos_disponiveis;
	private $retorno_padrao;
	private $formato_moeda;
	private $filtrar_cep_destino;

	function __construct()
	{
		// Atribui valores as variaveis de configurações do plugin
		$this->importConfig();

		// Verifica se o cep passado no arquivo de configurações é valido
		if(!$this->validaCep(str_replace('-', '', $this->cep_origem))) {
			throw new Exception('Erro: o CEP de origem não é valido. Impossivel continuar.');
		}
	}

	/**
	 * Importa as variaveis do arquivo "config.php" e as define.
	 *
	 * @return void
	 */
	protected function importConfig()
	{
		// Variaveis do usuario/empresa
		global $cep_origem;
		global $formato_embalagem_padrao;
		global $contrato;
		global $informacoes_contrato;
		global $servicos_disponiveis;

		// Variaveis do sistema
		global $retorno_padrao;
		global $formato_moeda;
		global $filtrar_cep_destino;

		// Define os valores de todas essas variaveis
		$this->cep_origem = $cep_origem;
		$this->contrato = $contrato;
		$this->informacoes_contrato = $informacoes_contrato;
		$this->servicos_disponiveis = $this->retornaServicos($servicos_disponiveis);
		$this->retorno_padrao = $retorno_padrao;
		$this->formato_moeda = $formato_moeda;
		$this->filtrar_cep_destino = $filtrar_cep_destino;
		
		// Converte o formato da embalagem para o aceito pelos correios
		if ($formato_embalagem_padrao == 'caixa') {
			$this->formato_embalagem_padrao = '1';
		}
		else if ($formato_embalagem_padrao == 'rolo' || $formato_embalagem_padrao == 'prisma') {
			$this->formato_embalagem_padrao == '2';
		} 
		else {
			throw new Exception('Erro: não foi passado um formato valido de embalagem nas configurações. Por favor defina um formmato valido e tente novamente.');
		}
	}

	/**
	 * Converte os serviços que o usuario que usar para um formato aceito pelo correio.
	 *
	 * @param array $servicos
	 *
	 * @return string
	 */
	protected function retornaServicos($servicos)
	{
		// Variavel para armazenar os serviços desejados
		$servicos_habilitados = '';

		// Variavel de controle do loop
		$habilitados = 0;

		// Loop para pegar códigos
		foreach ($servicos as $key => $value) {
			foreach ($value as $code => $value) {
				// Verifica se o usuario quer usar o serviço
				if ($value == 1) {
					// Checa se é o primeiro serviço a ser habilitado
					if ($habilitados == 0) {
						// Adiciona o código a lista
						$servicos_habilitados .= $code;

						$habilitados++;
					} else {
						// Adiciona o código a lista
						$servicos_habilitados .= ',' . $code;

						$habilitados++;
					}
				}
			}
		}

		return $servicos_habilitados;
	}

	/**
	 * Valida um cep.
	 *
	 * @param string $cep
	 *
	 * @return bool
	 */
	public function validaCep($cep)
	{
		/* Os ceps devem ser passados no formato '00000000' */

		// Remove espaços em branco
		$cep = str_replace(' ', '', $cep);

		// Verifica a quantidade de caracteres
		if (strlen($cep) != 8) {
			return false;
		}

		// Verifica se a numeração está correta
		if (!preg_match('/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/', $cep)) {
			return false;
		}

		// Ao chegar até aqui, o cep é valido
		return true;
	}

	/**
	 * Converte a moeda para o especificado no arquivo de configurações.
	 *
	 * @param string $valor
	 *
	 * @return string
	 */
	public function converteMoeda($valor)
	{
		// Trata reais
		if ($this->formato_moeda == 'real') {
			return 'R$' . $valor;
		}

		// Trata dolares
		else if ($this->formato_moeda == 'dolar') {
			// URL para obter o preço do dolar
			$url = 'http://cotacoes.economia.uol.com.br/cambioJSONChart.html';

			// Inicia e executa a solicitação por meio do curl
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			// Recupera o retorno
			$retorno = curl_exec($curl);
			$retorno = json_decode($retorno);

			// Valor do dolar
			$dolar = $retorno[2]->ask;

			// Formata o dolar
			$dolar = floatval(substr(substr($dolar, 0, -1), 0, -1));

			// Converte o preço em dolar
			$valor = floatval(str_replace(',', '.', $valor));
			$valor = (string) number_format(($valor / $dolar), 2, ',', '');

			// Retorno o valor convertido
			return 'US$' . $valor;
		}

		// Trata euros
		else if ($this->formato_moeda == 'euro') {
			// URL para obter o preço do euro
			$url = 'https://economia.awesomeapi.com.br/json/eur';

			// Inicia e executa a solicitação por meio do curl
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			// Recupera o retorno
			$retorno = curl_exec($curl);
			$retorno = json_decode($retorno);

			// Valor do euro
			$euro = number_format(floatval($retorno[0]->ask), 2, ',', '');

			// Converte o preço em euro
			$valor = number_format(floatval(str_replace(',', '.', $valor) / $euro), 2, ',', '');

			// Retorno o valor convertido
			return $valor . ' €';
		}

		// Trata euros
		else if ($this->formato_moeda == 'libra') {
			// URL para obter o preço da libra
			$url = 'https://economia.awesomeapi.com.br/json/gbp';

			// Inicia e executa a solicitação por meio do curl
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			// Recupera o retorno
			$retorno = curl_exec($curl);
			$retorno = json_decode($retorno);

			// Valor da libra
			$libra = number_format(floatval($retorno[0]->ask), 2, ',', '');

			// Converte o preço em libra
			$valor = number_format(floatval(str_replace(',', '.', $valor) / $libra), 2, ',', '');

			// Retorno o valor convertido
			return $valor . ' £';
		}
	}

	/**
	 * Retorna a data completa de entrega.
	 *
	 * @param string $dia
	 *
	 * @return array
	 */
	public function convertePrazo($dia)
	{
		// Verifica se há necessidade de formatar dias anteriores ao dia 10
		if (intval($dia) < 10) {
			$dia = '0' . $dia;
		}

		// Checa se o dia é do mês atual ou do próximo
		if (intval($dia) <= intval(date('d'))) {
			return $dia . '/' . date('m', strtotime('+1 month'));
		}

		return $dia . '/' . date('m');
	}

	/**
	 * Calcula o valor de uma entrega.
	 *
	 * @param array $info_produto
	 * @param string $cep_destino
	 *
	 * @return array
	 */
	public function calcularFrete($info_produto, $cep_destino)
	{
		// Converte o cep caso a opção esteja definida como true
		if ($this->filtrar_cep_destino) {
			$cep_destino = str_replace('-', '', $cep_destino);
		}

		// Verifica se o cep é valido
		if (!$this->validaCep($cep_destino)) {
			return array('Erro' => 'O cep passado não é valido.');
		}

		// Verifica os parametros do produto
		if (!isset($info_produto['peso']) || !isset($info_produto['comprimento']) || !isset($info_produto['altura']) || !isset($info_produto['diametro'])) {
			return array('Erro' => 'Há algo errado com os parametros do produto. Certifique-se de estar passando eles corretamente.');
		}

		// Converte as chaves nas pedidas pelo correio
		$parametros = array(
			'sCepOrigem' => $this->cep_origem,
			'sCepDestino' => $cep_destino,
			'nVlPeso' => $info_produto['peso'],
			'nCdFormato' => $this->formato_embalagem_padrao,
			'nVlComprimento' => $info_produto['comprimento'],
			'nVlAltura' => $info_produto['altura'],
			'nVlLargura' => $info_produto['largura'],
			'nVlDiametro' => $info_produto['diametro'],
			'sCdMaoPropria' => 'n',
			'nVlValorDeclarado' => '0',
			'sCdAvisoRecebimento' => 'n',
			'strRetorno' => $this->retorno_padrao,
			'nCdServico' => $this->servicos_disponiveis,
			'nCdEmpresa' => '',
			'sDsSenha' => ''
		);

		// Verifica se é pra usar contrato
		if ($this->contrato) {
			$parametros['nCdEmpresa'] = $informacoes_contrato['codigo_empresa'];
			$parametros['sDsSenha'] = $informacoes_contrato['senha_empresa'];
		}

		// Monta a url
		$parametros = http_build_query($parametros);
		$url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';
		
		// Inicia o curl
		$curl = curl_init($url.'?'.$parametros);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		// Monta a variavel com os resultados
		$retorno = curl_exec($curl);
		$retorno = simplexml_load_string($retorno);

		// Variavel para armazenar resultados
		$resultados = array();

		// Monta os resultados
		foreach ($retorno->cServico as $linha) {
			$resultados['valor'] = $this->converteMoeda($linha->Valor);
			$resultados['servico'] = $linha->Codigo;
			$resultados['prazo'] = $this->convertePrazo($linha->PrazoEntrega);
			$resultado['erros'] = array('erro' => $linha->Erro, 'msg' => $linha->MsgErro);
		}

		// Retorna os resultados formatados
		return $resultados;
	}

	/**
	 * Busca informações de acordo com um cep passado.
	 *
	 * @param string $cep
	 *
	 * @return array
	 */
	public function encontrar($cep)
	{
		// Converte o cep caso a opção esteja definida como true
		if ($this->filtrar_cep_destino) {
			$cep = str_replace('-', '', $cep);
		}

		// Verifica se o cep é valido
		if (!$this->validaCep($cep)) {
			return array('Erro' => 'O cep passado não é valido.');
		}

		// Url para obter as informações
		$url = "http://viacep.com.br/ws/$cep/xml/";

		// Recupera a resposta
		$retorno = simplexml_load_file($url);

		// Monta o retorno
		$resultado = array(
			'cep' => $cep,
			'rua' => $retorno->logradouro,
			'cidade' => $retorno->localidade,
			'estado' => $retorno->uf
		);

		return $resultado;
	}
}

?>