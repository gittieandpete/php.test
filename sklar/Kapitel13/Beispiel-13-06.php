$mailrumpf=<<<_TXT_
Ihre Bestellung ist:
* 2 Frittierter Tofu
* 1 Aubergine mit Chili-Soße
* 3 Ananas mit Yu-Pilzen
_TXT_;
mail('hungrig@beispiel.com','Ihre Bestellung',$mailrumpf);
