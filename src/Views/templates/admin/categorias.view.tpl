<section class="grid" style="padding: 1.5rem; font-family: sans-serif;">
  <div class="col-12" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h1 style="color: #333; margin: 0;">Gestión de Categorías</h1>
    <a href="index.php?page=Admin_CategoriaForm&mode=INS" style="background: #27ae60; color: white; padding: 0.7rem 1.2rem; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block;">
      + Agregar Nueva Categoría
    </a>
  </div>

  <div class="col-12" style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
      <thead>
        <tr style="background: #f2c94c; color: #333; text-align: left;">
          <th style="padding: 12px;">Código</th>
          <th style="padding: 12px;">Categoría</th>
          <th style="padding: 12px;">Estado</th>
          <th style="padding: 12px; text-align: center;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        {{foreach categorias}}
        <tr style="border-bottom: 1px solid #eee;">
          <td style="padding: 12px; font-weight: bold;">{{catcod}}</td>
          
          <!-- Imprime catnom o las alternativas si la columna en DB difiere -->
          <td style="padding: 12px;">
            <strong>{{catnom}}{{catdsc}}{{nombre}}</strong>
          </td>
          
          <td style="padding: 12px;">
            <span style="padding: 4px 8px; border-radius: 4px; font-weight: bold; background: #e8f8f5; color: #16a085;">
              {{catest}}
            </span>
          </td>
          <td style="padding: 12px; text-align: center; white-space: nowrap;">
            <a href="index.php?page=Admin_CategoriaForm&mode=UPD&catcod={{catcod}}" style="background: #2980b9; color: white; padding: 0.4rem 0.8rem; border-radius: 4px; text-decoration: none; margin-right: 4px; font-size: 0.85em; font-weight: bold;">Editar</a>
            <a href="index.php?page=Admin_CategoriaForm&mode=DEL&catcod={{catcod}}" style="background: #e74c3c; color: white; padding: 0.4rem 0.8rem; border-radius: 4px; text-decoration: none; font-size: 0.85em; font-weight: bold;">Eliminar</a>
          </td>
        </tr>
        {{endfor categorias}}
      </tbody>
    </table>
  </div>
</section>