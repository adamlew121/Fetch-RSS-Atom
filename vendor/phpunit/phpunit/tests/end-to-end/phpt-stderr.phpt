--TEST--
GH-1169: PHPT runner doesn't look at STDERR.
--FILE--
<?php declare(strict_types=1);
$stderr = fopen('php://stderr', 'w');
fwrite($stderr, 'PHPUnit must look at STDERR when running PHPT test.');
--EXPECTF--
PHPUnit must look at STDERR when running PHPT tests.
