<?php

session_start(  );

print <<<_HTML_
<html>
<body bgcolor="$_SESSION[farbe]">
Diese Seite wird in Ihrer pers�nlichen Hintergrundfarbe angezeigt.
</body>
</html>
_HTML_;
?>