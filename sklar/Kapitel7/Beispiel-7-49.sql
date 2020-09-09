; Alle Zeilen abrufen, bei denen der Gerichtname mit D beginnt
SELECT * FROM gerichte WHERE gerichtname LIKE 'D%'

; Alle Zeilen abrufen, bei denen der Gerichtname Frittierter Fisch
; Frittierter Bisch, Frittierter Tisch und so weiter ist
SELECT * FROM gerichte WHERE gerichtname LIKE 'Frittierter _isch'
