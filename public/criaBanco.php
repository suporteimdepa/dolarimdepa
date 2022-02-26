<?php

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

$conn = new mysqli("dcrhg4kh56j13bnu.cbetxkdyhwsb.us-east-1.rds.amazonaws.com", "xx8yebzvs2xsadnv", "ru6yr3vnz3owquus", "ef3dlqv50o99cxud");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM dolar";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $dia = $row['list_dia'];
        $mes = convertMonthToNumber($row['list_mes']);
        $ano = $row['list_ano'];
        $dataAtual = $dia . "/" . $mes . "/" . $ano;
        $valor = $row["list_valor"];
      echo $valor . "-" .$dataAtual;
      echo "<br>";
    }
  } else {
    echo "0 results";
  }
  $conn->close();
