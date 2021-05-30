<?php


namespace App\Domain\Services;


use App\ClockManager;
use App\Domain\Repositories\RecordRepository;

class RecordService
{
    /**
     * @var RecordRepository $recordsRepository
     */
    private $recordsRepository;

    /**
     * @var ClockManager $clockManger
     */
    private $clockManger;

    /**
     * RecordService constructor.
     * @param RecordRepository $recordsRepository
     * @param ClockManager $clockManger
     */
    public function __construct(RecordRepository $recordsRepository, ClockManager $clockManger)
    {
        $this->recordsRepository = $recordsRepository;
        $this->clockManger = $clockManger;
    }

    public function getPublishedRecords()
    {
        $now = $this->clockManger->now();

        $publishedRecords = [];
        $records = $this->recordsRepository->getRecords();
        foreach ($records as $record) {
            if ($record->getReleaseDate() < $now) {
                $publishedRecords[] = $record;
            }
        }

        return $publishedRecords;
    }
}