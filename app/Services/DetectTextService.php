<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DetectTextService
{
    protected $api_url;
    protected $headers;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->api_url          = env('LAMBDA_API_ENDPOINT');
        $this->headers          = $this->setRequestHeaders();
    }
    
    /**
     * sendMessage
     *
     * @param  mixed $params
     * @return void
     */
    public function lambda(string $image_url)
    {
        $result = ['success'=>false,'body'=>[]];

        try {
            $response = Http::withHeaders($this->headers)->post($this->api_url, ['image_url'=>$image_url]);

            $result = [
                'success'   =>$response->ok(),
                'body'      => $response->json()
            ];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $result;
    }

    public function getImageText(string $image_url){

        $result = $this->lambda($image_url);
        $text = "DetectTextBOT 🤖\r\n\r\n";

        if ($result['success']){
            $text_array = [];
            $index = 1;

            foreach($result['body']['data'] as $row){
                if($row['type'] == 'LINE'){
                    //$text_array[] = $row['text'];
                    $text .= "{$index}) {$row['text']}\r\n";
                    $index++;
                }
            }

            //$text = implode(',',$text_array);
        }

        return $text;
    }

    protected function parseResult($data){
        $text = "DetectTextBOT 🤖\r\n\r\n";
        $index = 1;

        foreach($data['data'] as $row){
            $text .= "{$index}) {$row['text']}({$row['confidence']}%)\r\n";
            $index++;
        }

        return $text;
    }
    
    /**
     * setRequestHeaders
     *
     * @return void
     */
    protected function setRequestHeaders(){

        $headers = [
            "Content-Type"  => "application/json",
            "Accept"        => "application/json",
        ];

        return $headers;
    }
}
