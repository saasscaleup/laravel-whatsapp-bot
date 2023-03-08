# WhatsApp DetectText ChatBot

How to build WhatsAPP AI ChatBot That Detect Text in images 

<a href="https://www.buymeacoffee.com/scaleupsaas"><img src="https://img.buymeacoffee.com/button-api/?text=Buy me a coffee&emoji=&slug=scaleupsaas&button_colour=BD5FFF&font_colour=ffffff&font_family=Cookie&outline_colour=000000&coffee_colour=FFDD00" /></a>

## Step 1 - AWS Lambda with AWS Rekognition

Go to Aws and create the *detect_image_text* lambda function.

Copy the content inside this file `lambda_function.py`

## Step 2 - Open Vonage(Nexmo) account

Go to [vonage home page](https://www.vonage.com/)

Choose `Log in` 

Choose `Communications APIs Login` -> Login portal

## Step 3 - Get WhatsApp Sandbox phone number 

Initiate WhatsApp Sandbox mode and follow the instructions

## Step 4 - Clone laravel-whatsapp-bot repository 

```
git clone https://github.com/saasscaleup/laravel-whatsapp-bot.git
```

```
cd laravel-whatsapp-bot 
```

```
cp .env.example .env
```

```
composer install
```

### If You are using Mac with valet - continue here
```
valet park
```

```
valet secure
```

## Step 5 - Set Vonage and Lambda URL values to your .env file

```
VONAGE_API_KEY=
VONAGE_API_SECRET=
VONAGE_WHATSAPP_NUMBER=
VONAGE_API_ENDPOINT="https://messages-sandbox.nexmo.com/v1/messages"

LAMBDA_API_ENDPOINT=
```

## Step 6 - Install Ngrok (For local use)

Go to https://dashboard.ngrok.com/ and follow the instructions

## Step 7 - Launch your Laravel WhatsApp Bot to the world - Let the GAME Begin 😎🤖

```
valet share
```

OR 

```
php artisan serve
```

### Update Webhooks url in Vonage Dashboard

```
Inbound optional, we will forward inbound messages to this URL.
HTTP POST
<YOUR DOMAIN>/api/whatsapp/webhooks/inbound
Status optional, allows you to receive message status updates (e.g. delivered, seen).
HTTP POST
<YOUR DOMAIN>/api/whatsapp/webhooks/status
```

## Support 🙏😃
  
 If you Like the tutorial and you want to support my channel so I will keep releasing amzing content that will turn you to a desirable Developer with Amazing Cloud skills... I will realy appricite if you:
 
 1. Subscribe to [My youtube channel](http://www.youtube.com/@ScaleUpSaaS?sub_confirmation=1) and leave a comment 
 2. Buy me A coffee ❤️ : https://www.buymeacoffee.com/scaleupsaas

Thanks for your support :)

<a href="https://www.buymeacoffee.com/scaleupsaas"><img src="https://img.buymeacoffee.com/button-api/?text=Buy me a coffee&emoji=&slug=scaleupsaas&button_colour=FFDD00&font_colour=000000&font_family=Cookie&outline_colour=000000&coffee_colour=ffffff" /></a>

