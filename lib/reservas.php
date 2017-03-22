<?

class Reserva
{
  var $id;
  var $fecha;
  var $estado_uso_cde;
  var $estado_uso_cdt;
  var $comentario;
  var $texto;

  function Reserva()
  {
  }

  function setTexto($v)
  {
    $v = str_replace(chr(10),'',$v);
    $v = str_replace(chr(13),'\\n',$v);
    $v = str_replace("'",'"',$v);
    $v = str_replace(chr(13),'<br/>',$v);
    $v = str_replace(chr(10),'',$v);
    $this->texto = $v;
  }

  function getTexto()
  {
    return $this->texto;
  }

  function getFullTexto()
  {
    setlocale(LC_ALL, 'es_ES');
    return '<h4>'.aDate::pretty($this->fecha).':</h4>'.$this->getTexto();
  }

  function getClassName()
  {
    return 'cde_'.strtolower($this->estado_uso_cde).' cdt_'.strtolower($this->estado_uso_cdt).(($this->comentario)?' comentario':'');
  }


}


class CalendarDay
{
  var $reserva;
  var $year;
  var $month;
  var $day;
  var $fecha;
  function CalendarDay($fecha)
  {
    $this->fecha = $fecha;
    $this->day = (int) date("d",$fecha);
    $this->month = (int) date("m",$fecha);
    $this->year = (int) date("Y",$fecha);
  }

  function hasReserva()
  {
    return isset($this->reserva);
  }
  function getId()
  {
    return 'cal_day_'.$this->year.'_'.$this->month.'_'.$this->day;
  }
}

class CalendarMonth
{
  var $year;
  var $month;
  var $days;
  var $first;
  var $dayNames = array("lu", "ma", "mi", "ju", "vi", "sa", "do");
  var $monthNames = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                          "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Deciembre");

  function CalendarMonth($m, $y)
  {
    $this->year = $y;
    $this->month = $m;
    $this->first = mktime(0,0,0,$this->month,1, $this->year);
    for ($i = 1; $i <= date('t',$this->first); $i++) {
      $d = new CalendarDay(mktime(0,0,0,$this->month,$i, $this->year));
      $this->days[$i] = $d;
    }
    $this->initReservasFromDB();
  }

  function initReservasFromDB()
  {
	  /*
    setlocale(LC_TIME, 'es_ES.UTF-8');
    */
    $sql="select id, fecha, DATE_FORMAT(fecha,'%d') as dia, estado_uso_cde, estado_uso_cdt, comentario, texto from reserva where DATE_FORMAT(fecha,'%m') = ".$this->month." AND DATE_FORMAT(fecha,'%Y') = ".$this->year." order by fecha asc";
	  $rs = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);

    foreach($rs as $row){
      $reserva = new Reserva();
      $reserva->id = $row['id'];
      $reserva->fecha = strtotime($row['fecha']);
      $reserva->estado_uso_cde = $row['estado_uso_cde'];
      $reserva->estado_uso_cdt = $row['estado_uso_cdt'];
      $reserva->comentario = $row['comentario'];
      $reserva->setTexto($row['texto']);
      $this->days[(int)$row['dia']]->reserva = $reserva;
    }
  }


  function getMonthName()
  {
    return $this->monthNames[$this->month-1];
  }

  function getHTML()
  {
    $prefix = date('w',$this->first);
    $prefix = ($prefix==0)?6:$prefix-1;

    $s = '';
    $s .= '<div id="month_'.$this->month.'" class="month_content">';
    $s .= '<h4>'.$this->getMonthName().' / '.$this->year.'</h4>';
    foreach($this->dayNames as $day) {
      $s .= '<span class="day header">'.$day.'</span>';
    }
    for ($i = 1; $i <= $prefix; $i++) {
      $s .= '<div class="prefix"></div>';
    }
    foreach ($this->days as $d) {
      $s .= '<a href="#" id="'.$d->getId().'" class="day  '.(($d->hasReserva())?$d->reserva->getClassName():'').'">'.$d->day.'</a>';
    }
    $s .= '</div>';
    $s .= '<script type="text/javascript" language="javascript">';
    foreach ($this->days as $d) {
      if ($d->hasReserva()){
        $s .= "$('#".$d->getId()."').click(function(e){
                  e.preventDefault();
                  $('#calendar_details_content').html('".$d->reserva->getFullTexto()."');
                  $('#calendar_details_content').show();
              });";
      }
    }
    $s .= '</script>';
    
    return $s;
  }


  function getAdminHTML()
  {
    $prefix = date('w',$this->first);
    $prefix = ($prefix==0)?6:$prefix-1;

    $s = '<div id="month_'.$this->month.'" class="month_content">';
    $s .= '<h4>'.$this->getMonthName().' / '.$this->year.'</h4>';
    foreach($this->dayNames as $day) {
      $s .= '<span class="day header">'.$day.'</span>';
    }
    for ($i = 1; $i <= $prefix; $i++) {
      $s .= '<div class="prefix"></div>';
    }
    foreach ($this->days as $d) {
      $s .= '<a href="'.url_for('@calendario_admin_edit?fecha='.$d->fecha).'" class="day  '.(($d->hasReserva())?$d->reserva->getClassName():'').'">'.$d->day.'</a>';
    }
    $s .= '</div>';
    return $s;
  }



}

class Calendar
{
  var $months;
  var $reservas;

  function Calendar()
  {
    $this->initCalendar();
  }

  function initCalendar()
  {
    $d = getdate(time());
    $month = $d["mon"];
    $year = $d["year"];
    for ($i = -2; $i <= 6; $i++) {
      if ($month +$i<1){
        $m = new CalendarMonth( $month+$i+12, $year-1);
      }elseif($month +$i>12){
        $m = new CalendarMonth( $month+$i-12, $year+1);
      }else{
        $m = new CalendarMonth( $month+$i, $year);
      }
      $this->months[] = $m;
    }
  }


  function getHTML($admin=false)
  {
    $s = '';
    $months_count = ($admin)?8:5;
    for ($i = 0; $i <= $months_count; $i++) {
      $s .= ($admin)?$this->months[$i]->getAdminHTML():$this->months[$i]->getHTML();
    }
    return $s;
  }

}
?>
