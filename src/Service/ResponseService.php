<?php

namespace App\Service;

use App\Enum\StatusEnum;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

final class ResponseService
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function createResponseWithContent(array $content): Response
    {
        $response = $this->createEmptyResponse();
        $response->setContent($this->serializer->serialize($content, 'json'));
        return $response;
    }

    public function createStatusResponse($code = StatusEnum::GENERAL_OTHER, string $message = ''): Response
    {
        return $this->createResponseWithContent(['code' => $code, 'message' => $message]);
    }

    private function createEmptyResponse(): Response
    {
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
}