<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{

    protected $api_secret;
    protected $api_url;
    protected $api_token;
    protected $whatsapp_number;
    protected $headers;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->api_token        = env('VONAGE_API_KEY');
        $this->api_secret       = env('VONAGE_API_SECRET');
        $this->api_url          = env('VONAGE_API_ENDPOINT');
        $this->whatsapp_number  = env('VONAGE_WHATSAPP_NUMBER');
        $this->headers          = $this->setRequestHeaders();
    }
    
    /**
     * sendMessage
     *
     * @param  mixed $params
     * @return void
     */
    public function sendMessage($to,$message)
    {
        $params = [
            "to"            => $to,
            "from"          => $this->whatsapp_number,
            "message_type"  => "text",
            "text"          => $message,
            "channel"       => "whatsapp"
        ];  

        $result = ['success'=>false,'body'=>[]];

        try {
            $response = Http::withHeaders($this->headers)->post($this->api_url, $params);
            $result = ['success'=>$response->ok(),'body'=>$response->body()];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $result;
    }
    
    /**
     * setRequestHeaders
     *
     * @return void
     */
    protected function setRequestHeaders(){

        $headers = [
            "Authorization" => "Basic " . base64_encode($this->api_token . ":" . $this->api_secret),
            "Content-Type" => "application/json",
            "Accept" => "application/json",
        ];

        return $headers;
    }
}
