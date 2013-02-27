var contador=1;
var intervalID =0;

function cargaDialogoLogin(){
    var mi_elemento=$("#mi_menu  ul  li");
    var formulario_login=$("#block-user-0,#user-login,#tabs-wrapper");
    formulario_login.hide();
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
    var mi_link=$($(".dropdown").find("a")[0]);
    var img = $('<img id="dynamic">'); //Equivalent: $(document.createElement('img'))
    img.attr('src', 'http://www.compensa.com.ve/drupal/sites/default/files/mi_tema_logo.png');
    mi_link.text('');
    img.appendTo(mi_link);
    mi_link.attr('id',"logo");
}

function siteMap(){
    var flag = 0;
    var menu=$("#foo ul li");
    var menu_hijos=$("#foo ul li ul li");
    var items_menu=new Array();
    var size_menu =menu.length;
    var clave=0;
    for (var i=0;i<size_menu;i++)
    { 
        for (var j=0;j<menu_hijos.length;j++)
        { 
            if ($(menu[i]).text()==$(menu_hijos[j]).text()){
                if(flag==0)
                {
		    
                    items_menu[i]=new Array();
                    flag=1;
                }    
                items_menu[clave][j]=menu_hijos[j]; 
            }
        }
        if(flag==0){
            clave=i;
            items_menu[i]=menu[i];
            $("#foo").append("<div class='horizontal_sitemap'><ul class='titulo'><li>"+$(menu[i]).html()+"</li></ul></div>");
        }
        flag=0;
    }
}
function Dialogo_login(){
    $("#dialogo_login").dialog({
        position:  {
            my: "left center", 
            at: "left bottom", 
            of: "button"
        },
        resizable: false,
        autoOpen: false,
        show: "blind",
        hide: "explode",
        modal: true
    });
 
    $( "#boton_inicio_sesion" ).click(function() {
        $( "#dialogo_login" ).dialog( "open" );
        return false;
    });
    $( "#edit-submit-4" ).click( function() {
        $(this).dialog( "close" );
        return false;	
    });
}
function Dialogo_registro(){
    $("#dialogo_registro").dialog({
        position:  {
            my: "left center", 
            at: "left bottom", 
            of: "button"
        },
        resizable: false,
        autoOpen: false,
        show: "blind",
        hide: "explode",
        modal: true
    });
 
    $( "#boton_registro" ).click(function() {
        $( "#dialogo_registro" ).dialog( "open" );
        return false;
    });
    $( "#edit-submit-4" ).click( function() {
        $(this).dialog( "close" );
        return false;	
    });
}
$(document).ready(function() {  

    var margen=($(window).width()-1050)/2;
    var dimension=(($(window).width())/1)-100;
    $("#barra_inferior").css("margin-left",margen+"px");
    $("#barra_central").css("margin-left",margen+"px");
    $("#barra_menu_superior_centrada").css("margin-left",margen+"px");
    
   
    $('.slides_container').find('a').each(function(){
        $(this).css('width',dimension+ 'px ');
    });
    
    $(".imagenes_slider").each(function(){
        $(this).css("margin-left",margen+"px");
    });
    
    
    $(".imagen_fondo_banner").each(function(){
        $(this).css("width",(dimension+100)+"px");
    });
    
    
    $("#example").css("width",+"px");
    //$("#imagenes_slider").css("margin-left",margen+"px");
    $("#slides").css("width","100%");
    $(".slides_container").css("width","100%");
    $("#container").css("width","100%");
    
    
   

    var mouseover = false;
    ($(".dropdown").find("li")).mouseenter(function(){
        $(".megaborder").css("display","block");
    }).mouseleave(function(){
        $(".megaborder").css("display","none");
    });
    
    
    
    
    cargaDialogoLogin();
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
    siteMap();
    Dialogo_registro();
    Dialogo_login();
    
    $('#slides').slides({
//	autoHeight: true,
        preload: true,
        slideSpeed: 600,
	fadeSpeed: 600,
        play: 5000,
        pause: 5000,
        hoverPause: true
    });
});