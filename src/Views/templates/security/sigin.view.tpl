<section class="fullCenter">
    <form class="grid" method="post" action="index.php?page=sec_register">

        <section class="depth-1 row col-12 col-m-8 offset-m-2 col-xl-8 offset-xl-2">
            <h1 class="col-12">Crear Cuenta</h1>
        </section>

        <section class="depth-1 py-5 row col-12 col-m-8 offset-m-2 col-xl-8 offset-xl-2">

            <div class="row">
                <label class="col-12 col-m-4" for="txtNombre">Nombre</label>
                <div class="col-12 col-m-8">
                    <input class="width-full" type="text" name="txtNombre" id="txtNombre" value="{{txtNombre}}">
                </div>
            </div>

            <div class="row">
                <label class="col-12 col-m-4" for="txtApellido">Apellido</label>
                <div class="col-12 col-m-8">
                    <input class="width-full" type="text" name="txtApellido" id="txtApellido" value="{{txtApellido}}">
                </div>
            </div>

            <div class="row">
                <label class="col-12 col-m-4" for="txtEmail">Correo Electrónico</label>
                <div class="col-12 col-m-8">
                    <input class="width-full" type="email" name="txtEmail" id="txtEmail" value="{{txtEmail}}">
                </div>
                {{if errorEmail}}
                <div class="error col-12 col-m-8 offset-m-4">{{errorEmail}}</div>
                {{endif errorEmail}}
            </div>

            <div class="row">
                <label class="col-12 col-m-4" for="txtTelefono">Teléfono</label>
                <div class="col-12 col-m-8">
                    <input class="width-full" type="text" name="txtTelefono" id="txtTelefono" value="{{txtTelefono}}">
                </div>
            </div>

            <div class="row">
                <label class="col-12 col-m-4" for="txtDireccion">Dirección</label>
                <div class="col-12 col-m-8">
                    <input class="width-full" type="text" name="txtDireccion" id="txtDireccion" value="{{txtDireccion}}">
                </div>
            </div>

            <div class="row">
                <label class="col-12 col-m-4" for="txtPswd">Contraseña</label>
                <div class="col-12 col-m-8">
                    <input class="width-full" type="password" name="txtPswd" id="txtPswd">
                </div>
                {{if errorPswd}}
                <div class="error col-12 col-m-8 offset-m-4">{{errorPswd}}</div>
                {{endif errorPswd}}
            </div>

            <div class="row">
                <label class="col-12 col-m-4" for="txtPswd2">Confirmar Contraseña</label>
                <div class="col-12 col-m-8">
                    <input class="width-full" type="password" name="txtPswd2" id="txtPswd2">
                </div>
                {{if errorPswd2}}
                <div class="error col-12 col-m-8 offset-m-4">{{errorPswd2}}</div>
                {{endif errorPswd2}}
            </div>

            <div class="row right flex-end px-4">
                <button class="primary" type="submit">
                    Crear Cuenta
                </button>
            </div>

        </section>

    </form>
</section>