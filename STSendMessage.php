<?php
    $chatWriter = fopen('chat.html', 'a');
    $msg = "<div><strong>".date("H:i")." </strong>".$_POST['msg']."</div>";
    fwrite($chatWriter, $msg);
    fclose($chatWriter);
?>