
<section class="grid" style="display: flex; flex-wrap: wrap; justify-content: center;">
  <div class="col-12" style="text-align: center; margin-bottom: 2rem;">
    <h1>{{titulo}}</h1>
    <p>
      Descubre nuestro Catálogo de productos “La Neverita” <br><br>
      Prueba nuestros sabores de Helados, Gelatinas, granizados y <br>
      también las deliciosas frutas locas.
    </p>
  </div>

  {{foreach productos}}
  <div class="col-12 col-s-6 col-m-4" style="display: flex; justify-content: center;">
    <article style="border:1px solid #f2c94c; border-radius:12px; padding:1rem; background:#fff9e6; margin-bottom:1.5rem; width: 100%; max-width: 320px; text-align: center;">
      <img src="{{prdimg}}" alt="{{prddsc}}" style="width:100%; height:180px; object-fit:cover; border-radius:8px;" />
      <h3>{{prddsc}}</h3>
      <p><strong>Categoría:</strong> {{prdcategoria}}</p>
      <p><strong>Descripcion:</strong> {{descripcion}}</p>
      <p><strong>Precio:</strong> L. {{prdcosto}}</p>
      <a href="index.php?page=Checkout_Checkout" style="display:inline-block; margin-top:0.5rem; background:#ff6b6b; color:white; padding:0.6rem 1rem; border-radius:6px; text-decoration:none; font-weight: bold;">Agregar</a>
    </article>
  </div>
  {{endfor productos}}
</section>