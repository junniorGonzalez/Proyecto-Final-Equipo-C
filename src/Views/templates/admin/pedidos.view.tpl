<section style="max-width:1200px;margin:40px auto;padding:20px;">

    <div style="text-align:center;margin-bottom:35px;">

        <img src="public/imgs/logo.png"
             alt="La Neverita"
             style="width:120px;margin-bottom:15px;">

        <h1 style="color:#24408E;font-size:2.4rem;margin-bottom:10px;">
            Administración de Pedidos
        </h1>

        <p style="color:#666;">
            Desde aquí puedes ver los pedidos de todos los clientes y actualizar el estado de envío.
        </p>

    </div>

    {{if orders}}

    <table style="width:100%;
                  border-collapse:collapse;
                  background:#fff;
                  border-radius:15px;
                  overflow:hidden;
                  box-shadow:0 5px 20px rgba(0,0,0,.08);">

        <thead>

            <tr style="background:#24408E;color:white;">

                <th style="padding:15px;">Pedido</th>
                <th>Cliente</th>
                <th>Dirección de entrega</th>
                <th>Teléfono</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Pago</th>
                <th>Estado de envío</th>
                <th>Cambiar estado</th>

            </tr>

        </thead>

        <tbody>

        {{foreach orders}}

        <tr style="border-bottom:1px solid #eee;">

            <td style="padding:15px;text-align:center;">
                #{{id_pedido}}
            </td>

            <td style="text-align:center;">
                {{cliente}}<br>
                <small style="color:#888;">{{cliente_correo}}</small>
            </td>

            <td style="text-align:center;max-width:220px;">
                {{direccion_entrega}}
            </td>

            <td style="text-align:center;">
                {{cliente_telefono}}
            </td>

            <td style="text-align:center;">
                L. {{total}}
            </td>

            <td style="text-align:center;">
                {{fecha}}
            </td>

            <td style="text-align:center;">
                {{estado_pago}}
            </td>

            <td style="text-align:center;">

                <span style="
                    background:#e8f1ff;
                    color:#24408E;
                    padding:8px 18px;
                    border-radius:20px;
                    font-weight:bold;
                    display:inline-block;">

                    {{estado}}

                </span>

            </td>

            <td style="padding:15px;">

                <form action="index.php?page=admin_Pedidos"
                      method="post"
                      style="display:flex;
                             justify-content:center;
                             align-items:center;
                             gap:10px;">

                    <input type="hidden"
                           name="id"
                           value="{{id_pedido}}">

                    <select name="status"
                            style="
                                padding:10px;
                                border:2px solid #24408E;
                                border-radius:8px;
                                font-weight:bold;
                                color:#24408E;
                                background:white;">

                       <option value="Pendiente" {{selected_pendiente}}>Pendiente</option>
                        <option value="Preparando" {{selected_preparando}}>Preparando</option>
                        <option value="En camino" {{selected_en_camino}}>En camino</option>
                        <option value="Entregado" {{selected_entregado}}>Entregado</option>
                        <option value="Cancelado" {{selected_cancelado}}>Cancelado</option>

                    </select>

                    <button type="submit"
                            style="
                                background:#24408E;
                                color:white;
                                border:none;
                                padding:10px 18px;
                                border-radius:8px;
                                font-weight:bold;
                                cursor:pointer;">

                        Guardar

                    </button>

                </form>

            </td>

        </tr>

        {{endfor orders}}

        </tbody>

    </table>

    {{endif orders}}

    {{ifnot orders}}

    <div style="
        text-align:center;
        background:#fff9e6;
        border:2px solid #F8B8CF;
        border-radius:15px;
        padding:60px;">

        <img src="public/imgs/logo.png"
             style="width:110px;margin-bottom:20px;">

        <h2 style="color:#24408E;">
            No existen pedidos registrados.
        </h2>

        <p style="color:#555;">
            Cuando un cliente realice una compra aparecerá aquí.
        </p>

    </div>

    {{endifnot orders}}

</section>
