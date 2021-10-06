$( document ).ready(()=>{
    const TEXT_NO_NUMBER = "No tienes números por el momento.";
    const TEXT_SI_NUMBER = "Síguenos para validar tus números.";
    const NO_NUMBER = "-";
    const URL_EP = "api/web/participants/numbers?nombreUser=";

    function showNumbers(numbers){
        $(".numero-cont").text(NO_NUMBER);
        if (numbers.length == 0){
            $("#text-result").html(TEXT_NO_NUMBER);
        } else {
            $("#text-result").html(TEXT_SI_NUMBER);
            for(let c=0; c < numbers.length; c++){
                let day = new Date(numbers[c].fecha_hora).getDay();
                $("#num-"+day).text("#"+numbers[c].numero);
            }
        }
        $(".number-cont").css('padding-top',"0px");
    }

    function getUsuario(){
        let out = $("#username").val();
        if (out == '' || !out.match("(?:^|[^\w])(?:@)([A-Za-z0-9_](?:(?:[A-Za-z0-9_]|(?:\.(?!\.))){0,28}(?:[A-Za-z0-9_]))?)") || out.search(" ") != -1){
            $("#username").val("Ingrese un nombre válido");
            $("#username").css('color','#f00');
            out = "";
        }
        out = out.replace("@","");
        return out;
    }

    $("#username").click(()=>{
        $("#username").val("");
        $("#username").css('color','#000');
        $(".number-cont").css('padding-top',"336px");
    });

    $('#comprobarBtn').click(()=>{
        let user = getUsuario();
        $(".number-cont").css('padding-top',"336px");
        if(user != ""){
            btnAnimate("#comprobarBtn");
        }
        setTimeout(()=>{
            if (user == ''){
                return false;
            }
            $.ajax( { url : URL_EP+user, type: "GET" })
                .done(function(data) {
                    showNumbers(data);
                })
                .fail(function(data) {
                    alert( "Ocurrió un error, reintente nuevamente más tarde." );
                });
        },500);
        
    });

    function btnAnimate(element){
        $(element).css("color","#f75555");
        $(element).css("font-size", "1.25rem");
        setTimeout(()=>{
            $(element).css("font-size", "1.75rem");
        },123);
    }

});
