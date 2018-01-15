<?php

namespace App\Controller;

use App\Entity\Building;
use App\Entity\BuiltObject;
use App\Entity\House;
use App\Entity\Tile;
use App\Enum\BuildingTypeEnum;
use App\Enum\StatusEnum;
use App\Enum\JsonSchemaFileEnum;
use App\Service\JsonValidator;
use App\Service\ResponseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

final class BuiltObjectController extends Controller
{
    public function getList(ResponseService $responseService, EntityManagerInterface $entityManager)
    {
        $builtObjects = $entityManager->getRepository(BuiltObject::class)->findAll();

        return $responseService->createResponseWithContent($builtObjects);
    }

    public function destroy(
        int $builtObjId,
        ResponseService $responseService,
        EntityManagerInterface $entityManager
    ) {
        $builtObject = $entityManager->getRepository(BuiltObject::class)->find($builtObjId);

        if (!$builtObject) {
            return $responseService->createStatusResponse(StatusEnum::BUILT_OBJ_NOT_FOUND);
        }

        $tiles = $entityManager->getRepository(Tile::class)->findBy(['built_object' => $builtObject->getId()]);
        foreach($tiles as $tile) {
            $tile->setBuiltObject(null);
            $entityManager->persist($tile);
        }

        $entityManager->remove($builtObject);
        $entityManager->flush();

        return $responseService->createStatusResponse(StatusEnum::GENERAL_SUCCESS);
    }
}
