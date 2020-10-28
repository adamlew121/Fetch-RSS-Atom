<?php namespace AdamLewandowskiRekrutacjaHRtec;

class CsvRow
{
    public string $title, $description, $link, $pubDate, $creator;

    function __construct(string $title, string $description, string $link, string $pubDate, string $creator)
    {
        $this->title = $title;
        $this->description = $description;
        $this->link = $link;
        $this->pubDate = $pubDate;
        $this->creator = $creator;
    }

    function toArray(): array
    {
        return
            array(
                "title" => $this->title,
                "description" => $this->description,
                "link" => $this->link,
                "pubDate" => $this->pubDate,
                "creator" => $this->creator
            );
    }

}