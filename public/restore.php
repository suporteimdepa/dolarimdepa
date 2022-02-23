<?php

function restoreJson(){
        echo "Renomenando JSON";
        echo "<br>";

        rename("dolar.json", "dolar.json.OLD");

        echo "Restaurando....";
        echo "<br>";

        if (!copy("dolar.json.bak", "dolar.json")) {
            rename("dolar.json.OLD", "dolar.json");
            throw new Exception('Não foi possível realizar copia do arquivo...');
        } else {   
            echo "Deletando antigo JSON....";
            echo "<br>";

            unlink("dolar.json.OLD");

            echo "<br>";
            echo "Arquivo JSON restaurado!";
        }
}


if (isset($_GET['action']) && $_GET['action'] == 'restore') {
    try {
        restoreJson();
    } catch (Exception $e) {
        echo "<br>";
        echo "<h2>ERRO !!: ",  $e->getMessage(), "</h2>";
    }
 } else {
    echo "Precisa do parametro...";
 }


?>