<?php


namespace App\Domain\Repositories;


use App\Domain\Model\Record;

interface RecordRepository
{
    /**
     * @return Record[]
     */
    public function getRecords();
}