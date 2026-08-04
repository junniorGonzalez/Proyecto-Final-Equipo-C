<section style="max-width:800px; margin:0 auto; padding:2rem;">
    <div style="text-align:center; background:#d4edda; padding:20px; border-radius:10px; margin-bottom:30px;">
        <h1 style="color:#155724; margin:0;">✓ Orden Aceptada</h1>
        <p style="color:#155724; margin:10px 0 0 0;">Tu pago ha sido procesado correctamente</p>
    </div>

    {{if total}}
    <div style="background:#f9f9f9; border:2px solid #2b8251; border-radius:10px; padding:20px; margin-bottom:20px;">
        <h2 style="color:#2b8251; text-align:center;">Resumen de tu compra</h2>
        
        {{if items}}
        <ul style="list-style:none; padding:0;">
            {{foreach items}}
            <li style="padding:8px 0; border-bottom:1px solid #eee;">
                <strong>{{nombre}}</strong> × {{cantidad}} — L. {{subtotal}}
            </li>
            {{endfor items}}
        </ul>
        {{endif items}}
        
        <div style="text-align:right; margin-top:15px; padding-top:15px; border-top:2px solid #2b8251;">
            <h3 style="color:#2b8251; margin:10px 0;">Total pagado: L. {{total}}</h3>
        </div>
        
        {{if payment_method}}
        <p style="color:#666; margin-top:15px;">
            <strong>Método de pago:</strong> {{payment_method}}
        </p>
        {{endif payment_method}}
        
        {{if order_id}}
        <p style="color:#666;">
            <strong>ID de orden:</strong> {{order_id}}
        </p>
        {{endif order_id}}
    </div>
    {{endif total}}

    <div style="text-align:center; margin-top:30px;">
        <a href="index.php?page=Checkout_Historial" style="display:inline-block; background:#2b8251; color:white; padding:12px 24px; border-radius:8px; text-decoration:none; font-weight:bold; margin-right:10px;">
            Ver historial de compras
        </a>
        <a href="index.php?page=Checkout_Catalogo" style="display:inline-block; background:#007bff; color:white; padding:12px 24px; border-radius:8px; text-decoration:none; font-weight:bold;">
            Volver al catálogo
        </a>
    </div>

    <hr style="margin-top:30px;">
    <details style="margin-top:20px;">
        <summary style="cursor:pointer; color:#666;">Detalles de la orden</summary>
        <pre style="background:#f5f5f5; padding:10px; border-radius:5px; overflow-x:auto;">
{{orderjson}}
        </pre>
    </details>
</section>
