#include<Servo.h>
#include "ESP8266WiFi.h"
#include <ESP8266HTTPClient.h>
String payload="0";
int httpCode=0;
int Loop=0;
const char* ssid = "SAICE";
const char* password = "saice4321iu";
Servo motor;
int inputPin=A0;
int inputValue=0;
void setup() {
  // put your setup code here, to run once:
  Serial.begin(9600);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
     delay(500);
     Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println(WiFi.localIP());
  pinMode(inputPin,INPUT);
  motor.attach(13);
  motor.write(90);
}

void loop() {
  inputValue = analogRead(inputPin);
  HTTPClient http;  //Declare an object of class HTTPClient
  if(Loop == 5)
  {
    Loop =0;
    String request = "http://192.168.218.88/dashboard/experiment/test.php?who=esp8266&Moisture=";
    request = request + inputValue;
    Serial.print("Sending Request to : ");
    Serial.println(request);
    http.begin(request);
    httpCode = http.GET();
    if (httpCode > 0) { //Check the returning code
      payload = http.getString();   //Get the request response payload
    Serial.println(payload);                     //Print the response payload
    if(payload.toInt() != -1)
     {
        motor.write(payload.toInt());
        delay(20);
        delay(3000);
     }
    }
  }
  ++Loop;
  delay(50);
    if(inputValue<300)
    {
      if(motor.read()!=180)
        {
          motor.write(180);
          delay(20);
        }
    }
  else
    {
      if(motor.read()!=90)
      {
        motor.write(90);
        delay(20);
      }
    }
}
