<?php

session_start(  );

print <<<_HTML_
<html>
<body bgcolor="$_SESSION[farbe]">
Diese Seite wird in Ihrer persönlichen Hintergrundfarbe angezeigt.
</body>
</html>
_HTML_;
?>