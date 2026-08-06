<section style="max-width:1000px; margin:0 auto; padding:2rem;">
    <h1>{{titulo}}</h1>
    <p>Aquí puedes ver el estado de tus compras y los pedidos registrados.</p>

    {{if orders}}
    <div style="display:flex; flex-direction:column; gap:12px; margin-top:1.5rem;">
        {{foreach orders}}
        <div style="border:1px solid #ddd; border-radius:10px; padding:16px; background:#f9f9f9;">
            <h3>Pedido #{{id_pedido}}</h3>
            <p><strong>Dirección de entrega:</strong> {{direccion_entrega}}</p>
            <p><strong>Método de pago:</strong> {{metodo_pago}}</p>
            <p><strong>Estado del pago:</strong> {{estado_pago}}</p>
            <p><strong>Estado del envío:</strong> {{estado}}</p>
            <p><strong>Total:</strong> L. {{total}}</p>
            <p><strong>Fecha:</strong> {{fecha}}</p>
            <ul>
                {{foreach items}}
                <li>{{nombre}} × {{cantidad}} — L. {{subtotal}}</li>
                {{endfor items}}
            </ul>
        </div>
        {{endfor orders}}
    </div>
    {{endif orders}}

    {{ifnot orders}}
    <div style="margin-top:1.5rem; background:#fff3cd; padding:16px; border-radius:8px;">
        Aún no tienes compras registradas.
    </div>
    {{endifnot orders}}

    <a href="index.php?page=Checkout_Catalogo" style="display:inline-block; margin-top:20px; color:#2b8251; text-decoration:none;">Volver al catálogo</a>
</section>
