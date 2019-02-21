<!DOCTYPE html>
<html lang="es-MX">
<head>
  <?php $this->load->view('head'); ?>
</head>
<body class="bglogin align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <p class="app-img"><img src="http://vwebdelta/bitacoramovil/assets/img/logo_peco.png"></p>
            <div class="vl"></div>
            <p class="app-title">BUSCADOR</p>
        </div>
        <div class="main-featured-sec">
            <div class="main-featured-text">
                <p>Ingrese una palabra clave contenida en el nombre de un documento en MASTERWEB<br>o contenido multimedia en SharePoint</p>
            </div>
            <div class="directory-searcher">
                <form>
                    <div class="field">
                        <input type="text" placeholder="Palabra clave..">
                    </div>
                    <div class="field" style="width: 20%;">
                        <select data-placeholder="Origen de información" class="chosen-select" tabindex="-1" style="display: none;">
                            <option value="MASTERWEB">MASTERWEB</option>
                            <option value="SharePoint">SharePoint</option>
                        </select>
                    </div>
                    <div class="field">
                        <button type="submit"><i class="la la-search"></i>BUSCAR</button>
                    </div>
                </form>
            </div>
            <a class="arrow-down floating" title=""><i class="la la-spinner fa-pulse"></i></a>
        </div>
    </div>

<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
<!-- Prolist - Directory & Listing WordPress Theme JavaScript -->
<script type="text/javascript" src="js/choosen.min.js"></script>
</body>
</html>