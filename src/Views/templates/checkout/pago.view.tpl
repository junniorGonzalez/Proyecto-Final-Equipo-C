<section style="max-width:900px; margin:0 auto; padding:2rem;">
    <h1>{{titulo}}</h1>
    <p>Revisa tu pedido y confirma el pago con PayPal.</p>
    <p style="color:#2b8251; font-weight:bold;">Se realizará el pago.</p>

    {{if error}}
    <div style="background:#fff3cd; color:#856404; padding:12px 16px; border-radius:8px; margin-bottom:1rem;">
        {{error}}
    </div>
    {{endif error}}

    <div style="display:flex; flex-wrap:wrap; gap:20px; margin-top:1.5rem;">
        <div style="flex:2; min-width:280px;">
            <h3>Productos</h3>
            {{foreach carrito}}
            <div style="border:1px solid #eee; border-radius:8px; padding:12px; margin-bottom:10px;">
                <strong>{{prddsc}}</strong><br>
                Cantidad: {{cantidad}}<br>
                Subtotal: L. {{subtotal}}
            </div>
            {{endfor carrito}}
        </div>

        <div style="flex:1; min-width:260px; background:#f9f9f9; padding:16px; border-radius:10px;">
            <h3>Resumen</h3>
            <p><strong>Total:</strong> L. {{total}}</p>
            <form action="index.php?page=Checkout_Pago" method="post">
                <button type="submit"
                    style="background:#0070ba; color:white; border:none; border-radius:8px; padding:12px 18px; width:100%; font-weight:bold; cursor:pointer;">
                    Pagar con PayPal
                </button>
            </form>
            <a href="index.php?page=Checkout_Carrito"
                style="display:inline-block; margin-top:12px; color:#2b8251; text-decoration:none;">Volver al
                carrito</a>
            <a href="index.php?page=Checkout_Historial"
                style="display:inline-block; margin-top:8px; color:#007bff; text-decoration:none;">Ver historial de
                compras</a>
        </div>
    </div>
</section>