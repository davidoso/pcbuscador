<nav class="navbar navbar-expand-md fixed-top">
    <div class="col-sm-12" id="my-nav">
        <h5 class="text-white" title="Usuario con sesión iniciada"><i class="la la-user my-nav-la-22"></i>&nbsp;<?php echo $this->session->userdata('username'); ?></h5>
        <a href="index.php/Login/cerrar_sesion">
            <h6 class="text-warning"><i class="la la-sign-out"></i>&nbsp;&nbsp;Cerrar sesión</h6>
        </a>
    </div>
</nav>