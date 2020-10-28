<?php

use AdamLewandowskiRekrutacjaHRtec\CsvRow;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../src/CsvRow.php";

final class CsvRowTest extends TestCase
{
    public function testCanConvertToArray(): void
    {
        $this->assertEquals(
            array(
                "title" => "1",
                "description" => "2",
                "link" => "3",
                "pubDate" => "4",
                "creator" => "5"
            ),
            (new CsvRow("1", "2", "3", "4", "5"))->toArray()
        );
    }

}