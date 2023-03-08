<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
        
    /**
     * inbound
     *
     * @param  mixed $request
     * @return void
     */
    public function inbound(Request $request){
        
        \Log::info($request->all());

        // WhatsApp sender phone number
        $from = $request->from;
        
        if (!cache()->has("phone_{$from}")){

            $text = "Welcome to DetectTextBOT 🤖\r\n\r\n";
            $text .= 'Upload an Image and enjoy the Magic 🪄';

            cache()->put("phone_{$from}",true,now()->addDay());

        }else if($request->message_type=='image'){
            
            $image_url = $request->image['url'];
            $text = app('detect_text')->getImageText($image_url);
            
        }else{
            $text = "DetectTextBOT 🤖\r\n\r\nPlease upload image!";
        }

        // Send whatsapp message result
        $result = app('whatsapp')->sendMessage($from,$text);

        return response()->json($result,200);
    }
    
    /**
     * status
     *
     * @param  mixed $request
     * @return void
     */
    public function status(Request $request){
        \Log::Info($request->all());
        return response()->json([],200);
    }
}
