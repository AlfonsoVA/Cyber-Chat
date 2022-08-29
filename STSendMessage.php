<?php
    $chatWriter = fopen('chat.html', 'a');
    $msg = "<div><strong>".$_POST['user']." (".date("H:i")."): </strong>".nl2br(htmlspecialchars(stripslashes($_POST['msg'])))."</div>";
    fwrite($chatWriter, $msg);
    fclose($chatWriter);
?>