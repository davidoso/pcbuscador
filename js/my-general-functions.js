$(document).ready(function() {
    //var tbl;

    // Set focus on keyword input field on page load
    $('#keyword').focus();

    // Allow/block keys depending on the input class
    function validateLetters(charCode) {
        return !(charCode > 31 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && charCode != 32 && (charCode <= 192 || charCode >= 255));
    }

    function validateNumbers(charCode) {
        return !(charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 32 && (charCode <= 192 || charCode >= 255));
    }

    function validateAlphanumeric(charCode) {
        return (validateLetters(charCode) || validateNumbers(charCode));
    }

    // Allow only alphanumeric characters on keyword input
    $(document).on("keypress", ".vAlphanumeric", function(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        return validateAlphanumeric(charCode);
    });

    $(document).on("focusout", "#keyword", function() {
        trimKeyword();
    });

    $(document).on("keyup", "#keyword", function(e) {
        if(e.which == 13) { // Enter keycode
            trimKeyword();
            validateKeyword();
        }
    });

    $("#btnQuery").on("click", function() {
        trimKeyword();
        validateKeyword();
    });

    // Convert to uppercase, remove multiple whitespaces and trim input on focus out
    function trimKeyword() {
        var input = $('#keyword').val().toUpperCase().replace(/\s{2,}/g, " ").trim();
        $('#keyword').val(input);
    }

    // Show a notification is the keyword input is empty
    function validateKeyword() {
        trimKeyword();
        if($('#keyword').val() == '') {
            showToastNotif('Búsqueda vacía', 'Ingrese una palabra clave para hacer una búsqueda', 'mid-center', 'warning');
        }
        else {
            createDatatable();
        }
    }

    function createDatatable() {
        var tblStructure =
            '<table class="table table-striped table-bordered" id="myDataTable" width="100%" cellspacing="0">' +
            '<thead class="tbl-blue-th">' +
                '<tr>' +
                    '<th></th>' +
                    '<th width="10%">Clave</th>' +
                    '<th width="10%">No. de revisión</th>' +
                    '<th width="10%">Bóveda</th>' +
                    '<th width="40%">Documento</th>' +
                    '<th width="15%">Tipo</th>' +
                    '<th width="5%">Formato</th>' +
                    '<th width="5%"><i class="la la-eye" title="Ver en otra pestaña"></i></th>' +
                    '<th width="5%"><i class="la la-download" title="Descargar"></i></th>' +
                '</tr>' +
            '</thead>' +
            '<tbody>' +
            '</tbody>';
            $('#div-myDataTable').html(tblStructure);
            //$('#myDataTable').dataTable();

        var keyword = $('#keyword').val();
        var tbl = $("#myDataTable").DataTable({
            //dom: 'l<"toolbar">frtip',
            dom: '<"top"i>rt<"bottom"flp><"clear">',
            "columnDefs": [{
                "targets": [0], // Hide INFO_CARD_ID column
                "visible": false
            }],
            "ajax": {
                "url": "http://localhost/buscador/index.php/App_c/getMasterweb",
                "data": {"userid": "gquiteno", "keyword": keyword},
                "type": "post",
                "datatype": "json",
                "dataSrc": ""
            },
            // Column names returned from SQL query are case sensitive
            "columns": [
                {"data":"INFO_CARD_ID"},
                {"data":"CLAVE"},
                {"data":"REVISION"},
                {"data":"BOVEDA"},
                {"data":"DOCUMENTO"},
                {"data":"TIPO_DOC"},
                {"data":"EXT",
                    "render": function ( data, type, row ) {
                        var text = "";
                            switch(data) {
                                case "pdf":
                                    // text = '<span class="badge badge-danger"><i class="la la-file-pdf-o la-2x" title="PDF"></i></span>';
                                    text = '<i class="la la-file-pdf-o la-2x text-danger" title="PDF"></i>';
                                    break;
                                case "doc":
                                case "docx":
                                    text = '<i class="la la-file-word-o la-2x text-info" title="Word"></i>';
                                    break;
                                case "xls":
                                case "xlsx":
                                    text = '<i class="la la-file-excel-o la-2x text-success" title="Excel"></i>';
                                    break;
                                case "ppt":
                                case "pptx":
                                    text = '<i class="la la-file-powerpoint-o la-2x text-warning" title="PowerPoint"></i>';
                                    break;
                                default:
                                    text = '<i class="la la-file-o la-2x text-secondary" title="Otro"></i>';
                            }
                        data = text
                        return data;
                    },
                    "searchable": false,
                    "orderable": false
                },
                {"data":"ARCHIVO",
                    "render": function ( data, type, row ) {
                        var text = '<a href="' + data + '" target="_blank" class="btn btn-outline-warning btn-sm"><i class="la la-download la-2x" title="Descargar"></i></a>';
                        data = text;
                        return data;
                    },
                    "searchable": false,
                    "orderable": false
                },
                {"data":"CODIGO_TIPO",
                    "render": function ( data, type, row ) {
                        var text = '<a href="' + data + '" target="_blank" class="btn btn-outline-info btn-sm"><i class="la la-eye la-2x" title="Ver en otra pestaña"></i></a>';
                        data = text;
                        return data;
                    },
                    "searchable": false,
                    "orderable": false
                },
                /*{
                    "target": -2,
                    "data": null,
                    // "defaultContent": "<button id='btn_download' class='btn btn-outline-info btn-sm' title='Descargar'><i class='la la-download'></i></button>",
                    "defaultContent": "<a href='http://vwebdelta:8088/webdocs/X141/201308301048449031.pdf' target='_blank'><i class='la la-download la-2x' title='Descargar'></i></a>",
                    "searchable": false,
                    "orderable": false
                }
                {
                    "target": -1,
                    "data": null,
                    "defaultContent": "<button id='btn_view' class='btn btn-outline-warning btn-sm' title='Ver en otra pestaña'><i class='la la-eye'></i></button>",
                    "searchable": false,
                    "orderable": false
                },*/
            ],
            "language": {
                // http://www.snacklocal.com/images/ajaxload.gif
                "sLoadingRecords": '<span style="width: 100%;"><img src="images/loading.gif"></span>'
             },
        }); // $("#myDataTable").DataTable()

        /* DELETE THIS
        $("#myDataTable tbody").on('click','[id=btn_download]',function(){
            var data = tbl.row($(this).parents('tr')).data(); // Data object

                if(document.getElementById('formDownloadSingle'))
                    $('#formDownloadSingle').remove();

                var inputs =
                    '<input type="text" name="documento" value="' + data.DOCUMENTO + '">' +
                    //'<input type="text" name="participante" value="' + data.participante + '">' +
                    '<input type="text" name="archivo" value="' + data.ARCHIVO + '">';

                // Build form (hide keeps it from being visible)
                $form = $('<form/>').attr({id: 'formDownloadSingle', method: 'POST', action: 'assets/fpdi-fpdf/generate_single_gafete.php'}).hide();

                // Add inputs to form
                $form.append(inputs);

                // Add form to the document body
                $('body').append($form);

                // Submit the form and FPDI-FPDI output should open a dialog to download the file
                $form.submit();
        });*/
    }
}); // $(document).ready()