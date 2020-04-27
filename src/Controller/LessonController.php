<?php

declare(strict_types=1);


namespace App\Controller;

use App\Integration\DataManagerException;
use App\Integration\DataManagerFactory;
use App\Parser\ParserException;
use App\Parser\ParserFactory;
use App\Validation\ValidationException;
use App\Validation\ValidationInterface;
use Psr\Log\LoggerInterface;
use Request;
use Response as Response;

class LessonController
{
    /** @var LoggerInterface */
    private $logger;
    /** @var ValidationInterface */
    private $validator;
    private bool $isProduction;
    private $stubMode = false;

    public function __construct(
        ValidationInterface $validator,
        LoggerInterface $logger,
        bool $isProduction
    ) {
        $this->validator = $validator;
        $this->isProduction = $isProduction;
        $this->logger = $logger;
    }


    public function action(Request $request): Response
    {
        ['category' => $category, 'type' => $type] = $request->getQuery();

        if (null === $category) {
            $message = 'You have to use at least ?category=catValue';

            return $this->createErrorResponse($message);
        }

        try {
            $this->validator->validate((string)$category);
            $dataManager = DataManagerFactory::getDataManager($this->isProduction, $this->stubMode);
            $data = $dataManager->getData('lessons', $category);
            $parser = ParserFactory::getParser($type);
            $parsed = $parser->parse($data);
        } catch (ValidationException|DataManagerException|ParserException $e) {
            return $this->createErrorResponse($e->getMessage());
        }

        return new Response($parsed);
    }

    public function setStubDataClientMode()
    {
        $this->stubMode = true;
    }

    private function createErrorResponse(string $errorMessage): Response
    {
        $this->logger->error($errorMessage);

        return new Response($errorMessage);
    }
}