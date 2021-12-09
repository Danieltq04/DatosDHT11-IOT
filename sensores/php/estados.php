<?php
$dispositivo='node1';

function temperatura_actual($dispositivo){
    require_once('conexion.php');
    $conn=new conexion();
    
    //Esta es la consulta para ver la temperatura en la tabla de estado
    //SELECT `temperatura` FROM `estado` WHERE `dispositivo`='node1';
    $queryTemp="SELECT `temperatura` FROM `estado` WHERE `dispositivo`='$dispositivo'";
    $resultado= mysqli_query($conn->conectardb(),$queryTemp);
    $row=mysqli_fetch_row($resultado);
    echo $row[0];

      
    }

function humedad_actual($dispositivo){
    require_once('conexion.php');
    $conn=new conexion();
    
    //Esta es la consulta para ver la temperatura en la tabla de estado
    //SELECT `humedad` FROM `estado` WHERE `dispositivo`='node1';
    $queryTemp="SELECT `humedad` FROM `estado` WHERE `dispositivo`='$dispositivo'";
    $resultado= mysqli_query($conn->conectardb(),$queryTemp);
    $row=mysqli_fetch_row($resultado);

    echo $row[0];
  
    }


    


?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<figure class="highcharts-figure">
    <div id="container-speed" class="chart-container"></div>
    <div id="container-rpm" class="chart-container"></div>
    <p class="highcharts-description">
        Estado del sistema
    </p>
    <br>
  
        <li><a href="../index.html">VOLVER</a></li>
</figure>




<script type="text/javascript">


var gaugeOptions = {
    chart: {
        type: 'solidgauge'
    },

    title: null,

    pane: {
        center: ['50%', '85%'],
        size: '140%',
        startAngle: -90,
        endAngle: 90,
        background: {
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
            innerRadius: '60%',
            outerRadius: '100%',
            shape: 'arc'
        }
    },

    exporting: {
        enabled: false
    },

    tooltip: {
        enabled: false
    },

    // the value axis
    yAxis: {
        stops: [
            [0.1, '#55BF3B'], // green
            [0.5, '#DDDF0D'], // yellow
            [0.9, '#DF5353'] // red
        ],
        lineWidth: 0,
        tickWidth: 0,
        minorTickInterval: null,
        tickAmount: 2,
        title: {
            y: -70
        },
        labels: {
            y: 16
        }
    },

    plotOptions: {
        solidgauge: {
            dataLabels: {
                y: 5,
                borderWidth: 0,
                useHTML: true
            }
        }
    }
};

// TEMPERATURA
var chartSpeed = Highcharts.chart('container-speed', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 60,
        title: {
            text: 'Temperatura'
        }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: 'Temperatura',
        data: [<?php temperatura_actual($dispositivo); ?>],
        dataLabels: {
            format:
                '<div style="text-align:center">' +
                '<span style="font-size:25px">{y}</span><br/>' +
                '<span style="font-size:12px;opacity:0.4">ºC</span>' +
                '</div>'
        },
        tooltip: {
            valueSuffix: ' ºC'
        }
    }]

}));

// HUMEDAD
var chartRpm = Highcharts.chart('container-rpm', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 100,
        title: {
            text: 'HUMEDAD'
        }
    },

    series: [{
        name: 'HUMEDAD',
        data: [<?php humedad_actual($dispositivo); ?>],
        dataLabels: {
            format:
                '<div style="text-align:center">' +
                '<span style="font-size:25px">{y:.1f}</span><br/>' +
                '<span style="font-size:12px;opacity:0.4">%</span>' +
                '</div>'
        },
        tooltip: {
            valueSuffix: ' %'
        }
    }]

}));





</script>

<?php
//Vuelvo a acargar la pagina para actuallizar los datos
echo '<script type="text/JavaScript"> location.reload(); </script>';
sleep(2);
?>