<?php
$text=<<<TEXT
"Es ist Zeit noch mal anzurufen", sagte Tommie rebellisch.
"Vollkommen richtig! Ich helfe dir", echote Tim.
TEXT;

$worte = preg_split('/[",.!\s]/', $text, -1, PREG_SPLIT_NO_EMPTY);

// Die Worte finden die Doppelbuchstaben enthalten
$doppelbuchstaben_worte = preg_grep('/([a-z])\\1/i',$worte);

foreach ($doppelbuchstaben_worte as $wort) {
    print "$wort\n";
}
?>