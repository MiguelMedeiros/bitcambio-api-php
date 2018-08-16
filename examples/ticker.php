<?php
  // Importar Classe
  require('../src/bitcambio.php');

  // Cria objeto da exchange
  $exchange = new Bitcambio();

  // Busca pelo Ticker
  $ticker = $exchange->ticker();

  // Print do resultado
  echo "Par de Moedas: {$ticker->pair} <hr/>";
  
  echo "Última Ordem Efetuada: {$ticker->last} <br/>";
  echo "Última Ordem de Compra: {$ticker->buy} <br/>";
  echo "Última Ordem de Venda: {$ticker->sell} <hr/>";
  
  echo "Alta 24hras: {$ticker->high} <br/>";
  echo "Baixa 24hras: {$ticker->low} <hr/>";
  
  echo "Volume BTC 24hras: {$ticker->vol} <br/>";
  echo "Volume BRL 24hras: {$ticker->vol_brl} <hr/>";

  echo "Objeto Completo: <br/>";
  print_r($ticker);
  
?>