// Converts to uppercase, removes multiple whitespaces and trims inputs on focus out
// Textbox was usuario before solving bug in web service that ignored password
$(document).on("focusout", "#usuario", function() {
    this.value = this.value.replace(/\s{2,}/g, " ").trim();
    var usuario = this.value;

    if(usuario.length > 0) {
        $('#puesto-icono').html('<i class="fa fa-fw fa-spinner fa-pulse"></i>');
        $.ajax({
            type: "POST",
            url: "index.php/Login/get_puesto",
            data: { usuario:usuario },
            dataType: "json",
            success: function(puesto) {
                $('#puesto').val(puesto);
                $('#puesto-icono').html('<i class="fa fa-fw fa-id-badge"></i>');
            },
            error: function() {
                console.log("Error al obtener puesto");
                $('#puesto').val('');
                $('#puesto-icono').html('<i class="fa fa-fw fa-id-badge"></i>');
            }
        }); // AJAX
    }
    else {
        $('#puesto').val('');
    }
});