$a = gmp_mul(35, gmp_pow(10,405));
$b = gmp_mul(28, gmp_pow(10,405));

$a_quadrat = gmp_pow($a, 2);
$b_quadrat = gmp_pow($b, 2);

$hypothenuse = gmp_sqrt(gmp_add($a_quadrat, $b_quadrat));

print gmp_strval($hypothenuse);
