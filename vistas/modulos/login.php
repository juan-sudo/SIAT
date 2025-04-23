<div class="container" style="margin-top: 30px; max-width: 400px; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
    <div class="text-center">
        <h1 style="font-size: 28px; font-weight: bold; color: #333;">
            Iniciar sesión
        </h1>
    </div>
    <form method="post" class="login-u" id="form-login">
        <div class="form-group">
            <label for="ingUsuario">Usuario</label>
            <input type="text" class="form-control" style=" text-transform: none;height: 30px; border: 1px solid #ccc; font-size: 16px;" placeholder="Usuario" name="ingUsuario" id="ingUsuario" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="ingPassword">Contraseña</label>
            <input type="password" class="form-control" style="text-transform: none;height: 30px; border: 1px solid #ccc; font-size: 16px;" placeholder="Contraseña" name="ingPassword" id="ingPassword">
        </div>

        <div class="form-group text-center" style="margin-top: 20px;">
            <button type="button" id="logUser" class="btn btn-primary btn-block">
                Ingresar al sistema <i class="glyphicon glyphicon-log-in"></i>
            </button>
        </div>

        <div id="resultLogin" style="display: none;"></div>
    </form>
</div>
