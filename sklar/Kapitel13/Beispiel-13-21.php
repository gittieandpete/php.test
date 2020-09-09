$fenster =& new GtkWindow(  );

$button =& new GTKButton('Ich bin ein Button, klicken Sie mich an.');
$fenster->add($button);

$fenster->show_all(  );

function shutdown(  ) { gtk::main_quit(  ); }
$fenster->connect('destroy','shutdown');

gtk::main(  );
