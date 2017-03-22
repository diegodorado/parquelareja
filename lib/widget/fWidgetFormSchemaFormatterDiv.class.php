<?php

class fWidgetFormSchemaFormatterDiv extends sfWidgetFormSchemaFormatter {
  protected
    $rowFormat			 = "<div class=\"form-row\">
                          %label%%field%
                          %error%
                          %help%
                        %hidden_fields%
                        </div>
                        ",
    $helpFormat      = '<div class="form_helper">%help%</div>',
    $errorRowFormat  = "<div>%errors%</div>",
    $errorListFormatInARow     = "  <ul class=\"error_list\">%errors%  </ul>",
    $errorRowFormatInARow      = "    <li>%error%</li>",
    $namedErrorRowFormatInARow = "    <li>%name%: %error%</li>",
    $decoratorFormat = "<div>%content%</div>";
        
}

?>
