<style>
#edit_calendar_day{
  font-size:12px;
  padding:20px;
}
#edit_calendar_day div.form-row{
  padding:5px;
}
</style>

<div id="content">
  <div id="edit_calendar_day">
    <form method="post">
      <input name="id" type="hidden" value="<?=$reserva->id?>" />
      <input name="fecha" type="hidden" value="<?=$reserva->fecha?>" />
      <div class="form-row">
        Fecha: <strong><?=date('d-M-Y',$reserva->fecha)?></strong>
      </div>
      <div class="form-row">
        <label for="estado_uso_cde">Estado de uso del CDE:</label>
        <input type="radio" name="estado_uso_cde" value="T" <?=($reserva->estado_uso_cde=='T')?'checked':''?> /> Total 
        <input type="radio" name="estado_uso_cde" value="P" <?=($reserva->estado_uso_cde=='P')?'checked':''?> /> Parcial 
        <input type="radio" name="estado_uso_cde" value="L"<?=(!$reserva->estado_uso_cde || $reserva->estado_uso_cde=='L')?'checked':''?> /> Libre
      </div>
      <div class="form-row">
        <label for="estado_uso_cdt">Estado de uso del CDT:</label>
        <input type="radio" name="estado_uso_cdt" value="T" <?=($reserva->estado_uso_cdt=='T')?'checked':''?> /> Total 
        <input type="radio" name="estado_uso_cdt" value="P" <?=($reserva->estado_uso_cdt=='P')?'checked':''?> /> Parcial 
        <input type="radio" name="estado_uso_cdt" value="L" <?=(!$reserva->estado_uso_cdt || $reserva->estado_uso_cdt=='L')?'checked':''?> /> Libre
      </div>
      <div class="form-row">
        <label for="cdt">Tiene comentario?:</label>
        <input type="checkbox" name="comentario" <?=($reserva->comentario)?'checked':''?> />
      </div>
      <div class="form-row">
        <label for="texto">Texto:</label><br/>
        
<?
    $error_reporting = error_reporting(E_ALL);

    $php_file = sfConfig::get('sf_rich_text_fck_js_dir').DIRECTORY_SEPARATOR.'fckeditor.php';
    require_once(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.$php_file);
    // turn error reporting back to your settings
    error_reporting($error_reporting);
    // What if the name isn't an acceptable id? 
    $fckeditor           = new FCKeditor('texto');
    $fckeditor->BasePath = sfContext::getInstance()->getRequest()->getRelativeUrlRoot().'/'.sfConfig::get('sf_rich_text_fck_js_dir').'/';
    $fckeditor->Value    = $reserva->getTexto();
    echo $fckeditor->CreateHtml();
?>        
        
      </div>
      <div class="form-row">
        <input name="save" type="submit" value="Guardar"/>
        <?if($reserva->id):?><input name="delete" type="submit" value="Eliminar"/><?endif?>
        <input name="cancel" type="submit" value="Cancelar"/>
      </div>
    </form>
  </div>
</div> <!-- fin content -->
