# Bitcambio API (PHP)

Descrição: Classe para API da exchange brasileira Bitcambio em PHP.

Autor: Miguel Medeiros - [www.miguelmedeiros.com.br](https://www.miguelmedeiros.com.br)<br />
Exchange: [Bitcambio](https://www.bitcambio.com.br/)<br />
Documentação da API: [Bitcambio](https://blinktrade.com/docs/)

Gostou? Então me pague um café!<br/>
BTC Wallet: 1NM76h5SvdhTdmS8dksGwWpHNbnVngWczR

---

## Como utilizar

Para ter acesso aos métodos da classe você deve ter a API em mão e seguir o seguinte código:

```php
// importar classe
require ("./src/bitcambio.php");

// Colocar a sua API nessa variável (não é necessária para os métodos públicos)
$apiKey = "";
$apiPassword = "";
$apiSecret = "";

// Cria instancia da classe Bitcambio
$exchange = new Bitcambio($apiKey, $apiPassword, $apiSecret);
```

## Exemplos dos Métodos Públicos (Não há necessidade de usar as chaves de API)

### Buscar Ticker

[Exemplo Completo](https://github.com/MiguelMedeiros/bitcambio-api-php/blob/master/examples/ticker.php)

```php
$ticker = $exchange->ticker();
var_dump($ticker);
```

### Buscar Livro de Ordens

[Exemplo Completo](https://github.com/MiguelMedeiros/bitcambio-api-php/blob/master/examples/orderbook.php)

```php
$orderbook = $exchange->orderbook();
var_dump($orderbook);
```

## Exemplos dos Métodos Privados (Há necessidade de usar as chaves de API)

### Buscar Balanço da Conta

[Exemplo Completo](https://github.com/MiguelMedeiros/bitcambio-api-php/blob/master/examples/balance.php)

```php
$balance = $exchange->balance();
var_dump($balance);
```

### Buscar Minhas Ordens

[Exemplo Completo](https://github.com/MiguelMedeiros/bitcambio-api-php/blob/master/examples/my-orders.php)

```php
$myOrders = $exchange->myOrders();
var_dump($myOrders);
```

### Criar Ordens

[Exemplo Completo](https://github.com/MiguelMedeiros/bitcambio-api-php/blob/master/examples/create-order.php)

#### MARKET - compra ou venda

```php
// Exemplo de ordem (compra ou venda): MARKET
$unitPrice = 30000; // Cotação em reais de venda ou compra
$amount = 0.001; // Quantidade de BTC
$side = "buy"; // Lado compra ou venda: "buy" ou "sell"
$type = "market"; // Tipo: "market" - ordem executada imediatamente
$order = $exchange->createOrder($unitPrice, $amount, $side, $type);
var_dump($order);
```

#### LIMIT - compra ou venda

```php
// Exemplo de ordem (compra ou venda): LIMIT
$unitPrice = 30000; // Cotação em reais de venda ou compra
$amount = 0.001; // Quantidade de BTC
$side = "buy"; // Lado compra ou venda: "buy" ou "sell"
$type = "limit"; // Tipo: "limit" - ordem adicionada no livro de ordens
$order = $exchange->createOrder($unitPrice, $amount, $side, $type, null, $postOnly);
$postOnly = false; // true - só adiciona se não existirem ordens no mesmo preço
var_dump($order);
```

#### STOP - compra ou venda

```php
// Exemplo de ordem (compra ou venda): STOP
// Essa ordem vai funcionar como uma MARKET order
// Que será disparada quando chegar no valor de stop estipulado
$side = "buy"; // Lado compra ou venda: "buy" ou "sell"
$type = "stop"; // Tipo: "stop" - ordem executada imediatamente
$unitPriceStop = 20000; // Preço abaixo da melhor ordem de compra ou venda
$amount = 0.001; // Quantidade de BTC
$order = $exchange->createOrder(null, $amount, $side, $type, $unitPriceStop);
var_dump($order);
```

#### LIMIT STOP - compra ou venda

```php
// Exemplo de ordem (compra ou venda): STOP LIMIT
// Essa ordem vai funcionar como uma LIMIT order
// Que será disparada quando chegar no valor de stop estipulado
$side = "buy"; // Lado compra ou venda: "buy" ou "sell"
$type = "stop-limit"; // Tipo: "stop-limit" - ordem adicionada no livro de ordens
$unitPrice = 30000; // Cotação em reais de venda ou compra
$unitPriceStop = 20000; // Preço abaixo da melhor ordem de compra ou venda
$amount = 0.001; // Quantidade de BTC
$order = $exchange->createOrder(null, $amount, $side, $type, $unitPriceStop);
var_dump($order);
```

### Cancelar Ordem

[Exemplo Completo](https://github.com/MiguelMedeiros/bitcambio-api-php/blob/master/examples/cancel-order.php)

```php
$orderID = "1073880844"; // ID é o campo ClOrdID
$cancelOrder = $exchange->cancelOrder($orderID);
var_dump($cancelOrder);
```
