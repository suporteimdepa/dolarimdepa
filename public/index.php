<?php
// ###  VARIVAEIS
$str        = file_get_contents('dolar.json');
$json       = json_decode($str, true, JSON_NUMERIC_CHECK);
$totalItens = count($json);

// ###  FUNÇÕES
function mediaMes($ano, $mes, $array){
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
        return "";
    }
}

function convertMonthToNumber($monthName){
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


// ## ARRAY MESES
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #FFFFFF;
            font-family: 'Inter';
            font-size: 16px;
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
                        <?php foreach (array_reverse(array_slice($json, -30, $totalItens)) as $cotacao) :
                            $dia = $cotacao['dia'];
                            $mes = convertMonthToNumber($cotacao['mes']);
                            $ano = $cotacao['ano'];
                            $dataAtual = $dia . "/" . $mes . "/" . $ano;
                            ?>
                            
                            <tr>
                                <td> <?php 
                                        if(date("d/m/Y") == $dataAtual) {
                                            echo "<h5><b>" . $dataAtual . "</b></h5>";
                                        } else {
                                            echo $dataAtual;
                                        }
                                    ?>
                                </td>
                                <td> <?php 
                                        if(date("d/m/Y") == $dataAtual) {
                                            echo "<b><h5>";
                                            printf("%.4f", $cotacao['valor']);
                                            echo "</b></h5>";
                                        } else {
                                            printf("%.4f", $cotacao['valor']);
                                        }
                                    ?>
                                </td>
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
                            <th><?php echo date("Y") - 2; ?></th>
                            <th><?php echo date("Y") - 1; ?></th>
                            <th><?php echo date("Y"); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($meses as $mes) : ?>
                            <tr>
                                <td> <?php echo $mes ?></td>
                                <td> <?php echo mediaMes(date("Y") - 2, $mes, $json); ?> </td>
                                <td> <?php echo mediaMes(date("Y") - 1, $mes, $json); ?> </td>
                                <td> <?php echo mediaMes(date("Y"), $mes, $json); ?> </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p class="text-center">Dados atualizados automaticamente às 13:25</p>
            </div>
        </div>
    </div>




</body>