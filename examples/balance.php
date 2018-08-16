<?php
  // Importar Classe
  require('../src/bitcambio.php');

  // Suas credenciais
  $apiKey = "";
  $apiPassword = "";
  $apiSecret = "";

  // Cria objeto da exchange
  $exchange = new Bitcambio($apiKey, $apiPassword, $apiSecret);

  // Busca balanço da conta
  $balance = $exchange->balance();

  // Print Resultado
  echo "Status: {$balance->Status} <br/>";
  echo "Descrição: {$balance->Description} <hr/>";

  echo "Saldo BTC: {$balance->Responses[0]->{11}->BTC} <br/>";
  echo "Saldo BTC (travado): {$balance->Responses[0]->{11}->BTC_locked} <hr/>";
  echo "Saldo BRL: {$balance->Responses[0]->{11}->BRL} <br/>";
  echo "Saldo BRL (travado): {$balance->Responses[0]->{11}->BRL_locked} <hr/>";
  
  // Objeto completo
  echo "Objeto Completo: <br/>";
  print_r($balance);
?>