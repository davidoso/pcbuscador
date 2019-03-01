    <body class="bg d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <img src="images/logo_peco.png" class="img-fluid">
            </div>

            <div class="row justify-content-center my-3">
                <h3 class="text-white">Sistema Único de Acceso (STS/ADFS)</h3>
            </div>

            <div class="row justify-content-center my-3">
                <h4 class="text-white">Inicio de Sesión</h4>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-5">
                    <form role="form" method="POST" action="index.php/Login/validar_usuario">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0" id="basic-addon1" title="Usuario"><i class="fa fa-fw fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control rounded-0" id="usuario" name="usuario" placeholder="Usuario" required autofocus>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0" id="basic-addon1" title="Contraseña"><i class="fa fa-fw fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control rounded-0" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0" id="puesto-icono" title="Puesto"><i class="fa fa-fw fa-id-badge"></i></span>
                            </div>
                            <input type="text" class="form-control rounded-0" id="puesto" name="puesto" placeholder="Puesto" disabled>
                        </div>
                        <button type="submit" class="btn btn-danger btn-block rounded-0"><i class="fa fa-fw fa-sign-in-alt"></i> Ingresar</button>
                    </form>
                </div>
            </div>

            <div class="row justify-content-center mt-5">
                <p class="text-white">Peña Colorada | Tecnologías de Información</p>
            </div>
        </div>