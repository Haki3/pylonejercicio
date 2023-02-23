<?php

//Aqui compruebo que esta gd instalado

if (!function_exists('gd_info')) {

    echo 'Error: JPGraph requiere la extensión GD de PHP instalada.';

    exit;

}

//Aqui compruebo que esta jpgraph instalado y sus clases funcionan correctamente 

if (!class_exists('Graph')) {

    if (file_exists('/home/ubuntu/Escritorio/example-app/jpgraph/src/jpgraph.php')) {

        require_once ('/home/ubuntu/Escritorio/example-app/jpgraph/src/jpgraph.php');

        require_once ('/home/ubuntu/Escritorio/example-app/jpgraph/src/jpgraph_bar.php');

    } else {

        echo 'Error: La clase Graph de JPGraph no se encuentra. Asegúrese de que la librería esté instalada y configurada correctamente.';

        exit;

    }

}

//Aqui se recoge el archivo json a imprimir

$json_file = 'resultado.json';

//Se decodifica 

$data = json_decode(file_get_contents(__DIR__.'/'.$json_file), true);

//Se crea el grafico usando jpgraph especificando las dimensiones del mismo

$graph = new Graph(600, 400);

$graph->SetScale('textlin');

$graph->title->Set('Título del gráfico');

$graph->xaxis->title->Set('Eje X');

$graph->yaxis->title->Set('Eje Y');

//Aqui se almacenan los datos del json

$barplot = new BarPlot($data);

//Y aqui se imprimen en lo que es el grafico

$graph->Add($barplot);

//Se crea un archivo pdf

$pdf_file = 'resultado.pdf';

//Y se finalmente se vuelca el contenido del grafico al archivo pdf 

$graph->Stroke($pdf_file);



header('Content-Type: application/pdf');

header('Content-Disposition: attachment; filename="' . basename($pdf_file) . '"');

readfile($pdf_file);

//Y para terminar se borra el pdf recien creado 

unlink($pdf_file);

?>

