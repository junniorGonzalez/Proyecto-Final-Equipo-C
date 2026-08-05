<section style="max-width:1200px;margin:40px auto;padding:20px;">

    <div style="text-align:center;margin-bottom:35px;">

        <img src="public/imgs/logo.png"
             alt="La Neverita"
             style="width:110px;margin-bottom:10px;">

        <h1 style="color:#304A97;font-size:2.4rem;font-weight:bold;">
            Gestión de Categorías
        </h1>

        <p style="color:#666;">
            Administra las categorías disponibles para los productos de La Neverita.
        </p>

    </div>

    <div style="text-align:right;margin-bottom:20px;">

        <a href="index.php?page=Admin_CategoriaForm&mode=INS"
           style="
                background:#304A97;
                color:white;
                padding:12px 22px;
                border-radius:8px;
                text-decoration:none;
                font-weight:bold;">

            + Agregar Categoría

        </a>

    </div>

    <div style="
        background:white;
        border-radius:15px;
        overflow:hidden;
        box-shadow:0 5px 20px rgba(0,0,0,.08);">

        <table style="width:100%;border-collapse:collapse;">

            <thead>

                <tr style="background:#304A97;color:white;">

                    <th style="padding:15px;">Código</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Acciones</th>

                </tr>

            </thead>

            <tbody>

            {{foreach categorias}}

            <tr style="border-bottom:1px solid #eee;">

                <td style="padding:15px;text-align:center;">
                    {{catcod}}
                </td>

                <td style="text-align:center;">
                    {{catdsc}}
                </td>

                <td style="text-align:center;">

                    {{if catActivo}}

                    <span style="
                        background:#dff7e8;
                        color:#1e8449;
                        padding:8px 18px;
                        border-radius:20px;
                        font-weight:bold;">

                        Activo

                    </span>

                    {{endif catActivo}}

                    {{ifnot catActivo}}

                    <span style="
                        background:#fdeaea;
                        color:#c0392b;
                        padding:8px 18px;
                        border-radius:20px;
                        font-weight:bold;">

                        Inactivo

                    </span>

                    {{endifnot catActivo}}

                </td>

                <td style="padding:15px;text-align:center;">

                    <div style="
                        display:flex;
                        flex-direction:column;
                        align-items:center;
                        gap:10px;">

                        <a href="index.php?page=Admin_CategoriaForm&mode=UPD&catcod={{catcod}}"
                           style="
                                width:120px;
                                background:#304A97;
                                color:white;
                                padding:10px;
                                border-radius:8px;
                                text-decoration:none;
                                font-weight:bold;">

                            Editar

                        </a>

                        <form action="index.php?page=Admin_Categorias"
                              method="post"
                              style="margin:0;">

                            <input type="hidden"
                                   name="action"
                                   value="DELETE">

                            <input type="hidden"
                                   name="catcod"
                                   value="{{catcod}}">

                            <button type="submit"
                                    style="
                                        width:120px;
                                        background:#F8B8CF;
                                        color:#304A97;
                                        padding:10px;
                                        border:none;
                                        border-radius:8px;
                                        cursor:pointer;
                                        font-weight:bold;">

                                Eliminar

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

            {{endfor categorias}}

            </tbody>

        </table>

    </div>

</section>