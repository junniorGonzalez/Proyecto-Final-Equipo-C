<section class="grid" style="display:flex; flex-direction:column; align-items:center;">

{{if carrito}}

<div style="text-align:center; margin-bottom:30px;">
    <h1>{{titulo}}</h1>
    <p>Estos son los productos que has agregado a tu carrito.</p>
</div>

<div style="display:flex; flex-wrap:wrap; justify-content:center; gap:18px; width:100%;">

{{foreach carrito}}

<div style="border:1px solid #f2c94c;
            border-radius:12px;
            background:#fff9e6;
            width:260px;
            padding:15px;
            text-align:center;">

    <img src="{{prdimg}}"
         alt="{{prddsc}}"
         style="width:100%;
                height:180px;
                object-fit:cover;
                border-radius:8px;">

    <h3>{{prddsc}}</h3>

    <p><strong>Precio:</strong> L. {{prdcosto}}</p>

    <p><strong>Cantidad</strong></p>

    <div style="display:flex;justify-content:center;align-items:center;gap:8px;">

        <form action="index.php?page=Checkout_Carrito" method="post">

            <input type="hidden" name="action" value="MINUS">
            <input type="hidden" name="prdcod" value="{{prdcod}}">

            <button type="submit">-</button>

        </form>

        <strong>{{cantidad}}</strong>

        <form action="index.php?page=Checkout_Carrito" method="post">

            <input type="hidden" name="action" value="PLUS">
            <input type="hidden" name="prdcod" value="{{prdcod}}">

            <button type="submit">+</button>

        </form>

    </div>

    <p>
        <strong>Subtotal:</strong>
        L. {{subtotal}}
    </p>

    <form action="index.php?page=Checkout_Carrito" method="post">

        <input type="hidden" name="action" value="DELETE">
        <input type="hidden" name="prdcod" value="{{prdcod}}">

        <button type="submit"
                style="width:100%;
                       background:#ff6b6b;
                       color:white;
                       border:none;
                       border-radius:6px;
                       padding:10px;">
            Eliminar
        </button>

    </form>

</div>

{{endfor carrito}}

</div>

<div style="text-align:center;margin-top:35px;">

    <h2>Total: L. {{total}}</h2>

    <div style="display:flex;justify-content:center;gap:15px;margin-top:20px;">

        <a href="index.php?page=Checkout_Catalogo"
           style="background:#2b8251;
                  color:white;
                  padding:12px 24px;
                  border-radius:8px;
                  text-decoration:none;">
            Seguir comprando
        </a>

        <form action="index.php?page=Checkout_Carrito" method="post">

            <input type="hidden" name="action" value="CLEAR">

            <button type="submit"
                    style="background:#ff6b6b;
                           color:white;
                           border:none;
                           border-radius:8px;
                           padding:12px 24px;">
                Vaciar carrito
            </button>

            <a href="index.php?page=Checkout_Pago"
   style="
      display:inline-block;
      margin-left:15px;
      background:#007bff;
      color:#fff;
      padding:12px 24px;
      border-radius:8px;
      text-decoration:none;
      font-weight:bold;">

    Finalizar compra

</a>

        </form>

    </div>

</div>

{{endif carrito}}

{{ifnot carrito}}

<div style="text-align:center;margin:80px auto;">

    <h1>Carrito de Compras</h1>

    <p>Tu carrito está vacío.</p>

    <br>

    <a href="index.php?page=Checkout_Catalogo"
       style="background:#2b8251;
              color:white;
              padding:12px 24px;
              border-radius:8px;
              text-decoration:none;">
        Seguir comprando
    </a>

    

</div>

{{endifnot carrito}}

</section>