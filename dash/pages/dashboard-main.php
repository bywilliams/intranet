<?php
require_once ("../../conn/config.php");
require_once ("utils/list_frases.php");
require_once ("utils/currency_api.php");
include_once("../../helpers/url.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if($_SESSION["loggedin"] != true): 
    header("location: ./error.php");
endif;

// PEGA O HORÁRIO ATUAL DE ACORDO COM O TIMEZONE DE SP
$timezone = new DateTimeZone('America/Sao_Paulo');
$agora = new DateTime('now', $timezone);

// USADO PARA SAUDAÇÃO DE ACORDO COM HORARIO DO DIA
$dia_atual = $agora->format('d');
//echo $dia_atual;


setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$ano = date('Y');
$data = date('D'); // dia escrito ex: segunda
$mes = date('M'); // mes escrito ex: julho
$dia = date('d');
$m = date('m'); 

// $h = date('H');
// $i = date('i');
// $s = date('s');

// $hora_atual = time();
//     $hora_acessou = $_SESSION['hora_acessou'];
//     $tempo_online = $hora_atual - $hora_acessou;

// echo $tempo_online;

# remover carctere especial
// $str = "ola,-()/";
// $res1 = str_replace( array( '\'', '"', ',' , ';', '<', '>', '-', '()', '/' ), '', $str);
// $res = preg_replace('/[^a-zA-Z0-9_-]/s','',$str);
// echo $res1;


$semana = array(
    'Sun' => 'Domingo','Mon' => 'Segunda-Feira','Tue' => 'Terca-Feira','Wed' => 'Quarta-Feira','Thu' => 'Quinta-Feira','Fri' => 'Sexta-Feira','Sat' => 'Sábado'
);

$mes_extenso = array(
    'Jan' => 'Janeiro','Feb' => 'Fevereiro','Mar' => 'Marco','Apr' => 'Abril','May' => 'Maio','Jun' => 'Junho','Jul' => 'Julho','Aug' => 'Agosto','Nov' => 'Novembro','Sep' => 'Setembro','Oct' => 'Outubro','Dec' => 'Dezembro'
);

//echo $semana["$data"] . ", {$dia} de " . $mes_extenso["$mes"] . " de {$ano}";

$dia_semana = $semana["$data"];
$mes_atual = $mes_extenso["$mes"];


    //echo $dia_semana;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard main</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">
    <?php include_once("../../helpers/url.php");?>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style_local.css">

<style>
    .bi-cash{
        color: green;
    }
</style>

</head>

<body style="overflow: hidden;">
<div class="row d-flex justify-content-center">
                <div class="col-lg-8 col-md-12 mb-3">
                    <h1>
                        <form action="pesquisa.php" method="post" target="myFrame">
                                <div class="input-group flex-nowrap">
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Buscar" aria-describedby="addon-wrapping">
                                </div>
                        </form>
                    </h1>
                </div>
            </div>

        <div class="row">
            <div class="col-md-4 col-sm-6 calendar-box">
                <!-- <h1>box 1</h1> -->
                <div class="container">
                    <div class="card" style="cursor: pointer;">
                        <div class="front">
                            <div class="contentfront">
                                <div class="month">
                                    <table>
                                        <tr class="orangeTr">
                                            <th>S</th>
                                            <th>T</th>
                                            <th>Q</th>
                                            <th>Q</th>
                                            <th>S</th>
                                            <th>S</th>
                                            <th>D</th>
                                        </tr>
                                        <tr class="whiteTr">
                                            <th></th>
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                            <th>6</th>
                                        </tr>
                                        <tr class="whiteTr">
                                            <th>7</th>
                                            <th>8</th>
                                            <th>9</th>
                                            <th>10</th>
                                            <th>11</th>
                                            <th>12</th>
                                            <th>13</th>
                                        </tr>
                                        <tr class="whiteTr">
                                            <th>14</th>
                                            <th>15</th>
                                            <th>16</th>
                                            <th>17</th>
                                            <th>18</th>
                                            <th>19</th>
                                            <th>20</th>
                                        </tr>
                                        <tr class="whiteTr">
                                            <th>21</th>
                                            <th>22</th>
                                            <th>23</th>
                                            <th>24</th>
                                            <th>25</th>
                                            <th>26</th>
                                            <th>27</th>
                                        </tr>
                                        <tr class="whiteTr">
                                            <th>28</th>
                                            <th>29</th>
                                            <th>30</th>
                                            <th>31</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </table>
                                </div>
                                <div class="date">
                                    <div class="datecont">
                                        <div id="date"><?=$dia_atual;?></div>
                                        <div id="day"><?=$dia_semana?></div>
                                        <div id="month"><?=$mes_atual."/".$ano;?></div>
                                        <a href=""><i class="bi bi-pencil icons-menu"></i></a>
                                        <i class="fa fa-pencil edit" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="back">
                            <div class="contentback">
                                <div class="backcontainer">
                                    <?=$lista_frases[$dia_atual];?>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4 col-sm-6 news_api">
                <?php
                $internet = fsockopen('www.google.com.br',80);
                if(!$internet){
                   echo "Você está sem conexão com a internet no momento. Verifique a sua conexão e tente mais tarde!";
                }else{
                  //echo "Você tem conexao com internet";
                  ?>
                    <div class="card">
                   
                        <div class="card-body">
                            <h5 class="card-title" style="text-align: center;"><i class="bi bi-cash">&nbsp;</i>Conversor de Moedas&nbsp;<i class="bi bi-cash"></i> </h5>
                            <div class="input-group" style="margin-bottom: 10px;">
                                <span class="input-group-text" style="padding: 0.200rem 0.75rem; border-radius: 0;">R$</span>
                                <input type="number" id="real"  min="0" placeholder="Valor real a ser convertido" arial-label="Real" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" value=""></input>
                            </div>

                            <div class="input-group" style="margin-bottom: 10px;">
                                <span class="input-group-text" style="padding: 0.200rem 0.75rem; border-radius: 0;"><i class="bi bi-currency-dollar"></i></span>
                                <input type="number" id="dolar"  min="0"  step="0.01" min="0.01"  class="form-control" aria-label="Dollar amount (with dot and two decimal places)" value="">
                            </div>

                            <div class="input-group">
                                <span class="input-group-text" style="padding: 0.200rem 0.75rem; border-radius: 0;"><i class="bi bi-currency-euro"></i></i></span>
                                <input type="number" id="euro"  min="0" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" value="">
                            </div>
                            
                            <!-- <button type="submit" name="converter" value="Envia" class="btn input-group">Envia</button> -->
                        </div>
                    </div>
                
                <?php
               
                }

                ?>
            </div>
        </div>
 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- <script src=" js/currency_convert.js" type="text/javascript"></script> -->
    <script>
    let cardElement = document.querySelector(".card");

    cardElement.addEventListener("click", flip);

    function flip() {
        cardElement.classList.toggle("flipped")
    }

    function startTime() {
        var weekday = new Array();
        weekday[0] = "Domingo";
        weekday[1] = "Segunda";
        weekday[2] = "Terça";
        weekday[3] = "Quarta";
        weekday[4] = "Quinta";
        weekday[5] = "Sexta";
        weekday[6] = "Sábado";
        var month = new Array();
        month[0] = "Janeiro";
        month[1] = "Fevereiro";
        month[2] = "março";
        month[3] = "Abril";
        month[4] = "Maio";
        month[5] = "Junho";
        month[6] = "Julho";
        month[7] = "Agosto";
        month[8] = "Setembro";
        month[9] = "Outubro";
        month[10] = "Novembro";
        month[11] = "Dezembro";
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        var d = today.getDate();
        var y = today.getFullYear();
        var wd = weekday[today.getDay()];
        var mt = month[today.getMonth()];

        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('date').innerHTML = d;
        document.getElementById('day').innerHTML = wd;
        document.getElementById('month').innerHTML = mt + "/" + y;

        var t = setTimeout(startTime, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        };
        return i;
    }

    
    </script>

<script>

$("#real").on("change", function(){
    var jsdolar = parseFloat('<?=$dollar?>').toFixed(2);
    var jseuro = parseFloat('<?=$euro?>').toFixed(2);

    var valorFormatado = jsdolar;
    real = document.querySelector("[id='real']").value;

    dolar = document.querySelector("[id='dolar']").value = (real / jsdolar).toFixed(2);
    euro = document.querySelector("[id='euro']").value = (real / jseuro).toFixed(2);

    if(real == ""){
        dolar = document.querySelector("[id='dolar']").value = '';
        euro = document.querySelector("[id='euro']").value = '';
    }

});

   
$("#dolar").on("change", function(){
    var jsdolar = parseFloat('<?=$dollar?>').toFixed(2);
    var jseuro = parseFloat('<?=$euro?>').toFixed(2);
    
    var dolar = document.querySelector("[id='dolar']").value;
   
    real = document.querySelector("[id='real']").value = (jsdolar * dolar).toFixed(2);
    euro = document.querySelector("[id='euro']").value = (jsdolar * dolar / jseuro).toFixed(2);

    if(dolar == ""){
        real = document.querySelector("[id='real']").value = '';
        euro = document.querySelector("[id='euro']").value = '';
    }
});

$("#euro").on("change", function(){
    var jsdolar = parseFloat('<?=$dollar?>').toFixed(2);
    var jseuro = parseFloat('<?=$euro?>').toFixed(2);
    
    var euro = document.querySelector("[id='euro']").value;
    
    real = document.querySelector("[id='real']").value = (jseuro * euro).toFixed(2);
    dolar = document.querySelector("[id='dolar']").value = (jseuro * euro / jsdolar).toFixed(2);

    if(euro == ""){
        real = document.querySelector("[id='real']").value = '';
        dolar = document.querySelector("[id='dolar']").value = '';
    }
});
</script>

</body>

</html>
