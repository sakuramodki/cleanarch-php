<?php


namespace App\Application\Action;


use App\Domain\Model\Record;
use App\Domain\Services\RecordService;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class DirtyIndexAction
{
    /**
     * @var PDO $db
     */
    private $db;

    /**
     * @var Twig
     */
    private $tiwg;

    /**
     * DirtyIndexAction constructor.
     * @param PDO $db
     * @param Twig $tiwg
     */
    public function __construct(PDO $db, Twig $tiwg)
    {
        $this->db = $db;
        $this->tiwg = $tiwg;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(Request $request, Response $response)
    {
        $records = $this->getRecords();
        $params = [
            'records' => $records
        ];

        return $this->tiwg->render($response, 'index.twig', $params);
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