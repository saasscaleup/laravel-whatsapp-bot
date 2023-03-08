#!/usr/bin/python3.9

import urllib3
import boto3
import base64
import json

rekognition     = boto3.client("rekognition")
http            = urllib3.PoolManager()
        
class DetectText():
    """DetectText class: image coming from the GET event and analyzed with AWS rekognition
    
        REQUEST:
            - image_url [string]     : image url | required
    """

    def __init__(self, event):
        
        # check if the `event` contain Get parameters
        if "body" not in event:
            
            body = {
                "message": "[ERROR]: POST data is missing! Please try new POST request with BODY",
                "success": False,
                "request": event
            }
            
            self.response       = Response._response(400,body)
            
        else:
            
            self.event          = event

            # Set request parameters
            self.image_url  = json.loads(event['body'])["image_url"] if "image_url" in json.loads(event['body']) else 'test url'
            
            # Download image from link as base 64
            self.image_base64   = self.get_as_base64()
            
            # Run AWS Rekognition (AI) detect_text
            self.detect_image_text   = self.detect_image_text()
            
            # Run AWS Rekognition (AI) parse text
            self.detect_image_text_array   = self.parse_image_text()
            
            # Set proper response
            self.response       = self.parse_response()
        
    #Download image and return base64encode image
    def get_as_base64(self):
        print("Call to get_as_base64")
        
        try:
            image_download = http.request('GET',self.image_url)
        except:
            print('get_as_base64 error:', e)
            return False
        
        return base64.b64encode(image_download.data)
        
    def detect_image_text(self):
        '''Call to AWS Textract for object detection'''
        
        print("Call to AWS Rekognition for text detection on image '{}'".format(self.image_url))

        image_text = []
        
        if (self.image_base64==False):
            return image_text
        
        try:
            
            image_text = rekognition.detect_text(
              Image = {
                "Bytes": base64.b64decode(self.image_base64)
              }
            )
            
        except Exception as e:
            print('rekognition error:', e)
            return image_text
        
        return image_text
        
    def parse_image_text(self):
        print("Call to parse_image_text")
        image_text_arr = []
        
        if 'TextDetections' in self.detect_image_text:
            for obj in self.detect_image_text['TextDetections'] :
                if 'DetectedText' in obj and obj['DetectedText'] not in image_text_arr:
                    image_text_arr.append({"text":obj['DetectedText'],"confidence":obj['Confidence'],"type":obj['Type']})

        return image_text_arr
    
    def parse_response(self):
        print("Call to parse_response")
        
        # If no text generated -> return error
        if not self.detect_image_text_array:
            
            http_code = 400
            body = {
                "MESSAGE": "[ERROR]: Please try again with different image url or make sure image is available for download",
                "SUCCESS": False,
                "REQUEST": self.event["body"]
            }

        # If people generated -> return detect faces
        else:
            http_code = 200
            body = {
                "success": True,
                "data": self.detect_image_text_array,
                "message": "Image text has extracted completely!",
                "request": json.loads(self.event["body"])
            }
            
        return Response._response(http_code,body)


# Helper class to refactore response messages
class Response():
    def _response(http_code, body):
        return {
            "headers": {'Content-Type': 'application/json'},
            "statusCode": http_code,
            "body": body
        }


# main lambda handler - Code excute here
def lambda_handler(event, context):
    '''Method run by Lambda when the function is invoked''' 
    
    # calling Hashtags calss and invoke hastags detect
    result = DetectText(event)
    
    # return response 
    return result.response