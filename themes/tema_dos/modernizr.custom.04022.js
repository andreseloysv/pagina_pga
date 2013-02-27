var contador=1;
var intervalID =0;

function cargaDialogoLogin(){
    var mi_elemento=$("#mi_menu  ul  li");
    var formulario_login=$("#block-user-0,#user-login,#tabs-wrapper");
    
    formulario_login.hide();
    console.debug("Ocultado");
    $(mi_elemento).html('<div id="dialog-form" title="Create new user"><a href="/drupal/?q=user/login" title="" class="active">Mi Compensa</a></div>');
    $(function() { 
	$( mi_elemento ).dialog({
	    autoOpen: false,
	    height: 300,
	    width: 350,
	    modal: true,
	    buttons: {
			
		Aceptar: function() {
		    $( this ).dialog( "close" );
		},
		Cerrar: function() {
		    $( this ).dialog( "close" );
		}
	    },
	    close: function() {
		allFields.val( "" ).removeClass( "ui-state-error" );
	    }
	});
 
	$( "#login" )
	.button()
	.click(function() {
	    $( "#dialog-form" ).dialog( "open" );
	});
    });
}
function setContador(valor){
    var clase_radio=( $(valor).attr('class') );
    valor = clase_radio.split("-")[2];
    contador=valor;
}

function stopSlide() {
    clearInterval(intervalID);
}

function doClick(id){
    $('#'+id).trigger('click'); 
}

function rotarSlide(){
    intervalID = setInterval(function(){
	if (contador>$("#max_images").val()){
	    contador=1;
	}
	doClick('button-'+contador)
	contador++;
    },5000);
}
function cambiarCssMenu(){
    var validacion='';
    validacion=$(".content").find("ul");
    if( validacion.length > 0 ) {
	console.debug($(".content")[0]);
	$($(".content")[0]).attr('id',"mi_menu");
    }
}
	
$(document).ready(function() {
    //cargaDialogoLogin();
    cambiarCssMenu();
    rotarSlide();
    $(":radio").mouseenter(
	function () {
	    stopSlide();
	});

    $(":radio").mouseleave(
	function () {
	    rotarSlide();
	});
        
});