<!DOCTYPE html>
<html lang="es-MX">
<head>
  <?php $this->load->view('head'); ?>
</head>
<body class="bg align-items-center">
    <?php $this->load->view('navbar'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <p class="app-img"><img src="images/logo_peco.png"></p>
            <div class="vl"></div>
            <p class="app-title">BUSCADOR</p>
        </div>
        <div class="main-featured-sec">
            <div class="main-featured-text">
                <!-- <p>Ingrese una palabra clave contenida en el nombre de un documento en MASTERWEB<br>o contenido multimedia en SharePoint</p> -->
            </div>
            <div class="directory-searcher">
                <form>
                    <div class="field">
                        <input type="text" class="vAlphanumeric" id="keyword" maxlength="30" placeholder="Palabra clave en título de documento.." autofocus>
                    </div>
                    <div class="field" style="width: 20%;">
                        <select data-placeholder="Origen de información" class="chosen-select" tabindex="-1" style="display: none;">
                            <option value="MASTERWEB">MASTERWEB</option>
                            <!-- <option value="SharePoint">SharePoint</option> -->
                        </select>
                    </div>
                    <div class="field">
                        <button type="button" id="btnQuery"><i class="la la-search"></i>BUSCAR</button>
                    </div>
                </form>
            </div>
            <div class="cat-lists" id="div-myDataTable">
            </div>
            <!-- <a class="arrow-down floating" title=""><i class="la la-spinner fa-pulse"></i></a> -->
        </div>
    </div>

<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
<!-- Prolist - Directory & Listing WordPress Theme JavaScript -->
<script type="text/javascript" src="js/choosen.min.js"></script>
<!-- Custom JavaScript for this project -->
<script type="text/javascript" src="js/my-general-functions.js"></script>
<!-- DataTable JavaScript -->
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
<!-- Stellar Admin notifications JavaScript -->
<script type="text/javascript" src="js/jquery.toast.min.js"></script>
<script type="text/javascript" src="js/my-toastnotification.js"></script>
</body>
</html>