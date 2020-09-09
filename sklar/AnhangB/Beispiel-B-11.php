<?php
$text=<<<TEXT
"Es ist Zeit noch mal anzurufen", sagte Tommie rebellisch.
"Vollkommen richtig! Ich helfe dir", echote Tim.
TEXT;

// Ermittle alle Worte in $text, aber packe keinen Whitespace und keine
// Interpunktszeichen in $worte. Die -1 als Argument für die Grenze steht
// für "keine Grenze"
$worte = preg_split('/[",.!\s]/', $text, -1, PREG_SPLIT_NO_EMPTY);

print 'Es gibt ' . count($worte) .' Wörter im Text.';
?>