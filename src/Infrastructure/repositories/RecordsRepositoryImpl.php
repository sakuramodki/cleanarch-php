<?php


namespace App\Infrastructure\repositories;


use App\Domain\Model\Record;
use App\Domain\Repositories\RecordRepository;
use PDO;

class RecordsRepositoryImpl implements RecordRepository
{
    /**
     * @var PDO $db
     */
    private $db;

    /**
     * RecordsRepositoryImpl constructor.
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @return Record[]
     */
    public function getRecords()
    {
        $statement = $this->db->query('select * from records');
        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $records = [];
        foreach ($results as $result) {
            $records[] = new Record(
                $result['title'],
                $result['url'],
                strtotime($result['release_date'])
            );
        }
        return $records;
    }
}