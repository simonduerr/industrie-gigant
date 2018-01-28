<?php

namespace App\Controller;

use App\Enum\InfrastructureEnum;
use App\Service\ResponseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

final class InfrastructureController extends Controller
{
    public function getList(ResponseService $responseService, EntityManagerInterface $entityManager)
    {
        return $responseService->createResponseWithContent([
            InfrastructureEnum::ROAD => 'Road',
            InfrastructureEnum::RAILS => 'Rails',
            InfrastructureEnum::CROSSING => 'Crossing',
            InfrastructureEnum::BRIDGE_RAILS => 'Bridge for trains',
            InfrastructureEnum::BRIDGE_ROAD => 'Bridge for cars'
        ]);
    }
}
