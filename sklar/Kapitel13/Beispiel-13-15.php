// Die Hypothenuse eines riesigen rechtwinkligen Dreiecks berechnen
// Die Seitenlängen sind 3.5e406 und 2.8e406

$a = bcmul(3.5, bcpow(10, 406));
$b = bcmul(2.8, bcpow(10, 406));

$a_quadrat = bcpow($a, 2);
$b_quadrat = bcpow($b, 2);

$hypothenuse = bcsqrt(bcadd($a_quadrat, $b_quadrat));

print $hypothenuse;
