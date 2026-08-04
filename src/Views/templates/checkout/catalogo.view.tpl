<section class="grid" style="background:#F8FCFF;padding:40px 20px;">

    <div class="col-12" style="text-align:center;margin-bottom:50px;">

        <img src="public/imgs/logo.png"
             alt="La Neverita"
             style="width:180px;max-width:100%;margin-bottom:20px;">

        <h1 style="font-size:2.8rem;color:#24408E;margin-bottom:15px;">
            {{titulo}}
        </h1>

        <p style="font-size:1.1rem;line-height:1.8;color:#555;max-width:750px;margin:0 auto;">

            Descubre nuestro Catálogo de productos
            <strong style="color:#24408E;">La Neverita</strong>.

            <br><br>

            Prueba nuestros deliciosos helados, gelatinas,
            granizados y también nuestras frutas locas,
            preparados con ingredientes de calidad y mucho cariño.

        </p>

        <div style="margin-top:30px;display:flex;justify-content:center;gap:15px;flex-wrap:wrap;">

            <a href="index.php?page=Checkout_Carrito"
               style="background:#24408E;
                      color:white;
                      padding:14px 28px;
                      border-radius:8px;
                      text-decoration:none;
                      font-weight:bold;
                      box-shadow:0 5px 12px rgba(36,64,142,.25);">

                🛒 Ir al carrito

            </a>

            <a href="index.php?page=Checkout_Historial"
               style="background:#F8B8CF;
                      color:#24408E;
                      padding:14px 28px;
                      border-radius:8px;
                      text-decoration:none;
                      font-weight:bold;
                      box-shadow:0 5px 12px rgba(248,184,207,.35);">

                📋 Ver historial

            </a>

        </div>

    </div>

    <div class="col-12"
         style="display:flex;
                flex-wrap:wrap;
                justify-content:center;
                gap:25px;">

        {{foreach productos}}

        <div class="col-12 col-s-6 col-m-4"
             style="display:flex;justify-content:center;">

            <article style="background:#ffffff;
                            border:2px solid #F8B8CF;
                            border-radius:16px;
                            padding:1rem;
                            width:100%;
                            max-width:320px;
                            text-align:center;
                            box-shadow:0 8px 18px rgba(36,64,142,.10);">

                <img src="{{prdimg}}"
                     alt="{{prddsc}}"
                     style="width:100%;
                            height:180px;
                            object-fit:cover;
                            border-radius:10px;">

                <h3 style="color:#24408E;margin:15px 0 10px 0;">
                    {{prddsc}}
                </h3>

                <p>
                    <strong style="color:#24408E;">Categoría:</strong>
                    {{prdcategoria}}
                </p>

                <p>
                    <strong style="color:#24408E;">Descripción:</strong>
                    {{descripcion}}
                </p>

                <p style="font-size:1.1rem;margin:15px 0;">
                    <strong style="color:#24408E;">Precio:</strong>
                    L. {{prdcosto}}
                </p>

                <form action="index.php?page=Checkout_Carrito"
                      method="post"
                      style="margin-top:15px;">

                    <input type="hidden"
                           name="prdcod"
                           value="{{prdcod}}" />

                    <input type="hidden"
                           name="action"
                           value="ADD" />

                    <button type="submit"
                            style="background:#24408E;
                                   color:white;
                                   width:100%;
                                   padding:12px;
                                   border:none;
                                   border-radius:8px;
                                   font-weight:bold;
                                   cursor:pointer;
                                   transition:.2s;">

                        Agregar

                    </button>

                </form>

            </article>

        </div>

        {{endfor productos}}

    </div>

</section>