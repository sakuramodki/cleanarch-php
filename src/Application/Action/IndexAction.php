<?php


namespace App\Application\Action;


use App\Domain\Services\RecordService;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class IndexAction
{
    /**
     * @var RecordService
     */
    private $recordService;

    /**
     * @var Twig
     */
    private $tiwg;

    /**
     * IndexAction constructor.
     * @param RecordService $recordService
     * @param Twig $tiwg
     */
    public function __construct(RecordService $recordService, \Slim\Views\Twig $tiwg)
    {
        $this->recordService = $recordService;
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
        $data = $this->recordService->getPublishedRecords();
        $params = [
            'records' => $data,
        ];

        return $this->tiwg->render($response, 'index.twig', $params);
    }
}