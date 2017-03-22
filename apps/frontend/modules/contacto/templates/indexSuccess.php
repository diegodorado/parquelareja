<?php slot('body_class') ?>contacto<?php end_slot() ?>

<div class="left">
  <h3>Contacto</h3>
  <form action="<?=url_for('@contacto_index') ?>" method="post">
    <?=$form?>
    <div class="form-row botones">
      <input value="Enviar" name="enviar" class="submit" type="submit">
    </div>
  </form>
</div>
<div class="right">
  <?php include_partial('a/areaTemplate', array('name' => 'sidebar', 'width' => 350)) ?>
</div>
