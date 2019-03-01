$(document).ready(function() {
    var ext, extClass, fileType;

    // Set focus on keyword input field on page load (HTML5 autofocus attribute is used instead)
    // $('#keyword').focus();

    // Allow/block keys depending on the input class
    function validateLetters(charCode) {
        return !(charCode > 31 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && charCode != 32 && (charCode <= 192 || charCode >= 255));
    }

    function validateNumbers(charCode) {
        return !(charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 32 && (charCode <= 192 || charCode >= 255));
    }

    function validateAlphanumeric(charCode) {
        return (validateLetters(charCode) || validateNumbers(charCode) || charCode == 45 || charCode == 46); // 45 is '-' and 46 '.'
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
        var keyword = $('#keyword').val();

        if(keyword == '') {
            showToastNotif('Búsqueda vacía', 'Ingrese una palabra clave para hacer una búsqueda', 'mid-center', 'warning');
            $('#keyword').focus();
        }
        else {
            re = /^[A-Z0-9ÁÉÍÓÚÑ.-\s]{3,}$/;      // Validate at least 3 alphanumeric characters, '.' or '-' in case the user copy-paste some text
            if(!re.test(keyword)) {
                showToastNotif('Palabra clave inválida', 'Ingrese al menos 3 caracteres alfanuméricos', 'mid-center', 'warning');
                $('#keyword').focus();
            }
            else {
                if(keyword.length > 30) {       // In case an advanced user changes the input maxlength attribute
                    showToastNotif('Palabra clave inválida', 'Ingrese no más de 30 caracteres alfanuméricos', 'mid-center', 'warning');
                    $('#keyword').focus();
                }
                else {                          // Keyword is ok
                    createDatatable();
                }
            }
        }
    }

    function createDatatable() {
        var tblStructure =
            '<table class="table table-secondary table-striped table-bordered" id="myDataTable" width="100%" cellspacing="0">' +
            '<thead class="my-dt-thead">' +
                '<tr>' +
                    '<th></th>' +
                    '<th width="16%">Clave</th>' +
                    '<th width="10%">No. de revisión</th>' +
                    '<th width="10%">Bóveda</th>' +
                    '<th width="33%">Documento</th>' +
                    '<th width="15%">Tipo</th>' +
                    '<th width="8%">Formato</th>' +
                    '<th width="8%"><i class="la la-download my-la-icon" title="Descargar"></i></th>' +
                '</tr>' +
            '</thead>' +
            '<tbody>' +
            '</tbody>';
            $('#div-myDataTable').html(tblStructure);

        var keyword = $('#keyword').val();
        var tbl = $("#myDataTable").DataTable({
            dom: '<"row"<"col-sm-3 my-dt-show"l><"col-sm-6 my-dt-info"i><"col-sm-3"p>>t',
            "columnDefs": [
                {
                    "targets": [0],                             // Hide INFO_CARD_ID
                    "visible": false,
                },
                {
                    "targets": [2],                             // Sort REVISION column as number
                    "type": "num"
                }
            ],
            "ajax": {
                "url": "http://localhost/buscador/index.php/Buscador/getMasterweb",
                "data": {"keyword": keyword},
                "type": "post",
                "datatype": "json",
                "dataSrc": ""
            },
            "columns": [                                        // Column names returned from SQL query are case sensitive
                {"data":"INFO_CARD_ID"},
                {"data":"CLAVE"},
                {"data":"REVISION",
                    "render": function ( data, type, row ) {
                        if(data.charAt(0) == "0")
                            data = data.substring(1);           // Begin the extraction at position 1, e.g. REVISION 01 becomes REVISION 1
                        return data;
                    },
                    "searchable": false,
                    "orderable": true                           // Enable sort on REVISION column
                },
                {"data":"BOVEDA"},
                {"data":"DOCUMENTO"},
                {"data":"TIPO_DOC"},
                {"data":"EXT",
                    "render": function ( data, type, row ) {
                        data = data.toLowerCase();              // Transform to lowercase because the SQL query returns some uppercase file extensions
                        ext = data;                             // ext is needed in "data":"ARCHIVO" render function
                        var extSubstring = (data == "pdf") ? "pdf" : data.substring(0, 2);          // Group +1 case conditions if the file is not a PDF
                        var html = "";
                            switch(extSubstring) {
                                case "pdf":
                                    html = '<i class="la la-file-pdf-o la-2x text-danger" title="PDF"></i>';
                                    extClass = 'danger';
                                    fileType = 'PDF';
                                    break;
                                case "xl":      // Includes xl, xlsx, xlsb
                                    html = '<i class="la la-file-excel-o la-2x text-success" title="Excel"></i>';
                                    extClass = 'success';
                                    fileType = 'Excel';
                                    break;
                                case "do":      // Includes doc, docx, docm
                                    html = '<i class="la la-file-word-o la-2x text-info" title="Word"></i>';
                                    extClass = 'info';
                                    fileType = 'Word';
                                    break;
                                case "pp":      // Includes ppt, pptx, pps, ppsx
                                    html = '<i class="la la-file-powerpoint-o la-2x text-warning" title="PowerPoint"></i>';
                                    extClass = 'warning';
                                    fileType = 'PowerPoint';
                                    break;
                                default:
                                    html = '<i class="la la-file-o la-2x text-secondary" title="Otro"></i>';
                                    extClass = 'secondary';
                                    fileType = 'archivo';
                            }
                        return html;
                    },
                    "searchable": false,
                    "orderable": false
                },
                {"data":"ARCHIVO",
                    "render": function ( data, type, row ) {
                        // console.log("Pathfile:\n" + data);           // Print all pathfiles
                        if(ext == "pdf") {
                            // In some cases, a dot has to be added manually because the SQL query doesn't concatenate the PDF pathfile, the dot (.) and its "pdf" extension
                            // Example files (look up these keywords): perforadora, a granel, espreas, proteccion civil, quejas del cliente, espacios confinados
                            if(!data.includes(".", data.length - ext.length - 1)) {
                                data = data.substring(0, data.length - ext.length) + "." + ext;
                            }
                            var html = '<a href="' + data + '" target="_blank" class="btn btn-' + extClass + ' btn-sm"><i class="la la-eye my-la-icon" title="Abrir PDF en otra pestaña"></i></a>';
                        }
                        else {
                            var html = '<a href="' + data + '" class="btn btn-' + extClass + ' btn-sm"><i class="la la-download my-la-icon" title="Descargar ' + fileType + '"></i></a>';
                        }
                        return html;
                    },
                    "searchable": false,
                    "orderable": false
                }
            ],
            "order": [ [3, "asc"], [4, "asc"] ],                        // Sort by BOVEDA and DOCUMENTO
            "pagingType": "simple_numbers",
            "language": {
                // http://www.snacklocal.com/images/ajaxload.gif
                "sLoadingRecords": '<span style="width: 100%;"><img src="images/loading.gif"></span>'
             },
        }); // $("#myDataTable").DataTable()
    }
}); // $(document).ready()