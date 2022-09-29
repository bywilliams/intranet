<?php 
require_once ("../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once ("inc/valida_guest.php");

if($_SESSION["loggedin"] != true): 
    header("location: ./error.php");
endif;

$id = $_SESSION["id"];

# dia e hora atual no timezone de SP
$timezone = new DateTimeZone('America/Sao_Paulo');
$agora = new DateTime('now', $timezone);
$data_atual = $agora->format('Y-m-d H:i:s');
//echo $data_atual;

# Etapas do projeto
$lista_etapas = [
    '1'=> "Levantamento de Requisitos",
    '2'=> "Arquitetura e Planejamento",
    '3'=> "Desenvolvimento",
    '4'=> "Suporte pós Deploy"
];


// Select dos projetos 
$img_projeto =
$title = 
$descricao = 
$percentual_conclusao = 
$id_usuario = "";

$SQL_Projeto = "SELECT * FROM projects WHERE user_id = ".$id." ORDER BY percent_conclusion ASC";
//echo $SQL_Projeto."<br>";
$result = $conn->query($SQL_Projeto);


# BD do heroku usa auto_increment de 10 em 10 
# pegamos o último registro caso tenha, para usa-lo como padrão na incrementação manual
$query_ultimo_id = "SELECT id FROM projects_phases ORDER BY id DESC LIMIT 1";
$result_ultimo_id = $conn->query($query_ultimo_id);

$last_id = 0; #usada para a soma manual do auto incremento
$id_increment = null; # variavel que será usada para receber o numero do ultimo id registrado, será usado para o auto incremento manual

if ($result_ultimo_id->num_rows > 0) {
    while ($row = $result_ultimo_id->fetch_assoc()){
        $last_id = $row["id"];
    }
}

if (empty($last_id)) {
    $id_increment = 1;
}else{
    $id_increment = $last_id + 1;
}


if (isset($_POST["aplicar"])) {

    $new_percent = $_POST["project_percent"] + 25; # incremento de porcentagem
    $id_projeto = $_POST["id_projeto"]; #id projeto
    $phase_id = $_POST["nr_etapa"]; # etapada que ira começar
    $descricao = $_POST["descricao"];
    $nr_old_phase = $_POST["nr_phase"]; # phase anterior concluída
    $phase_name = null;
    $update_at = $data_atual;
    //echo "numero da fase anterior $nr_old_phase";

    # se estiver na fase inicial a data de inicio será a data de quando o projeto foi cadastrado
    # Se estiver na etpada 2 em diante pega a data de termino da ultimo fase como inicio da atual 
    if ($phase_id == 1):
        $dt_start = $_POST["dt_start"];
    elseif($phase_id > 1):
            $query_last_date = "SELECT dt_conclusion FROM projects_phases WHERE project_id = ".$id_projeto." ORDER BY id DESC LIMIT 1";
            $result_project_phase = $conn->query($query_last_date);
            //echo $query_last_date."<br>";
            if ($result_project_phase->num_rows > 0) {
                while ($row_last_date = $result_project_phase->fetch_assoc()){
                    $lastDate = $row_last_date["dt_conclusion"]; 
                    $dt_start = $lastDate;
                }
            }
    endif;

    //echo "numero da etapada: $phase_id, data de incio da fase atual $dt_start";
    //echo "numero da fase anterior $nr_old_phase";

    switch ($phase_id):
        case 1:
            $phase_name = $lista_etapas['1'];
            break;
        case 2:
            $phase_name = $lista_etapas['2'];
            break;
        case 3: 
            $phase_name = $lista_etapas['3'];
            break;
        case 4:
            $phase_name = $lista_etapas['4'];
            break;
        default:
            break;
    endswitch;
    
    $SQL_project_update = "UPDATE projects SET percent_conclusion = $new_percent, update_at = '$data_atual', phase = $phase_id WHERE id = ".$id_projeto;
    //echo $SQL_project_update;
    if($result_project_update = mysqli_query($conn,$SQL_project_update)):
    else:
        echo "error";
    endif;


    #registrar etapa do projeto
    $SQL_Phase = "INSERT INTO projects_phases (
        id,
        phase_name,
        phase_id,
        extra_info,
        project_id,
        user_id,
        dt_start,
        dt_conclusion,
        finish
    )VALUE(
        ".$id_increment.",
        '".$phase_name."',
        ".$phase_id.",
        '".$descricao."',
        ".$id_projeto.",
        ".$id.",
        '".$dt_start."',
        '".$data_atual."',
        'S'
    )";
    echo $SQL_Phase;
    
    if($result_project_phase = mysqli_query($conn,$SQL_Phase)):
        echo "<script>
        alert('Projeto atualizado com sucesso!'); location= '../pages/projetos.php';
        </script>";
    else:
        echo "error";
    endif;            
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos</title>
    <?php include_once("../../helpers/url.php");?>
    <?php include_once("../../helpers/url.php");?>
        <script src="../../js/sweetalert.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/style_local.css">
</head>

<style>
    input[type="checkbox"]{
        accent-color: green;
    }
    .card-img-top{
        height: 189px;
    }
</style>

<body>
    <div class="container-fluid dashboard-content">
        <h1 style="text-align: center">Projetos</h1>
        <br>
        <div class="px-lg-5">
            <div class="row">
                <?php
                $t = 0;
                $count = 0;
                if ($result->num_rows){
                    while ($row = $result->fetch_assoc()){
                        $id_projeto = $row['id'];
                        $img_projeto = $row["file_name"];
                        $title = $row["title"];
                        $descricao = $row["description"];
                        $percentual_conclusao = $row["percent_conclusion"];
                        $phase = $row["phase"];
                        //echo $phase;
                        $id_usuario = $row["user_id"];
                        $created_at = $row["created_at"];
                    ?>

                <!-- Gallery item -->
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class=" rounded shadow-sm" style="background-color: #F6F6F6;">
                    <a href=""><img src="assets/img/portfolio/<?=$img_projeto?>" alt="" class="img-fluid card-img-top"></a>
                        <div class="p-4">
                            <a href="projetos_detalhes.php?id=<?=$id_projeto?>"><h5> <?=$title;?></h5></a>
                            <p class="small text-muted mb-0 my-1"><?=$descricao?></p>
                            <p>Conclusão do projeto:</p>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: <?=$percentual_conclusao?>%" aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"><?=$percentual_conclusao?>%</div>
                            </div>
                            <br>
                            <div class="edit_project<?=$t?>" align="center" style="min-height: 50px">
<?php 
                            if ($percentual_conclusao < 100) {
?>
                                <a href="#!" id="grupos<?=$t;?>" onclick="atualizar(<?=$t?>)"><i class="fa-solid fa-pen-to-square text-success fa-2x"></i></a>
<?php
                            }else{
                                ?>
                               <span  data-toggle="tooltip_bt" title="Projeto Concluído"><i class="fa-solid fa-flag-checkered text-success fa-2x"></i></span>
                                <?php
                            }
?>
                            </div>
                        </div>
                    </div>
                       <div class="tooltip_" id="tooltip_<?=$t?>">
                            <div id="conteudo">
                                <div class="bloco" style="display: flex; justify-content: space-between">
                                <h1>Editar Projeto</h1>
                                <a href="#!" id="close<?=$t?>"><i  class="fa-solid fa-xmark"></i></a>
                                </div>
                                <small style="color: #42855B">Marque a etapa e clique em enviar se estiver concluída</small>
                                <form method="post" action="">
                                    <div class="bloco">
                                        <label for="">Etapa atual:</label>
<?php
                                            #Checa se já exite alguma etapa em andamento no projeto
                                            if ($phase) {
                                                foreach ($lista_etapas as $nr_etapa => $etapa_name) {
                                                    //echo "$nr_etapa, $phase";
                                                    # se o numero da etapa do for for igual a etapa cadastrada no projeto ou for menor do que a etapa atual do projeto
                                                    # então siginifica que esta ativa em processo de conclusão, sendo assim "checked e disabled
                                                    if ($nr_etapa == $phase || $nr_etapa < $phase) {
?>
                                                        <label>
                                                            <input type="checkbox" class="radio" value="<?=$nr_etapa?>" name="nr_etapa"
                                                         checked disabled/> <?=$etapa_name?>
                                                        </label>
<?php
                                                     # se o numero da etapa for igual ao numero da próxima phase que precisa ser concluída
                                                     # então libera o checkbox da próxima etapa 
                                                    }else if($nr_etapa == $phase+1){
?>
                                                        <label>
                                                            <input type="checkbox" class="radio" value="<?=$nr_etapa?>" name="nr_etapa" id="nr_etapa<?=$t?>"
                                                            <?php if($nr_etapa > $next_phase){echo "";}?> />&nbsp;<span style="background-color: #6FEDD6; color: #000;"><?=$etapa_name?></span>
                                                        </label>
<?php
                                                    }else{ # caso contratio são etapas mais adiantes que ainda não estão liberadas
?>
                                                        <label>
                                                            <input type="checkbox" class="radio" value="<?=$nr_etapa?>" name="nr_etapa"
                                                            <?php if($nr_etapa > $next_phase){echo "disabled";}?>/> <?=$etapa_name?>
                                                        </label>
<?php
                                                    }
                                                    $next_phase = $phase +1;
                                                }
                                            }else{ # se nenhuma etapa ainda foi iniciada todos os checkbox são liberados
                                                foreach ($lista_etapas as $nr_etapa => $etapa_name) {
                                                    //echo "$nr_etapa";
                                                    if ($nr_etapa == 1) {
?>
                                                        <label>
                                                            <input type="checkbox" class="radio" id="nr_etapa<?=$t?>" value="<?=$nr_etapa?>"  name="nr_etapa"/>&nbsp;<span style="background-color: #6FEDD6; color: #000;"><?=$etapa_name?></span>
                                                        </label>
<?php
                                                    }else{
?>
                                                         <label>
                                                            <input type="checkbox" class="radio" id="nr_etapa<?=$t?>" value="<?=$nr_etapa?>"  name="nr_etapa" disabled/> <?=$etapa_name?>
                                                        </label>
<?php
                                                    }
                                                }
                                            }                                            
?>      
                                    </div>
                                    <div class="bloco">
                                    <p><label for="">Descrição da Etapa:</label>
                                        <textarea name="descricao" rows="3" required style="width: 100%"> </textarea>   </p>  
                                        <label for="">Conclusão <span id="resultado<?=$t?>"><?=$percentual_conclusao?></span>%:</label>
                                        <!-- <input type="range" id="range<?=$t?>" class="myRange" name="range" style="width:100%" value="<?=$percentual_conclusao?>" disable> -->
                                        <input type="hidden" name="id_projeto" value="<?=$id_projeto?>">
                                        <input type="hidden" name="project_percent" value="<?=$percentual_conclusao?>">
                                        <input type="hidden" name="nr_phase" value="<?=$phase?>">
                                        <input type="hidden" name="dt_start" value="<?=$created_at?>">
                                    </div>
                                    <div class="bloco">
                                       <a href="#!" onclick="return valida_form(<?=$t?>)"><input type="submit" name="aplicar" class="aplicar btn-outline-success" id="aplicar<?=$t?>" value="Enviar"/></a> 
                                    </div>
                                </form>
                            </div>
                       </div>
                </div>
<?php
                $t++;
                $count++;
                }
            }
?>

            </div>
            <div class="py-5 text-right"><a href="#" class="btn btn-dark px-5 py-3 text-uppercase">Ver mais</a></div>
        </div>
    </div>

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/popper.js"></script>
    <script>

    function atualizar(i) {
        // PEGA O ELEMENTO DO MODAL DE EDICAO
        var modal_projetos = document.getElementById("tooltip_" + i);

        //PEGA O BOTAO QUE VAI ABRIR O MODAL
        var btn2 = document.getElementById("grupos" + i);

        // PEGA O ELEMENTO SPAN QUE FECHA O MODAL
        var span = document.getElementById("aplicar" + i);
        var span2 = document.getElementById("close" + i);

        // QUANDO O USER CLICA NO BOTAO ABRE O MODAL
        btn2.onclick = function() {
            modal_projetos.style.display = "block";
        }

        //QUANDO O USER CLICA NO X ou em aplicar FECHA O MODAL
        span.onclick = function() {
            modal_projetos.style.display = "none";
        }
        span2.onclick = function() {
            modal_projetos.style.display = "none";
        }

        // QUANDO O USER CLICA FORA DO MODAL TAMBEM FECHA O MODAL
        window.onclick = function(event) {
            if (event.target == modal_projetos) {
                modal_projetos.style.display = "none";
            }
        }

    }

    // Range e resultado dentro do tooltip
    var qtde = <?=$count?>;
    for (let i = 0; i < qtde; i++) {
        //console.log(i);
        let $range = document.querySelector('#range'+i),
            $value = document.querySelector('#resultado'+i);
            $range.addEventListener('input', function(){
                $value.textContent = this.value;
            });
    }


    // Permitir apenas uma seleção de checkbox
    $("input:checkbox").on('click', function() {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
            // the name of the box is retrieved using the .attr() method
            // as it is assumed and expected to be immutable
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }       
    });

    // desabilita range do tooltip
    for (let i = 0; i < qtde; i++) {
        document.getElementById("range"+i).disabled = true;
    }
</script>

<script>

    function valida_form(i){
        var btn = document.getElementById("aplicar"+i).value;
        
        var input_etapa = document.getElementById('nr_etapa'+i);
        
        
        //alert(input_etapa.value);
       

        if (btn != "") {
            if (input_etapa.checked) {
                Swal.fire("Etapa marcada como concluída.");
                return true;
            }
            else{
                Swal.fire("Seleciona uma etapa");
                return false;
            }
        }

    }
    //Swal.fire("Preencha o campo usuário!");
    // tootltip bootstraop
    $(function () {
        $('[data-toggle="tooltip_bt"]').tooltip()
    })
</script>

</body>

</html>