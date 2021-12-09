#include <WiFiManager.h> // https://github.com/tzapu/WiFiManager
#include <ESP8266WiFi.h>
#include <strings_en.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>
#include <DHT.h>
#include <DHT_U.h>

int SENSOR = D2;
DHT dht(SENSOR, DHT11);

//DHT dht;
//Para armar el URL verificar el IP del servidor web local con el comando IPCONFIG
String protocolo="http://";
String host="statusiot.000webhostapp.com";
String recurso="/sensores/php/recibir.php";
int port=80;
String url=protocolo+host+recurso;


String device="node1";//Nombre de la placa
int temp; //Variable a enviar
int humedad;//Variable a enviar
    
void setup() {
    dht.begin();
    WiFi.mode(WIFI_STA); // explicitly set mode, esp defaults to STA+AP

   
    Serial.begin(115200);
    
    // WiFi.mode(WiFi_STA); // it is a good practice to make sure your code sets wifi mode how you want it.

    //WiFiManager, Local intialization. Once its business is done, there is no need to keep it around
    WiFiManager wm;

    //reset settings - wipe credentials for testing
    //wm.resetSettings();

    // Automatically connect using saved credentials,
    // if connection fails, it starts an access point with the specified name ( "AutoConnectAP"),
    // if empty will auto generate SSID, if password is blank it will be anonymous AP (wm.autoConnect())
    // then goes into a blocking loop awaiting configuration and will return success result

    bool res;
    // res = wm.autoConnect(); // auto generated AP name from chipid
    // res = wm.autoConnect("AutoConnectAP"); // anonymous ap
    res = wm.autoConnect("AutoConnectAP","password"); // password protected ap

    if(!res) {
        Serial.println("Failed to connect");
        // ESP.restart();
    } 
    else {
        //if you get here you have connected to the WiFi    
        Serial.println("connected...yeey :)");
    }

     //YA ESTA CONECTADA LA PLACA

    

}

void loop() {
    
    //Actualizo las variables a enviar
    temp = dht.readTemperature();  // obtencion de valor de temperatura
    humedad = dht.readHumidity();   // obtencion de valor de humedad

    Serial.println("HUMEDAD: ");
    Serial.println(humedad);
    Serial.println("TEMPERATURA:");
    Serial.println(temp);
    
    //Preparo el String para enviar por metodo GET, notar que inicia con un ?
    String getData="?dispositivo="+device+"&temp="+String(temp)+"&humedad="+String(humedad)+"&servo="+String(88)+"&led="+String(1);

    
    WiFiClient client;
    HTTPClient http; //Creamos el objeto del tipo HTTPClient
    http.begin(client,url+getData); //Inicializamos el objeto con la URL+getData
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");//Cabecera del protocolo
       
    int httpCode=http.GET(); //Se envia por método GET y se guarda la respuesta 200=OK -1=ERROR
    String respuesta=http.getString();//Respuesta del Servidor

    //Se imprimen las respuestas
    Serial.println(httpCode);
    Serial.println(respuesta);

    //Se termina la comunicación
    http.end();

    delay(5000);
}
