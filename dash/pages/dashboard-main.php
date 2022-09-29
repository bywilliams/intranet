<?php
require_once ("../../conn/config.php");
require_once ("utils/list_frases.php");
require_once ("utils/currency_api.php");
include_once("../../helpers/url.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


$id = $_SESSION['id'];

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


# pega as útlimas 3 tarefas pendentes definidas como urgente
$query_tarefas_urgentes = "SELECT name_task, status_task, dt_expired, priority FROM tb_task WHERE status_task = 0 AND cd_user =".$id." ORDER BY dt_expired ASC LIMIT 3";
$result_tarefas_urgentes = $conn->query($query_tarefas_urgentes);


//echo $query_tarefas_urgentes;

$query_projetos_pendentes = "SELECT title, percent_conclusion FROM projects WHERE user_id = ".$id." ORDER BY created_at DESC LIMIT 3";
$result_projetos_pendentes = $conn->query($query_projetos_pendentes);
//echo $query_projetos_pendentes;


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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">
    <?php include_once("../../helpers/url.php");?>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style_local.css">

    <style>
    .bi-cash {
        color: green;
    }

    @media (max-width: 1024px) {
        .conversor {
            margin-left: 0.6rem;
        }

    }

    .news_api {
        margin: 0;
    }

    .tarefas-dashboard {
        box-shadow:
            inset 0 -3em 3em rgba(0, 0, 0, 0.1),
            0 0 0 2px rgb(255, 255, 255),
            0.3em 0.3em 1em rgba(0, 0, 0, 0.3);
    }

    .calendar{
        height: 245px;
    }
    </style>

</head>

<body>
    <div class="row d-flex justify-content-center">
        <div class="col-lg-8 col-md-12 mb-4 ml-3">

            <form action="pesquisa.php" method="post" target="myFrame">
                <div class="input-group flex-nowrap">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Buscar"
                        aria-describedby="addon-wrapping">
                </div>
            </form>

        </div>
    </div>

    <div class="row d-flex justify-content-center mt-5">
        <div class="col-md-4 col-sm-8 calendar-box">
            <!-- <h1>box 1</h1> -->
            <div class="container calendar mb-3">
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
        <div class="col-md-4 col-sm-8 ms-2 news_api">
<?php
                $internet = fsockopen('www.google.com.br',80);
                if(!$internet){
                   echo "Você está sem conexão com a internet no momento. Verifique a sua conexão e tente mais tarde!";
                }else{
                  //echo "Você tem conexao com internet";
?>
            <div class="card conversor" style="position: relative;">

                <div class="card-body">
                    <h4 class="card-title" style="text-align: center;"><i class="bi bi-cash">&nbsp;</i>Conversor de
                        Moedas&nbsp;<i class="bi bi-cash"></i> </h4>
                    <div class="input-group" style="margin-bottom: 10px;">
                        <span class="input-group-text" style="padding: 0.200rem 0.75rem; border-radius: 0;">R$</span>
                        <input type="number" id="real" min="0" placeholder="Valor real a ser convertido"
                            arial-label="Real" class="form-control"
                            aria-label="Dollar amount (with dot and two decimal places)" value=""></input>
                    </div>

                    <div class="input-group" style="margin-bottom: 10px;">
                        <span class="input-group-text" style="padding: 0.200rem 0.75rem; border-radius: 0;"><i
                                class="bi bi-currency-dollar"></i></span>
                        <input type="number" id="dolar" min="0" step="0.01" min="0.01" class="form-control"
                            aria-label="Dollar amount (with dot and two decimal places)" value="">
                    </div>

                    <div class="input-group">
                        <span class="input-group-text" style="padding: 0.200rem 0.75rem; border-radius: 0;"><i
                                class="bi bi-currency-euro"></i></i></span>
                        <input type="number" id="euro" min="0" class="form-control"
                            aria-label="Dollar amount (with dot and two decimal places)" value="">
                    </div>
                </div>
            </div>

<?php
               
                }

?>
        </div>
        <div class="col-md-4 col-sm-8 mt-3">

            <!-- <div class="tarefas-dashboard" style="background-color: #F1F1F1;border-radius: 5px 5px 10px 10px; border: solid 1px #ccc;"> -->
            <div class="container-fluid tarefas-dashboard"
                style="background-color: #F1F1F1;border-radius: 5px 5px 10px 10px; border: solid 1px #ccc;">
                <!-- <div class="title_table">
                    <h4 align="center">Tarefas Urgentes</h4>  
                </div> -->
                <table class="table" style="text-align:center">
                    <thead>
                        <tr style="border-top: none">

                            <th scope="col">
                                <h4>Últimas Tarefas Cadatradas</h4>
                            </th>

                        </tr>
                    </thead>
<?php 
                        $i= 1;
                        if ($result_tarefas_urgentes->num_rows > 0) {
                            while ($row_tarefas = $result_tarefas_urgentes->fetch_assoc()) {
                                $name_tasks = $row_tarefas["name_task"];
                                $status = $row_tarefas["status_task"];
                                $priority = $row_tarefas["priority"];
                                $prazo = $row_tarefas["dt_expired"];
                                $colorPriority = "";
                                if ($status == 0) {
                                    $status = "pendente";
                                }
                                if($priority == 1){
                                    $colorPriority = "bg-danger";
                                }else if($priority == 2){
                                    $colorPriority = "bg-warning";
                                }else{
                                    $colorPriority = "bg-secondary";
                                }

                                
                                if ($name_tasks != "") {
?>
                                <tbody>
                                    <tr>
                                        <td class="badge <?=$colorPriority?>" style="color: #fff; border-top: none;"><?=$name_tasks?></td>
                                    </tr>
                                </tbody>
<?php
                                 }else{
                                    echo "Não há tarefas pendentes";
                                 }
                                $i++;
                            }
                        }
?>
                </table>
            </div>

        </div>

    </div>
    <div class="row d-flex justify-content-center mt-5">
        <h1>Projetos</h1>
    </div>
    <div class="row d-flex justify-content-center mt-5">
<?php
       $p = 1;
       $percent1 = $percent2 = $percent3 = 0;
       $title1 = $title1 = $title2 = $title3 = "";
       if ($result_projetos_pendentes->num_rows > 0) {
        
            while ($row_projetos = $result_projetos_pendentes->fetch_assoc()) {
                $title = $row_projetos["title"];
                $percent = $row_projetos["percent_conclusion"];

                switch ($p) {
                    case 1:
                        $title1 = $title;
                        $percent1 = $percent;
                        break;
                    case 2:
                        $title2 = $title;
                        $percent2 = $percent;
                        break;
                    case 3:
                        $title3 = $title;
                        $percent3 = $percent;
                        break;
                    default:
                        break;
                }
               
                if ($p==1) {
                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-8"">
                        <canvas id="myChart1"></canvas>
                    </div>
                    <?php
                }
                if ($p==2) {
                ?>
                    <div class="col-lg-4 col-md-4 col-sm-8"">
                        <canvas id="myChart2"></canvas>
                    </div>
                <?php
                }
                if ($p==3) {
                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-8"">
                        <canvas id="myChart3"></canvas>
                    </div>
                    <?php
                }
?>
<?php
            $p++;
            }
       }
?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../../js/Chart.js"></script>
    <!-- <script src="utils/charts_projects.js"></script> -->
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
    // conversão do Real para Dolar e Euro
    $("#real").on("change", function() {
        var jsdolar = parseFloat('<?=$dollar?>').toFixed(2);
        var jseuro = parseFloat('<?=$euro?>').toFixed(2);

        var valorFormatado = jsdolar;
        real = document.querySelector("[id='real']").value;

        dolar = document.querySelector("[id='dolar']").value = (real / jsdolar).toFixed(2);
        euro = document.querySelector("[id='euro']").value = (real / jseuro).toFixed(2);

        if (real == "") {
            dolar = document.querySelector("[id='dolar']").value = '';
            euro = document.querySelector("[id='euro']").value = '';
        }

    });

    // conversão do Dolar para Real e Euro
    $("#dolar").on("change", function() {
        var jsdolar = parseFloat('<?=$dollar?>').toFixed(2);
        var jseuro = parseFloat('<?=$euro?>').toFixed(2);

        var dolar = document.querySelector("[id='dolar']").value;

        real = document.querySelector("[id='real']").value = (jsdolar * dolar).toFixed(2);
        euro = document.querySelector("[id='euro']").value = (jsdolar * dolar / jseuro).toFixed(2);

        if (dolar == "") {
            real = document.querySelector("[id='real']").value = '';
            euro = document.querySelector("[id='euro']").value = '';
        }
    });

     // conversão do Euro para Dolar e Real
    $("#euro").on("change", function() {
        var jsdolar = parseFloat('<?=$dollar?>').toFixed(2);
        var jseuro = parseFloat('<?=$euro?>').toFixed(2);

        var euro = document.querySelector("[id='euro']").value;

        real = document.querySelector("[id='real']").value = (jseuro * euro).toFixed(2);
        dolar = document.querySelector("[id='dolar']").value = (jseuro * euro / jsdolar).toFixed(2);

        if (euro == "") {
            real = document.querySelector("[id='real']").value = '';
            dolar = document.querySelector("[id='dolar']").value = '';
        }
    });
    </script>

<script>
    // Mychart graficos dos projetos em forma de pizza 
    // CHART 1
    var percent = "%";
    var xValues1 = ["Concluido", "falta"];
    var yValues1 = [<?=$percent1?>, (100 - <?=$percent1?>)];
    var barColors1 = [
        "#D1512D",
        "#ccc"
    ];

    // CHART 2
    var xValues2 = ["Concluido", "falta"];
    var yValues2 = [<?=$percent2?>, (100 - <?=$percent2?>)];
    var barColors2 = [
        "#319DA0",
        "#ccc"
    ];

    // CHART 3
    var xValues3 = ["Concluido", "falta"];
    var yValues3 = [<?=$percent3?>, (100 - <?=$percent3?>)];
    var barColors3 = [
        "#781C68",
        "#ccc"
    ];


    new Chart("myChart1", {
        type: "pie",
        data: {
            labels: xValues1,
            datasets: [{
                backgroundColor: barColors1,
                data: yValues1
            }]
        },
        options: {
            title: {
                display: true,
                text: "% do Projeto <?=$title1?>"
            }
        }
    });

    new Chart("myChart2", {
        type: "pie",
        data: {
            labels: xValues2,
            datasets: [{
                backgroundColor: barColors2,
                data: yValues2
            }]
        },
        options: {
            title: {
                display: true,
                text: "% do Projeto <?=$title2?>"
            }
        }
    });

    new Chart("myChart3", {
        type: "pie",
        data: {
            labels: xValues3,
            datasets: [{
                backgroundColor: barColors3,
                data: yValues3
            }]
        },
        options: {
            title: {
                display: true,
                text: "% do Projeto <?=$title3?>"
            }
        }
    });
</script>


</body>

</html>