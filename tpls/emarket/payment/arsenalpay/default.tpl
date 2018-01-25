<?php
$FORMS = Array();

$FORMS['form_block'] = <<<END
<script src='https://arsenalpay.ru/widget/script.js'></script>
<div id='app-widget'></div>
 <script> 
    var APWidget = new ArsenalpayWidget({
        element: "app-widget",
        destination: "%destination%",
        widget: "%widget%",
        amount: "%amount%",
        userId: "%userId%",
        nonce: "%nonce%",
        widgetSign: "%widgetSign%"
    });
    APWidget.render();
</script>
END;

?>
