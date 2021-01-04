# CHANGELOG
Log de mudanças feitas no Sedex-Utilities.

## Stable
### 2.0.0

#### Adicionado
* **Composer** - Instalação e uso agora via composer;
* **Uso estático** - Todos os métodos são chamados de forma estática, removendo a necessidade de instanciar as classes;
* **Validar** - Foi incluido um arquivo chamado [Validar.php]() (src/Validar.php) com a classe responsável pela validação dos dados usados em toda a biblioteca, que também podem ser chamados separadamente da classe principal.

#### Removido
* **Conversão de moedas**

#### Alterado
* **Documentação do código** - Uma documentação bem mais padronizada e estruturada foi adicionada.
* **Configurações globais** - O arquivo [config.php](config.php) foi alterado, e agora deve ser carregado pelo usuário manualmente. Em contrapartida, ele não precisa mais estar na mesma pasta das classes, nem ter esse nome, dado que os parametros de configuração são passados através da variavel $GLOBALS;
* **Retorno das requisições** - Antes do array de saida ser montado, o retorno das requisições é convertido para JSON, e então para um objeto stdClass.