<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HUMEDAD - Grafico Historico</title>
</head>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        En este grafico podemos ver la humedad relativa por cada hora
    <br>
  
        <li><a href="https://statusiot.000webhostapp.com/sensores/html/formularioGraficoHumedad.html">VOLVER</a></li>
    </p>
</figure>

<?php

//recibe las variables del formulario
$dispositivoF=$_GET['dispositivo'];
$intervaloF=$_GET['intervalo'];
$mesF=$_GET['mes'];
$diaF=$_GET['dia'];


//Vamos a crearuna funcion que nos devuelva los datos en el formato que necesitamos para graficar en JavaScript

function temperatura_diaria($dispositivo,$intervalo,$mes,$dia){
    require_once('conexion.php');
    $conn=new conexion();
    
    $ano=date("Y");


//Esta es la consulta
//SELECT UNIX_TIMESTAMP(fechaRegistro), `temperatura` FROM `historico` WHERE YEAR(fechaRegistro)='2021' AND MONTH(fechaRegistro)='11' AND DAY(fechaRegistro)='02' AND `dispositivo`='node1';
$queryTemp="SELECT UNIX_TIMESTAMP(fechaRegistro), `humedad` FROM `historico` WHERE YEAR(fechaRegistro)='$ano' AND MONTH(fechaRegistro)='$mes' AND DAY(fechaRegistro)='$dia'AND `dispositivo`='$dispositivo';";
$resultado= mysqli_query($conn->conectardb(),$queryTemp);


//Con este while imprimo [tiempoLinux,valor1],[tiempoLinux,valor2],..... que es el formato que necesito
while($row=mysqli_fetch_row($resultado)){
    echo "[";
    echo ($row[0]-(60*60*3))*1000; //La hora del servidor está en GMT 0, nosotros somosm GMT -3. Entonces restamos 3 horas en segundos
                                    //60*60*3 para que coincida con nuestro
    echo ",";
    echo $row[1];
    echo "],";

    //Cuenta la cantidad de veces el intervalo para salterse filas
    for($x=0;$x<$intervalo;$x++){
        $row=mysqli_fetch_row($resultado);
        }
    }

}

?>

<script type="text/javascript">
Highcharts.chart('container', {
    chart: {
        type: 'spline',
        zoomType: 'x'
    },
    title: {
        text: 'Electronica Aplicada a IOT'
    },
    subtitle: {
        text: 'Gráfico Histórico de la Humedad recibida'
    },
    xAxis: {
        type:'datetime'
       // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Temperatura (°C)'
        }
    },
    /*plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },*/
    series: [{
        name: '<?php echo $dispositivoF ?>',
        data: [
            
         <?php  //temperatura_diaria("node1","1","11","04"); 
         temperatura_diaria($dispositivoF,$intervaloF,$mesF,$diaF);
         
         
         ?>
    
    
    
    ]
    }]
});

</script>
