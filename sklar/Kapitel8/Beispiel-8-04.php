// Das Cookie verf�llt in einer Stunde
setcookie('kurze-benutzerid','ralf',time(  ) + 60*60);

// Das Cookie verf�llt in einem Tag
setcookie('laengere-benutzerid','ralf',time(  ) + 60*60*24);

// Das Cookie verf�llt um 12 Uhr am 1. Oktober 2006
setcookie('viel-laengere-benutzerid','ralf',mktime(12,0,0,10,1,2006));
