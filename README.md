<<<<<<< HEAD
# SedexUtilities

Esse é um plugin php voltado para utilidades básicas ao manipular serviços da Empresa Brasileira de Correiose Telégrados brasileira. Nele contém as seguintes funções:

- Calcular frete de uma entrega.
- Buscar informações através de um CEP.
- Converter valores em Reais brasileiros (R$) em Euro, Dólar e Libra.
- Validar um CEP.

### Aviso de licensa

O plugin é open-source mas não é gratuito. O uso não autorizado deste ira resultar em processo judicial por quebra de direitos autorais

Para comprar o plugin, visite os seguintes links:

### Pré-requisitos

Em sistemas Windows as bibliotecas já vêm em qualquer pack de servidor embutido (XAMPP, WAMPP, etc).
Já em sistemas Linux (Ubuntu, Debian, Linux Mint, etc), é necessário rodar os seguintes comandos:

__Para sistemas baseados em Debian__

```
sudo apt install -y php php-curl
```

__Para sistemas baseados em Arch__

```
pacman -S php
pacman -S curl
```

__Para sistemas baseados no Fedora__

```
sudo dnf install php-cli php-curl php-xml -y 
```

__Importante:__ o plugin foi feito para ter compatibilidade universal, tanto em PHP puro, quanto em conjunto com outros frameworks (Laravel, OpenCart, etc), mas dependendo das configurações do servidor, do php.ini ou do proprio framework você pode encontrar dificuldades.

### Instalação

Há duas formas de baixar o SedexUtilities.

#### Git

Baixa a versão do github. Precisa incluir o arquivo __src/SedexUtilities.php__ toda vez que for usar o plugin.


```
git clone git://github.com/schacon/grit.git
```

#### Composer

Baixa a versão do composer. Ao incluir o arquivo de autoload, ou já ter ele carregado por algum framework, para usar apenas importe o namespace Plugins\SedexUtilites.

```
composer require SedexUtilities
```

## Exemplos

O uso das funções está dentro da pasta __exemplos/__, com arquivos separados para cada função

## Autores

* __Emmy Gomes__ - *Responsavel por todo o projeto* - [eEmmy](https://github.com/eEmmy)

## License

Esse projeto é de propriedade intelectual privada da autora, seu uso sem a compra nos links indicados nesse arquivo será considerado crime - veja o arquivo [LICENSE.md](LICENSE.md) para mais detalhes.
=======
# Sedex-Utilities
Biblioteca com todas as funções relacionadas a serviços dos Correios 
>>>>>>> 12e347d4a57920e06073cbfaa2a1e545b828ac08
