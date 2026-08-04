<section class="grid" style="background:#F8FCFF;padding:40px 20px;display:flex;flex-direction:column;align-items:center;">

{{if carrito}}

<div style="text-align:center;margin-bottom:45px;">

    <img src="public/imgs/logo.png"
         alt="La Neverita"
         style="width:180px;margin-bottom:20px;">

    <h1 style="font-size:2.8rem;color:#24408E;">
        {{titulo}}
    </h1>

    <p style="max-width:700px;color:#555;font-size:1.1rem;line-height:1.8;">

        Estos son los productos que has agregado a tu carrito.

    </p>

</div>

<div style="display:flex;
            flex-wrap:wrap;
            justify-content:center;
            gap:25px;
            width:100%;">

{{foreach carrito}}

<div style="background:#ffffff;
            border:2px solid #F8B8CF;
            border-radius:16px;
            width:300px;
            padding:18px;
            text-align:center;
            box-shadow:0 8px 18px rgba(36,64,142,.10);">

    <img src="{{prdimg}}"
         alt="{{prddsc}}"
         style="width:100%;
                height:190px;
                object-fit:cover;
                border-radius:10px;">

    <h3 style="color:#24408E;margin-top:15px;">
        {{prddsc}}
    </h3>

    <p>
        <strong style="color:#24408E;">Precio:</strong>
        L. {{prdcosto}}
    </p>

    <p>
        <strong style="color:#24408E;">Cantidad</strong>
    </p>

    <div style="display:flex;
                justify-content:center;
                align-items:center;
                gap:10px;">

        <form action="index.php?page=Checkout_Carrito" method="post">

            <input type="hidden" name="action" value="MINUS">
            <input type="hidden" name="prdcod" value="{{prdcod}}">

            <button type="submit"
                    style="width:34px;
                           height:34px;
                           border:none;
                           border-radius:50%;
                           background:#24408E;
                           color:white;
                           font-size:18px;">
                -
            </button>

        </form>

        <strong style="font-size:18px;">
            {{cantidad}}
        </strong>

        <form action="index.php?page=Checkout_Carrito" method="post">

            <input type="hidden" name="action" value="PLUS">
            <input type="hidden" name="prdcod" value="{{prdcod}}">

            <button type="submit"
                    style="width:34px;
                           height:34px;
                           border:none;
                           border-radius:50%;
                           background:#24408E;
                           color:white;
                           font-size:18px;">
                +
            </button>

        </form>

    </div>

    <p style="margin-top:18px;font-size:18px;">

        <strong style="color:#24408E;">Subtotal:</strong>

        L. {{subtotal}}

    </p>

    <form action="index.php?page=Checkout_Carrito" method="post">

        <input type="hidden" name="action" value="DELETE">
        <input type="hidden" name="prdcod" value="{{prdcod}}">

        <button type="submit"
                style="width:100%;
                       margin-top:10px;
                       background:#F8B8CF;
                       color:#24408E;
                       border:none;
                       border-radius:8px;
                       padding:12px;
                       font-weight:bold;
                       cursor:pointer;">

            Eliminar

        </button>

    </form>

</div>

{{endfor carrito}}

</div>

<div style="text-align:center;margin-top:45px;">

    <h2 style="font-size:2rem;color:#24408E;">

        Total: L. {{total}}

    </h2>

    <div style="display:flex;
                justify-content:center;
                flex-wrap:wrap;
                gap:15px;
                margin-top:25px;">

        <a href="index.php?page=Checkout_Catalogo"
           style="background:#24408E;
                  color:white;
                  padding:14px 28px;
                  border-radius:8px;
                  text-decoration:none;
                  font-weight:bold;">

            Seguir comprando

        </a>

        <form action="index.php?page=Checkout_Carrito"
              method="post"
              style="display:inline;">

            <input type="hidden"
                   name="action"
                   value="CLEAR">

            <button type="submit"
                    style="background:#F8B8CF;
                           color:#24408E;
                           border:none;
                           border-radius:8px;
                           padding:14px 28px;
                           font-weight:bold;
                           cursor:pointer;">

                Vaciar carrito

            </button>

        </form>

        <a href="index.php?page=Checkout_Pago"
           style="background:#24408E;
                  color:white;
                  padding:14px 28px;
                  border-radius:8px;
                  text-decoration:none;
                  font-weight:bold;">

            Finalizar compra

        </a>

    </div>

</div>

{{endif carrito}}

{{ifnot carrito}}

<div style="text-align:center;margin:80px auto;">

    <img src="public/imgs/logo.png"
         style="width:180px;margin-bottom:20px;">

    <h1 style="color:#24408E;font-size:2.7rem;">
        Carrito de Compras
    </h1>

    <p style="font-size:1.15rem;color:#555;">

        Tu carrito está vacío.

    </p>

    <br>

    <a href="index.php?page=Checkout_Catalogo"
       style="background:#24408E;
              color:white;
              padding:14px 28px;
              border-radius:8px;
              text-decoration:none;
              font-weight:bold;">

        Ver catálogo

    </a>

</div>

{{endifnot carrito}}

</section>