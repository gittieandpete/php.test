; Gerichte, deren Preis größer ist als 5.00
SELECT gerichtname, preis FROM gerichte WHERE preis > 5.00

; Gericht, deren Name genau gleich "Walnuss-Weckchen" ist
SELECT preis FROM gerichte WHERE gerichtname = 'Walnuss-Weckchen'

; Gerichte, deren Preis größer als 5.00 aber kleiner gleich 10.00 ist
SELECT gerichtname FROM gerichte WHERE preis > 5.00 AND preis <= 10.00

; Grichte, deren Preis größer als 5.00 aber kleiner gleich 10.00 ist oder
; Gerichte, deren Name (bei beliebigem Preis) genau gleich "Walnuss-Weckchen" ist
SELECT gerichtname, preis FROM gerichte WHERE (preis > 5.00 AND preis <= 10.00)
       OR gerichtname = 'Walnuss-Weckchen'
