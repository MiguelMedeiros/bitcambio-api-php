<?php
  // Importar Classe
  require('../src/bitcambio.php');

  // Suas credenciais
  $apiKey = "";
  $apiPassword = "";
  $apiSecret = "";

  // Cria objeto da exchange
  $exchange = new Bitcambio($apiKey, $apiPassword, $apiSecret);

  // Todos os parâmetros são opcionais
  $page = 0;
  $pageSize = 20;

  // Busca suas ordens
  $myOrders = $exchange->myOrders($page, $pageSize); 

  // Print do resultado
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <?
        echo "Status: {$myOrders->Status} <br/>";
        echo "Descrição: {$myOrders->Description} <hr/>";
      ?>
      <h2>Tabela de compra</h2>
      <table class="table table-responsive table-hover">
      <thead>
        <tr>
          <td>ClOrdID</td>
          <td>OrderID</td>
          <td>CumQty</td>
          <td>OrdStatus</td>
          <td>LeavesQty</td>
          <td>CxlQty</td>
          <td>AvgPx</td>
          <td>Symbol</td>
          <td>Side</td>
          <td>OrdType</td>
          <td>OrderQty</td>
          <td>Price</td>
          <td>OrderDate</td>
          <td>Volume</td>
          <td>TimeInForce</td>
          <td>StopPx</td>
        </tr>
      </thead>
        <?php
        foreach($myOrders->Responses[0]->OrdListGrp as $order):
          echo "<tr>";
          echo "<td>{$order[0]}</td>";
          echo "<td>{$order[1]}</td>";
          echo "<td>{$order[2]}</td>";
          echo "<td>{$order[3]}</td>";
          echo "<td>{$order[4]}</td>";
          echo "<td>{$order[5]}</td>";
          echo "<td>{$order[6]}</td>";
          echo "<td>{$order[7]}</td>";
          echo "<td>{$order[8]}</td>";
          echo "<td>{$order[9]}</td>";
          echo "<td>{$order[10]}</td>";
          echo "<td>{$order[11]}</td>";
          echo "<td>{$order[12]}</td>";
          echo "<td>{$order[13]}</td>";
          echo "<td>{$order[14]}</td>";
          echo "<td>{$order[15]}</td>";
          echo "</tr>";
        endforeach;
        ?>
      </table>
    </div>
  </div>
    <h2>Objeto Completo</h2>
  <?php
    print_r($myOrders);
  ?>
</div>  
<!-- bootstrap styles -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- bootstrap styles -->