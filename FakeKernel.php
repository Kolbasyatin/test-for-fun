<?php

declare(strict_types=1);


use App\Controller\LessonController;
use App\Validation\Validator;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class FakeKernel
{

    private $isProduction;

    public function __construct(bool $isProduction = false)
    {
        $this->isProduction = $isProduction;
    }

    public function handle(Request $request): Response
    {
        $validator = new Validator();
        $logger = new Logger('test');
        $logger->pushHandler(new StreamHandler('/tmp/test.log', Logger::INFO));
        $controller = new LessonController(
            $validator,
            $logger,
            $this->isProduction
        );
        $stubMode = $request->getQuery()['stub'] ?? null;
        if ('true' === $stubMode) {
            $controller->setStubDataClientMode();
        }

        try {
            $response = $controller->action($request);
        } catch (Throwable $e) {
            $logger->critical($e->getMessage());
            $response = new Response($e->getMessage());
        }

        return $response;
    }
}