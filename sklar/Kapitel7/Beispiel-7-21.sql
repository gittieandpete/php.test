; Den ist_scharf-Status von Aubergine mit Chili-Soße ändern
UPDATE gerichte SET ist_scharf = 1
              WHERE gerichtname = 'Aubergine mit Chili-Soße'

; Den Preis von General Schmitz' Hühnchen ändern
UPDATE gerichte SET preis = preis - 1
              WHERE gerichtname = 'General Schmitz\' Hühnchen'
