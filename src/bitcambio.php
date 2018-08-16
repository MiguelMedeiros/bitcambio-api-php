<?php

class Bitcambio
{
  protected $apiKey = "";
  protected $apiPassword = "";
  protected $apiSecret = "";
  protected $brokerID = 11;

  protected $urlBase = "https://bitcambio_api.blinktrade.com/api/v1";
  protected $urlBaseTrade = "https://bitcambio_api.blinktrade.com/tapi/v1";

  public function __construct ()
  {
    $arguments = func_get_args();
    if($arguments){
      $this->apiKey = $arguments[0];
      $this->apiPassword = $arguments[1];
      $this->apiSecret = $arguments[2];
    }
  }

  // API Documentation: https://blinktrade.com/docs/?javascript#ticker
  public function ticker ($currency = 'BTC')
  {
    $apiURL = "/BRL/ticker?crypto_currency={$currency}";

    return $this->initCurl($apiURL);
  }

  // API Documentation: https://blinktrade.com/docs/?javascript#orderbook
  public function orderbook ($currency = 'BTC')
  {
    $apiURL = "/BRL/orderbook?crypto_currency={$currency}";

    return $this->initCurl($apiURL);
  }

  // API Documentation: https://blinktrade.com/docs/?javascript#trades
  public function trades ($since = "", $limit = "100")
  {
    $apiURL = "/BRL/trades?since={$since}&limit={$limit}";

    return $this->initCurl($apiURL);
  }

  // API Documentation: https://blinktrade.com/docs/?javascript#balance
  public function balance ()
  {
    $apiURL = "/message";
    $apiKeyRequired = true;
    $nonce = $this->nonce();
    $fields = [
      "BalanceReqID" => $nonce,
      "MsgType"      => "U2"
    ];

    return $this->initCurl($apiURL, $apiKeyRequired, $fields, $nonce);
  }

  // API Documentation: https://blinktrade.com/docs/?javascript#my-orders
  public function myOrders ($page = 0, $pageSize = 20)
  {
    $apiURL = "/message";
    $apiKeyRequired = true;
    $nonce = $this->nonce();
    $fields = [
      "MsgType"     => "U4",
      "OrdersReqID" => $nonce,
      "Page"        => $page,
      "PageSize"    => $pageSize
    ];

    return $this->initCurl($apiURL, $apiKeyRequired, $fields, $nonce);
  }

  // API Documentation: https://blinktrade.com/docs/?javascript#send-order
  public function createOrder (
    $unitPrice = null,
    $amount,
    $side = "buy",
    $type = "limit",
    $stopPrice = 0,
    $postOnly = false
  ) {

    if($side == "buy"){
      $side = 1; // buy side order
    }else{
      $side = 2; // sell side order
    }

    $apiURL = "/message";
    $apiKeyRequired = true;
    $nonce = $this->nonce();
    $fields = [
      "MsgType"     => "D",
      "ClOrdID"     => (string) $nonce,
      "Symbol"      => "BTCBRL",
      "Side"        => (string) $side,
      "OrderQty"    => $amount*1e8,
      "BrokerID"    => $this->brokerID
    ];

    switch($type){
      case "market":
        $fields["OrdType"] = "1";
        $fields["Price"] = $unitPrice*1e8;
        break;
      case "limit":
        $fields["OrdType"] = "2";
        $fields["Price"] = $unitPrice*1e8;
        $fields["postOnly"] = $postOnly;
        break;
      case "stop":
        $fields["OrdType"] = "3";
        $fields["stopPrice"] = $stopPrice;
        break;
      case "stop-limit":
        $fields["OrdType"] = "4";
        $fields["Price"] = $unitPrice*1e8;
        $fields["stopPrice"] = $stopPrice;
        break;
      default: 
        $fields["OrdType"] = "2"; // limit order
        $fields["Price"] = $unitPrice*1e8;
        $fields["postOnly"] = $postOnly;
    }

    return $this->initCurl($apiURL, $apiKeyRequired, $fields, $nonce);
  }

  // API Documentation: https://blinktrade.com/docs/?javascript#cancel-order
  public function cancelOrder ($id = '')
  {
    $apiURL = "/message";
    $apiKeyRequired = true;
    $nonce = $this->nonce();
    $fields = [
      "MsgType" => "F",
      "ClOrdID" => $id
    ];

    return $this->initCurl($apiURL, $apiKeyRequired, $fields, $nonce);
  }

  private function nonce () 
  {
    return (int) (microtime(true) * 1000);
  }

  private function hmac ($request, $secret, $type = 'sha256', $digest = 'hex') 
  {
    $base64 = ($digest === 'base64');
    $binary = ($digest === 'binary');
    $hmac = hash_hmac ($type, $request, $secret, ($binary || $base64) ? true : false);
    if ($base64)
      $hmac = base64_encode ($hmac);
    return $hmac;
  }

  private function initCurl ($url = '', $apiKeyRequired = false, $fields = [], $nonce = 1)
  {
    $curl = curl_init();

    $method = 'GET'; // Default Method for all Public endpoints
    $header = [
      'Content-Type: application/json'
    ];

    if($apiKeyRequired){
      $method = 'POST'; // Method is POST for all Trade API endpoints

      // Set header
      array_unshift($header, "Signature: {$this->hmac($nonce, $this->apiSecret)}");  
      array_unshift($header, "Nonce: {$nonce}");
      array_unshift($header, "APIKey: {$this->apiKey}");

      $this->urlBase = $this->urlBaseTrade;
    }

    $fields = json_encode($fields);
    $options = [
      CURLOPT_URL => $this->urlBase.$url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_POSTFIELDS => $fields,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_HTTPHEADER => $header
    ];

    curl_setopt_array($curl, $options);    
    $response = curl_exec($curl);    
    $err = curl_error($curl);    
    curl_close($curl);

    return $err
      ? "cURL Error #: {$err}"
      : json_decode($response);
  }
}

?>