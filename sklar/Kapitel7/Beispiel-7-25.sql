; Die Zeilen entfernen, bei denen preis größer als 10.00 ist
DELETE FROM gerichte WHERE preis > 10.00

; Die Zeilen entfernen, bei denen gerichtname genau gleich "Walnuss-Weckchen" ist
DELETE FROM gerichte WHERE gerichtname = 'Walnuss-Weckchen'
