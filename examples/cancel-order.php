<?php
  // Importar Classe
  require('../src/bitcambio.php');

  // Suas credenciais
  $apiKey = "";
  $apiPassword = "";
  $apiSecret = "";

  // Cria objeto da exchange
  $exchange = new Bitcambio($apiKey, $apiPassword, $apiSecret);

  $orderID = "1073880844"; // ID é o campo ClOrdID
  $cancelOrder = $exchange->cancelOrder($orderID);

  // Print do resultado
  var_dump($cancelOrder);
  var_dump($cancelOrder->Status);
  var_dump($cancelOrder->Description);
  var_dump($cancelOrder->Responses);
  var_dump($cancelOrder->Responses[0]->OrderID);
  var_dump($cancelOrder->Responses[0]->ExecID);
  var_dump($cancelOrder->Responses[0]->ExecType);
  var_dump($cancelOrder->Responses[0]->OrdStatus);
  var_dump($cancelOrder->Responses[0]->LeavesQty);
  var_dump($cancelOrder->Responses[0]->Symbol);
  var_dump($cancelOrder->Responses[0]->OrderQty);
  var_dump($cancelOrder->Responses[0]->LastShares);
  var_dump($cancelOrder->Responses[0]->LastPx);
  var_dump($cancelOrder->Responses[0]->CxlQty);
  var_dump($cancelOrder->Responses[0]->TimeInForce);
  var_dump($cancelOrder->Responses[0]->CumQty);
  var_dump($cancelOrder->Responses[0]->MsgType);
  var_dump($cancelOrder->Responses[0]->ClOrdID);
  var_dump($cancelOrder->Responses[0]->OrdType);
  var_dump($cancelOrder->Responses[0]->Side);
  var_dump($cancelOrder->Responses[0]->Price);
  var_dump($cancelOrder->Responses[0]->ExecSide);
  var_dump($cancelOrder->Responses[0]->AvgPx);

?>