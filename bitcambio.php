<?php

class Bitcambio
{
  protected $apiKey = "";
  protected $apiPassword = "";
  protected $apiSecret = "";
  

  protected $urlBase = "https://bitcambio_api.blinktrade.com/api/v1";
  protected $urlBaseTrade = "https://bitcambio_api.blinktrade.com/tapi/v1";

  public function __construct ()
  {
    $arguments = func_get_args();
    $this->apiKey = $arguments[0];
    $this->apiPassword = $arguments[1];
    $this->apiSecret = $arguments[2];
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

    $fields = ["MsgType" => "U2"];
    
    return $this->initCurl($apiURL, $apiKeyRequired, $fields);
  }

  private function nonce () {
      return (string) time ();
  }

  private function hmac ($request, $secret, $type = 'sha256', $digest = 'hex') {
      $base64 = ($digest === 'base64');
      $binary = ($digest === 'binary');
      $hmac = hash_hmac ($type, $request, $secret, ($binary || $base64) ? true : false);
      if ($base64)
          $hmac = base64_encode ($hmac);
      return $hmac;
  }

  private function initCurl ($url = '', $apiKeyRequired = false, $fields = [], $message = "")
  {
    $curl = curl_init();
    
    // Default Method for all Public endpoints
    $method = 'GET';

    $header = [
      'Content-Type: application/json'
    ];
        
    if($apiKeyRequired){
      // Method is POST for all Trade API endpoints
      $method = 'POST';

      // Creating nonce
      $nonce = $this->nonce();

      // Set nonce to fields
      $fields["BalanceReqID"] = (int) $nonce;

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
    
    var_dump($header, $fields, $this->urlBase.$url, $method, $response);
    
    return $err
      ? "cURL Error #: {$err}"
      : json_decode($response);
  }
}