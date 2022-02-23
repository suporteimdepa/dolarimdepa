<?php

$str = file_get_contents('dolar.json');
$json = json_decode($str, true, JSON_NUMERIC_CHECK);

if (isset($_GET['ano'])) {

    $AdditionalArray = array(
        'ano' => $_GET['ano'],
        'mes' => $_GET['mes'],
        'dia' => $_GET['dia'],
        'valor' => $_GET['valor']
    );
    //append additional json to json file
    $json[] = $AdditionalArray;
    $jsonData = json_encode($json);

    file_put_contents('dolar.json', $jsonData);
}

function mediaMes($ano, $mes, $array)
{
    $total = 0;
    $total_dias = 0;
    foreach ($array as $cotacao) {
        if ($cotacao['mes'] == $mes and $cotacao['ano'] == $ano) {
            $total = $total + $cotacao['valor'];
            $total_dias++;
            $media = $total / $total_dias;
        }
    }

    if (isset($media)) {
        return number_format($media, 4, ',', '');
    } else {
        return 0;
    }
}

$totalItens = 0;
foreach ($json as $cotacao) {
    $totalItens++;
}

$meses = array(
    1 => 'Janeiro',
    'Fevereiro',
    'Março',
    'Abril',
    'Maio',
    'Junho',
    'Julho',
    'Agosto',
    'Setembro',
    'Outubro',
    'Novembro',
    'Dezembro'
);


function convertMonthToNumber($monthName)
{
    if ($monthName == "Janeiro") {
        $monthName = "January";
    }
    if ($monthName == "Fevereiro") {
        $monthName = "February";
    }
    if ($monthName == "Março") {
        $monthName = "March";
    }
    if ($monthName == "Abril") {
        $monthName = "April";
    }
    if ($monthName == "Maio") {
        $monthName = "May";
    }
    if ($monthName == "Junho") {
        $monthName = "June";
    }
    if ($monthName == "Julho") {
        $monthName = "July";
    }
    if ($monthName == "Agosto") {
        $monthName = "August";
    }
    if ($monthName == "Setembro") {
        $monthName = "September";
    }
    if ($monthName == "Outubro") {
        $monthName = "October";
    }
    if ($monthName == "Novembro") {
        $monthName = "November";
    }
    if ($monthName == "Dezembro") {
        $monthName = "December";
    }
    return date('m', strtotime($monthName));
}
//echo '<pre>';
//print_r($json);
//echo '</pre>';

// Declare month number and initialize it


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>TI Imdepa</title>


    <!-- Bootstrap -->
    <!-- JavaScript Bundle with Popper -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #FFFFFF;
            font-family: 'Inter';
            font-size: 14px;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-6">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th scope="row">Dolar PTAX</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_reverse(array_slice($json, -30, $totalItens)) as $cotacao) : ?>
                            <tr>
                                <td> <?php echo $cotacao['dia'] . "/" . convertMonthToNumber($cotacao['mes']) . "/" . $cotacao['ano']; ?> </td>
                                <td> <?php printf("%.4f", $cotacao['valor']) ?> </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="col-12 col-sm-6">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mês</th>
                            <th><?php echo date("Y") - 1; ?></th>
                            <th><?php echo date("Y"); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($meses as $mesAtual) : ?>
                            <tr>
                                <td><?php echo $mesAtual ?></td>
                                <td>
                                    <?php
                                    echo mediaMes(date("Y") - 1, $mesAtual, $json);
                                    ?></td>
                                <td>
                                    <?php
                                    echo mediaMes(date("Y"), $mesAtual, $json);
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p class="text-center">Dados atualizados automaticamente às 13:25</p>
            </div>
        </div>
    </div>




</body>