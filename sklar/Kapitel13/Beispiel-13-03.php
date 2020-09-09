// SWF Version 6 verwenden, um Actionscript zu aktivieren
ming_UseSwfVersion(6);

// Einen neuen Film erzeugen und einige Parameter setzen
$film = new SWFMovie(  );
$film->setRate(20.000000);
$film->setDimension(550, 400);
$film->setBackground(0xcc,0xcc,0xcc);

// Den Kreis erzeugen
$kreis = new SWFShape(  );
$kreis->setRightFill(33,66,99);
$kreis->drawCircle(40);
$sprite= new SWFSprite(  );
$sprite->add($circle);
$sprite->nextFrame(  );

// Dem Film den Kreis hinzufügen
$anzeige_element = $film->add($sprite);
$anzeige_element->setName('kreis');
$anzeige_element->moveTo(100,100);

// Das Actionscript hinzufügen, das das Herumziehen implementiert
$film->add(new SWFAction("
 kreis.onPress=function(  ){ this.startDrag('');};
 kreis.onRelease= kreis.onReleaseOutside=function(  ){ stopDrag(  );};
"));

// Den Film anzeigen
header("Content-type: application/x-shockwave-flash");
$movie->output(1);
