<?php
error_reporting(E_ALL);
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

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
        copyJson("dolar.json.bak");
        debug_to_console("Adicionando...");

        $today = date("m-d-Y");
        $url = "https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial='01-02-2022'&@dataFinalCotacao='".$today."'&"."$"."top=2&"."$"."orderby=dataHoraCotacao%20desc&"."$"."format=json&"."$"."select=cotacaoVenda,dataHoraCotacao";
        $itens = json_decode(file_get_contents($url),true);
        $usdptax = $itens["value"][0]["cotacaoVenda"];    

        debug_to_console($today . " - " . $usdptax);

        //encode para UTF8(joga a primeira letra para maiscula(Nome completo do mês, baseado no idioma))

        $mesNomeAtual = utf8_encode(ucwords(strftime('%B'))); 

        $str = file_get_contents('dolar.json');
        $json = json_decode($str,true);

        if(isset($usdptax)){
            $AdditionalArray = array(
                'ano' => date("Y") ,
                'mes' => $mesNomeAtual ,
                'dia' => date("d") ,
                'valor' => round($usdptax, 4)
                );
              $json[]=$AdditionalArray;
              $jsonData = json_encode($json);

              file_put_contents('dolar.json', $jsonData);
              debug_to_console("Registro adicionado com sucesso!");
        }

        copyJson("dolar.json.updated.bak");
        
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



