<?php
error_reporting(E_ALL);
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$envs = parse_ini_file('../foo.env');

foreach ($envs as $key => $value) {
    $_ENV[$key] = $value;
}

$L_URL_DB = $_ENV['URL_DB'];
$L_USER_DB = $_ENV['USER_DB'];
$L_PASS_DB = $_ENV['PASS_DB'];
$L_TABLE_DB = $_ENV['TABLE_DB'];

$URL_DB = getenv('URL_DB');
$USER_DB = getenv('USER_DB');
$PASS_DB = getenv('PASS_DB');
$TABLE_DB = getenv('TABLE_DB');

//PRODUCAO-LOCAL
//$conn = new mysqli($L_URL_DB, $L_USER_DB, $L_PASS_DB, $L_TABLE_DB);

//PRODUCAO-nuvem
$conn = new mysqli($URL_DB, $USER_DB, $PASS_DB, $TABLE_DB);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    echo "<script>console.log('Debug: " . $output . "' );</script>";
}

$today = date("d-m");

$dataFeriados = array("01-01", "15-04", "21-04", "01-05", "16-06", "07-09", "12-10", "28-10", "02-11", "15-11", "25-12");

$verificaDataFeriado = function($arrayFeriados, $dataHoje){
    if (in_array($dataHoje, $arrayFeriados)) { 
        return true;
    } else {
        return false;
    }
};

//echo $today;

echo "<br>";

//$isFeriado($dataFeriados,$today);


//função para tranformar o texto 3,8999 para 3.8999 (Remover a virgula e usar PONTO e trasnformar em float)

    function floatvalue($val){
        $val = str_replace(",",".",$val);
        $val = preg_replace('/\.(?=.*\.)/', '', $val);
        return floatval($val);
    }

    function copyJson($newName){
        if (!copy("dolar.json", $newName)) {
            debug_to_console("Falha ao gravar arquivo de backup");
        }
    }

    debug_to_console("Verificando data...");

    if ($verificaDataFeriado($dataFeriados,$today) == false) {
        debug_to_console("Adicionando...");

        $today = date("m-d-Y");
        $url = "https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial='01-02-2022'&@dataFinalCotacao='".$today."'&"."$"."top=2&"."$"."orderby=dataHoraCotacao%20desc&"."$"."format=json&"."$"."select=cotacaoVenda,dataHoraCotacao";
        $itens = json_decode(file_get_contents($url),true);
        $usdptax = $itens["value"][0]["cotacaoVenda"];    

        debug_to_console($today . " - " . $usdptax);

        //encode para UTF8(joga a primeira letra para maiscula(Nome completo do mês, baseado no idioma))

        $mesNomeAtual = utf8_encode(ucwords(strftime('%B')));

        $ano = date("Y");
        $mes = $mesNomeAtual;
        $dia = date("d");
        $valor = round($usdptax, 4);

        $sql = "INSERT INTO dolar (list_ano, list_mes, list_dia, list_valor) VALUES ($ano, '$mes', $dia, $valor)";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
        
    } else {
        debug_to_console("Hoje é feriado! :D");
    }
  ?>






















<?php

/*acessar o site e pegar o valor do dolar ptax

    $page = file_get_contents('https://dolarhoje.com/ptax/');

    $doc = new DOMDocument();

    $doc->loadHTML($page);

    $spans = $doc->getElementsByTagName('b');

    $i = 0;

    foreach($spans as $span) {

        // Loop entre as SPANs, procurando aquele com a classe VALUE. No SEGUNDO span armazena na variavel.

        if ($span->getElementsByTagName('b') === int) {

             $i++;

             if ($i == 2) {

                $usdptax = floatvalue($span->nodeValue);

             }

        }

                $url = 'https://dolarhoje.com/ptax/';

        $content = file_get_contents($url);

        $first_step = explode( '<b>' , $content );

        $second_step = explode("</b>" , $first_step[1] );

        $dolar1 = substr($second_step[0], 3);

        $usdptax = floatvalue($dolar1);

    } */

?>



