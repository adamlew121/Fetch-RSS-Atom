<?php

use AdamLewandowskiRekrutacjaHRtec\CsvRow;
use AdamLewandowskiRekrutacjaHRtec\XmlToCsvConverter;
use PHPUnit\Exception;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../src/CsvRow.php";
require_once __DIR__ . "/../src/XmlToCsvConverter.php";

class XmlToCsvConverterTest extends TestCase
{
    public function testCanReadInvalidUrl(): void
    {
        $converter = new XmlToCsvConverter();
        $url = "abcd://efg.hi.jk";

        try {
            $converter->readXmlFromUrl($url);
        } catch (Exception $e) {
            $this->assertEquals(
                'simplexml_load_file(): Unable to find the wrapper "abcd" - did you forget to enable it when you configured PHP?',
                $e->getMessage());
        } finally {
            $this->assertEquals(null, $converter->getExtractedXml());
        }
    }

    public function testCanReadDataFromValidXml(): void
    {
        $converter = new XmlToCsvConverter();
        $strxml = '<?xml version="1.0" encoding="UTF-8"?><rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/"><channel><item><title>title1</title><link>link1</link><dc:creator><![CDATA[creator1]]></dc:creator><pubDate>Tue, 27 Oct 2020 19:56:21 +0000</pubDate><description><![CDATA[description1]]></description></item><item><title>title2</title><link>link2</link><dc:creator><![CDATA[creator2]]></dc:creator><pubDate>Tue, 27 Oct 2020 19:56:21 +0000</pubDate><description><![CDATA[description2]]></description></item></channel></rss>';
        $xml = new SimpleXMLElement($strxml);
        try {
            $converter->setXml($xml);
            $converter->extractDataFromXml();
        } catch (Exception $e) {
            print $e->getMessage();
        } finally {
            $this->assertEquals(
                array(
                    "0" => new CsvRow("title1", "description1", "link1", "27 October 2020 19:56:21", "creator1"),
                    "1" => new CsvRow("title2", "description2", "link2", "27 October 2020 19:56:21", "creator2")
                ),
                $converter->getCsvRowData());
        }
    }

    public function testConvertDate(): void
    {
        $dateToConvert = "Tue, 27 Oct 2020 19:56:21 +0000";
        $converter = new XmlToCsvConverter();

        $convertedDate = $converter->convertDate($dateToConvert);
        $this->assertEquals("27 October 2020 19:56:21", $convertedDate);
    }

    public function testConvertDateEmpty(): void
    {
        $dateToConvert = "";
        $converter = new XmlToCsvConverter();
        $convertedDate = $converter->convertDate($dateToConvert);
        $this->assertEquals("", $convertedDate);
    }

}