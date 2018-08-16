<?php
  // Importar Classe
  require('../src/bitcambio.php');

  // Suas credenciais
  $apiKey = "";
  $apiPassword = "";
  $apiSecret = "";

  // Cria objeto da exchange
  $exchange = new Bitcambio($apiKey, $apiPassword, $apiSecret);

  // Exemplo de ordem (compra ou venda): MARKET
  $unitPrice = 30000; // Cotação em reais de venda ou compra
  $amount = 0.001; // Quantidade de BTC
  $side = "buy"; // Lado compra ou venda: "buy" ou "sell"
  $type = "market"; // Tipo: "market" - ordem executada imediatamente
  $order = $exchange->createOrder($unitPrice, $amount, $side, $type);

  // Exemplo de ordem (compra ou venda): LIMIT
  $unitPrice = 30000; // Cotação em reais de venda ou compra
  $amount = 0.001; // Quantidade de BTC
  $side = "buy"; // Lado compra ou venda: "buy" ou "sell"
  $type = "limit"; // Tipo: "limit" - ordem adicionada no livro de ordens
  $order = $exchange->createOrder($unitPrice, $amount, $side, $type, null, $postOnly);
  $postOnly = false; // true - só adiciona se não existirem ordens no mesmo preço

  // Exemplo de ordem (compra ou venda): STOP
  // Essa ordem vai funcionar como uma MARKET order 
  // Que será disparada quando chegar no valor de stop estipulado
  $side = "buy"; // Lado compra ou venda: "buy" ou "sell"
  $type = "stop"; // Tipo: "stop" - ordem executada imediatamente
  $unitPriceStop = 20000; // Preço abaixo da melhor ordem de compra ou venda
  $amount = 0.001; // Quantidade de BTC
  $order = $exchange->createOrder(null, $amount, $side, $type, $unitPriceStop);

  // Exemplo de ordem (compra ou venda): STOP LIMIT
  // Essa ordem vai funcionar como uma LIMIT order 
  // Que será disparada quando chegar no valor de stop estipulado
  $side = "buy"; // Lado compra ou venda: "buy" ou "sell"
  $type = "stop-limit"; // Tipo: "stop-limit" - ordem adicionada no livro de ordens
  $unitPrice = 30000; // Cotação em reais de venda ou compra
  $unitPriceStop = 20000; // Preço abaixo da melhor ordem de compra ou venda
  $amount = 0.001; // Quantidade de BTC
  $order = $exchange->createOrder(null, $amount, $side, $type, $unitPriceStop);

  // Print do resultado
  var_dump($order);
  var_dump($order->Status);
  var_dump($order->Description);
  var_dump($order->Responses);
  var_dump($order->Responses[0]->OrderID);
  var_dump($order->Responses[0]->ExecID);
  var_dump($order->Responses[0]->ExecType);
  var_dump($order->Responses[0]->OrdStatus);
  var_dump($order->Responses[0]->LeavesQty);
  var_dump($order->Responses[0]->Symbol);
  var_dump($order->Responses[0]->OrderQty);
  var_dump($order->Responses[0]->LastShares);
  var_dump($order->Responses[0]->LastPx);
  var_dump($order->Responses[0]->CxlQty);
  var_dump($order->Responses[0]->TimeInForce);
  var_dump($order->Responses[0]->CumQty);
  var_dump($order->Responses[0]->MsgType);
  var_dump($order->Responses[0]->ClOrdID);
  var_dump($order->Responses[0]->OrdType);
  var_dump($order->Responses[0]->Side);
  var_dump($order->Responses[0]->Price);
  var_dump($order->Responses[0]->ExecSide);
  var_dump($order->Responses[0]->AvgPx);

?>