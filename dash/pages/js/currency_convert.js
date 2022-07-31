$(function(){
    $("#real").on("change", function(){
        $.ajax({
            url: "../pages/utils/currency_api.php",
            success: function(euro){
                var real = document.querySelector("[id='real']").value;
        real = document.querySelector("[id='real']").value = euro ;
            },
            error: function(){
                $("#euro").html("Error");
            }
        });
        // var real = document.querySelector("[id='real']").value;
        // real = document.querySelector("[id='real']").value = 3;
        // alert(real);
    });
});

