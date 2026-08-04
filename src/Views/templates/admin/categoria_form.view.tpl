<section style="max-width:700px;margin:40px auto;">

    <div style="text-align:center;margin-bottom:30px;">

        <img src="public/imgs/logo.png"
             style="width:110px;">

        <h1 style="
            color:#304A97;
            margin-top:15px;
            margin-bottom:10px;">

            {{mode_desc}}

        </h1>

        <p style="color:#666;">
            Complete la información de la categoría.
        </p>

    </div>


    <div style="
        background:#fff;
        padding:35px;
        border-radius:15px;
        box-shadow:0 5px 20px rgba(0,0,0,.10);">

        <form action="index.php?page=Admin_CategoriaForm"
              method="post">

            <input
                type="hidden"
                name="mode"
                value="{{mode}}">

            <input
                type="hidden"
                name="catcod"
                value="{{catcod}}">


            <div style="margin-bottom:20px;">

                <label style="font-weight:bold;color:#304A97;">
                    Nombre de la Categoría
                </label>

                <input
                    type="text"
                    name="catdsc"
                    value="{{catdsc}}"
                    {{readonly}}
                    required
                    style="
                        width:100%;
                        margin-top:8px;
                        padding:12px;
                        border:1px solid #ccc;
                        border-radius:8px;
                        box-sizing:border-box;">

            </div>


            <div style="margin-bottom:30px;">

                <label style="font-weight:bold;color:#304A97;">
                    Estado
                </label>

                <select
                    name="catest"
                    {{readonly}}
                    style="
                        width:100%;
                        margin-top:8px;
                        padding:12px;
                        border:1px solid #ccc;
                        border-radius:8px;">

                    <option value="Activo" {{selACT}}>
                        Activo
                    </option>

                    <option value="Inactivo" {{selINA}}>
                        Inactivo
                    </option>

                </select>

            </div>


            <div style="
                display:flex;
                justify-content:center;
                gap:15px;">

                <button
                    type="submit"
                    style="
                        background:#304A97;
                        color:white;
                        border:none;
                        padding:12px 30px;
                        border-radius:8px;
                        cursor:pointer;
                        font-weight:bold;">

                    Guardar

                </button>


                <a href="index.php?page=Admin_Categorias"
                   style="
                        background:#F8B8CF;
                        color:#304A97;
                        padding:12px 30px;
                        border-radius:8px;
                        text-decoration:none;
                        font-weight:bold;">

                    Cancelar

                </a>

                <a href="index.php"
                   style="
                        background:#27ae60;
                        color:white;
                        padding:12px 30px;
                        border-radius:8px;
                        text-decoration:none;
                        font-weight:bold;">

                    Inicio

                </a>

            </div>

        </form>

    </div>

</section>