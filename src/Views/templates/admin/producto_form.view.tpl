<section style="max-width: 550px; margin: 2rem auto; background: #ffffff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); font-family: sans-serif;">
  <h2 style="margin-top:0; color:#333; text-align:center;">{{mode_desc}}</h2>
  
  <form action="index.php?page=Admin_ProductoForm" method="post" enctype="multipart/form-data">
    <input type="hidden" name="mode" value="{{mode}}" />
    <input type="hidden" name="prdcod" value="{{prdcod}}" />
    <input type="hidden" name="prdimg" value="{{prdimg}}" />

    <div style="margin-bottom: 1.2rem;">
      <label style="display:block; font-weight:bold; margin-bottom:0.4rem; color:#555;">Nombre del Producto:</label>
      <input type="text" name="prddsc" value="{{prddsc}}" {{readonly}} required placeholder="Ej. Helado de Fresa" style="width:100%; padding:0.6rem; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; background-color: #fff;" />
    </div>

    <!-- Campo de Categoría como texto manual -->
    <div style="margin-bottom: 1.2rem;">
      <label style="display:block; font-weight:bold; margin-bottom:0.4rem; color:#555;">Categoría:</label>
      <input type="text" name="prdcategoria" value="{{prdcategoria}}" {{readonly}} required placeholder="Ej. Helados, Gelatinas, Repostería..." style="width:100%; padding:0.6rem; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; background-color: #fff;" />
    </div>

    <div style="margin-bottom: 1.2rem;">
      <label style="display:block; font-weight:bold; margin-bottom:0.4rem; color:#555;">Precio (L.):</label>
      <input type="number" step="0.01" name="prdcosto" value="{{prdcosto}}" {{readonly}} required placeholder="0.00" style="width:100%; padding:0.6rem; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; background-color: #fff;" />
    </div>

    <div style="margin-bottom: 1.2rem;">
      <label style="display:block; font-weight:bold; margin-bottom:0.4rem; color:#555;">Inventario / Stock:</label>
      <input type="number" name="stock" value="{{stock}}" {{readonly}} required placeholder="0" style="width:100%; padding:0.6rem; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; background-color: #fff;" />
    </div>

    <div style="margin-bottom: 1.2rem;">
      <label style="display:block; font-weight:bold; margin-bottom:0.4rem; color:#555;">Estado:</label>
      <select name="prdest" {{readonly}} style="width:100%; padding:0.6rem; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; background-color: #fff;">
        <option value="Disponible">Disponible</option>
        <option value="Agotado">Agotado</option>
      </select>
    </div>

    <div style="margin-bottom: 1.2rem;">
      <label style="display:block; font-weight:bold; margin-bottom:0.4rem; color:#555;">Descripción Detallada:</label>
      <textarea name="descripcion" {{readonly}} placeholder="Escribe una breve descripción del producto..." style="width:100%; height:80px; padding:0.6rem; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; background-color: #fff;">{{descripcion}}</textarea>
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label style="display:block; font-weight:bold; margin-bottom:0.4rem; color:#555;">Imagen del Producto:</label>
      <input type="file" name="prdimg_file" accept="image/*" style="width:100%;" />
    </div>

    <div style="display:flex; justify-content: space-between; gap: 1rem; margin-top: 1.5rem;">
      <button type="submit" style="flex:1; background:#27ae60; color:#fff; padding:0.7rem; border:none; border-radius:6px; font-weight:bold; cursor:pointer;">Guardar</button>
      <a href="index.php?page=Admin_Productos" style="flex:1; text-align:center; background:#e74c3c; color:#fff; padding:0.7rem; border-radius:6px; font-weight:bold; text-decoration:none;">Cancelar</a>
    </div>
  </form>
</section>