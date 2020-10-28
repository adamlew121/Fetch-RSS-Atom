<?php namespace AdamLewandowskiRekrutacjaHRtec;

use DateTime;
use SimpleXMLElement;

require_once 'CsvRow.php';

class XmlToCsvConverter
{
    private ?SimpleXMLElement $xml = null;
    private array $data = array();
    private array $headers = array("title", "description", "link", "pubDate", "creator");

    public function __constructor()
    {
    }

    public function readXmlFromUrl(string $url): XmlToCsvConverter
    {
        $this->xml = simplexml_load_file($url, null, LIBXML_NOCDATA);
        return $this;
    }

    public function extractDataFromXml(): XmlToCsvConverter
    {
        $this->data = array();
        if ($this->xml->channel !== null) {
            foreach ($this->xml->channel->item as $item) {
                $title = $item->title;
                $link = $item->link;
                $description = $item->description;
                $pubDate = $this->convertDate($item->pubDate);
                // <dc:creator>
                $creator = $item->children('http://purl.org/dc/elements/1.1/')->creator;

                array_push($this->data, new CsvRow($title, $description, $link, $pubDate, $creator));
            }
        }
        return $this;
    }


    public function saveDataToCsv(string $file, bool $overrideFile): void
    {
        if ($overrideFile) {
            $file = fopen($file, "w");
            fputcsv($file, $this->headers);
        } else {
            $file = fopen($file, 'a');
        }

        foreach ($this->data as $csvRow) {
            fputcsv($file, $csvRow->toArray());
        }
    }

    public function getCsvRowData(): array
    {
        return $this->data;
    }

    public function getExtractedXml(): ?SimpleXMLElement
    {
        return $this->xml;
    }

    public function setXml(SimpleXMLElement $xml): void
    {
        $this->xml = $xml;
    }

    public function convertDate(string $date): string
    {
        $oldDateFormat = DateTime::createFromFormat(DATE_RFC2822, $date);
        return $oldDateFormat === false ? "" : $oldDateFormat->format('d F yy G:i:s');
    }

}