<section style="max-width: 450px; margin: 2rem auto; background: #ffffff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); font-family: sans-serif;">
  <h2 style="margin-top:0; color:#333; text-align:center;">{{mode_desc}}</h2>
  
  <form action="index.php?page=Admin_CategoriaForm" method="post">
    <input type="hidden" name="mode" value="{{mode}}" />
    <input type="hidden" name="catcod" value="{{catcod}}" />

    <div style="margin-bottom: 1.2rem;">
      <label style="display:block; font-weight:bold; margin-bottom:0.4rem; color:#555;">Nombre de la Categoría:</label>
      <input type="text" name="catnom" value="{{catnom}}" {{readonly}} required placeholder="Ej. Helados, Granizados..." style="width:100%; padding:0.6rem; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; background-color: #fff;" />
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label style="display:block; font-weight:bold; margin-bottom:0.4rem; color:#555;">Estado:</label>
      <select name="catest" {{readonly}} style="width:100%; padding:0.6rem; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; background-color: #fff;">
        <option value="ACT">Activa</option>
        <option value="INA">Inactiva</option>
      </select>
    </div>

    <div style="display:flex; justify-content: space-between; gap: 1rem; margin-top: 1.5rem;">
      <button type="submit" style="flex:1; background:#27ae60; color:#fff; padding:0.7rem; border:none; border-radius:6px; font-weight:bold; cursor:pointer;">Guardar</button>
      <a href="index.php?page=Admin_Categorias" style="flex:1; text-align:center; background:#e74c3c; color:#fff; padding:0.7rem; border-radius:6px; font-weight:bold; text-decoration:none;">Cancelar</a>
    </div>
  </form>
</section>