<?php
  // Importar Classe
  require('../src/bitcambio.php');

  // Cria objeto da exchange
  $exchange = new Bitcambio();

  // Busca Livro de Ordens
  $orderbook = $exchange->orderbook();

  // Print do resultado
?>
<div class="container">
  <?php echo "<h1>{$orderbook->pair}</h1>"; ?>
  <div class="row">
    <div class="col-md-6">
      <h2>Tabela de compra</h2>
      <table class="table table-hover">
      <thead>
        <tr>
          <td>Preço</td>
          <td>Quantidade</td>
          <td>Cliente ID</td>
        </tr>
      </thead>
        <?php
        foreach($orderbook->bids as $order):
          echo "<tr>";
          echo "<td>{$order[0]}</td>";
          echo "<td>{$order[1]}</td>";
          echo "<td>{$order[2]}</td>";
          echo "</tr>";
        endforeach;
        ?>
      </table>
    </div>
    <div class="col-md-6">
      <h2>Tabela de Venda</h2>
      <table class="table table-hover">
        <thead>
          <tr>
            <td>Preço</td>
            <td>Quantidade</td>
            <td>Cliente ID</td>
          </tr>
        </thead>
        <?php 
          foreach($orderbook->asks as $order):
            echo "<tr>";
            echo "<td>{$order[0]}</td>";
            echo "<td>{$order[1]}</td>";
            echo "<td>{$order[2]}</td>";
            echo "</tr>";
          endforeach;
        ?>
      </table>
    </div>
  </div>
    <h2>Objeto Completo</h2>
  <?php
    print_r($orderbook);
  ?>
</div>  
<!-- bootstrap styles -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- bootstrap styles -->