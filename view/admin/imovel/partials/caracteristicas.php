<div class="row">
   <div class="col-sm-12">
      <h4 class="mb-5">Adicione características ao imóvel</h4>
   </div>
</div>

<div class="row">

   <input type="hidden" id="alterou_caracteristica" name="alterou_caracteristica" value="0">

   <?php foreach ($data['caracteristica_categorias'] as $cat) : ?>
      <div class="col-12 col-sm-12 col-md-12">
         <h5><b><?= $cat->caracteristica_categoria_nome ?></b></h5>

         <div class="row">
            <?php foreach ($cat->caracteristicas as $caracteristica) : ?>
               <div class="col-12 col-sm-12 col-md-3">
                  <input type="checkbox" class="checkbox-caracteristicas" <?php if (in_array($caracteristica->caracteristica_id, $data['caracteristicas_vinculadas'])) : ?>checked<?php endif; ?> name="imovel_caracteristicas[]" value="<?= $caracteristica->caracteristica_id ?>" id="caracteristica-checkbox-<?= $caracteristica->caracteristica_id ?>">
                  <label class="text-muted" for="caracteristica-checkbox-<?= $caracteristica->caracteristica_id ?>"><?= stripslashes($caracteristica->caracteristica_nome) ?></label>
                  <?php if ($caracteristica->caracteristica_diferencial == '1') : ?>
                     <i class="fa fa-star text-yellow"></i>
                  <?php endif; ?>
               </div>
            <?php endforeach; ?>
         </div>
      </div>
   <?php endforeach; ?>
</div>