<?php
  // Importar Classe
  require('bitcambio.php');

  // Suas credenciais
  $apiKey = "";
  $apiPassword = "";
  $apiSecret = "";

  // Cria objeto da exchange
  $exchange = new Bitcambio($apiKey, $apiPassword, $apiSecret);

  // $ticker = $exchange->ticker();
  // var_dump($ticker);
  
  // $orderbook = $exchange->orderbook();
  // var_dump($orderbook->pair);
  // var_dump($orderbook->bids);
  // var_dump($orderbook->asks);

  // $trades = $exchange->trades("2270000", "100");
  // var_dump($trades);

  $balance = $exchange->balance();
  var_dump($balance);

?>