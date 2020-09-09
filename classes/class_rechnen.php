<?php

class rechnen
    {
    public static $counter = 0;
    public static $objcount = 0;
    public function __construct()
        {
        self::$objcount++;
        print "<p>(Konstruktor-Ausgabe:) Die Klasse 'rechnen' wurde das " . self::$objcount . ". mal benutzt für:</p>\n\n";
    }
    public $ergebnis;
    public $c;

    public function plus($a, $b)
        {
        $this->zaehle();
        $operator = '+';
        $c = $a + $b;
        $ergebnis = $this->format($c,$operator,$a,$b);
        //nicht $this->$ergebnis
        $this->ergebnis = $ergebnis;
    }

    public function minus($a, $b)
        {
        $this->zaehle();
        $operator = '-';
        $c = $a - $b;
        $ergebnis = $this->format($c,$operator,$a,$b);
        $this->ergebnis = $ergebnis;
    }

    public function mal($a, $b)
        {
        $this->zaehle();
        $operator = '*';
        $c = $a * $b;
        $ergebnis = $this->format($c,$operator,$a,$b);
        $this->ergebnis = $ergebnis;
    }

    public function geteilt($a, $b)
        {
        $this->zaehle();
        $operator = '/';
        $c = $a / $b;
        $ergebnis = $this->format($c,$operator,$a,$b);
        $this->ergebnis = $ergebnis;
    }

    public function hoch($a, $b)
        {
        $this->zaehle();
        $operator = 'hoch';
        $c = pow($a,$b);
        $ergebnis = $this->format($c,$operator,$a,$b);
        $this->ergebnis = $ergebnis;
        return $this->c;
    }

    public function rest($a, $b)
        {
        $this->zaehle();
        $operator = 'modulo';
        $c = $a % $b;
        $ergebnis = $this->format($c,$operator,$a,$b);
        $this->ergebnis = $ergebnis;
    }

    protected function format($ergebnis,$operator,$a,$b)
        {
        $ausgabe = "<p>" . self::$counter . ". $a $operator $b = $ergebnis</p>\n";
        return $ausgabe;
    }
    protected function zaehle()
        {
        self::$counter++;
    }
}