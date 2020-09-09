<?php
$text=<<<TEXT
"Es ist Zeit noch mal anzurufen", sagte Tommie rebellisch.
"Vollkommen richtig! Ich helfe dir", echote Tim.
TEXT;

// Ermittle alle Worte in $text, aber packe keinen Whitespace und keine
// Interpunktszeichen in $worte. Die -1 als Argument f�r die Grenze steht
// f�r "keine Grenze"
$worte = preg_split('/[",.!\s]/', $text, -1, PREG_SPLIT_NO_EMPTY);

print 'Es gibt ' . count($worte) .' W�rter im Text.';
?>