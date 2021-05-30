<?php


namespace App\Domain\Model;


class Record
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $url;

    /**
     * @var int
     */
    private $releaseDate;

    /**
     * Record constructor.
     * @param $title
     * @param $url
     * @param $releaseDate
     */
    public function __construct($title, $url, $releaseDate)
    {
        $this->title = $title;
        $this->url = $url;
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getReleaseDate(): int
    {
        return $this->releaseDate;
    }
}