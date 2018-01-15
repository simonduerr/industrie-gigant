<?php

namespace App\Controller;

use App\Entity\Building;
use App\Entity\BuiltObject;
use App\Entity\House;
use App\Entity\Tile;
use App\Enum\BuildingTypeEnum;
use App\Enum\InfrastructureEnum;
use App\Enum\JsonSchemaFileEnum;
use App\Enum\StatusEnum;
use App\Service\JsonValidator;
use App\Service\ResponseService;
use Doctrine\ORM\EntityManagerInterface;
use const Grpc\STATUS_CANCELLED;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

final class TileController extends Controller
{
    public function getList(ResponseService $responseService, EntityManagerInterface $entityManager)
    {
        $tiles = $entityManager->getRepository(Tile::class)->findAll();

        if (count($tiles) === 0) {
            for ($y = 1; $y <= 5; $y++) {
                for ($x = 1; $x <= 5; $x++) {
                    $tile = new Tile();
                    $tile->setX($x);
                    $tile->setY($y);
                    $entityManager->persist($tile);
                }
            }
            $entityManager->flush();
            $tiles = $entityManager->getRepository(Tile::class)->findAll();
        }
        return $responseService->createResponseWithContent($tiles);
    }

    public function addBuilding(
        int $tileId,
        int $buildingId,
        ResponseService $responseService,
        EntityManagerInterface $entityManager
    ) {
        $tile = $entityManager->getRepository(Tile::class)->find($tileId);
        if (!$tile) {
            return $responseService->createStatusResponse(StatusEnum::TILE_NOT_FOUND);
        }
        if ($tile->getBuiltObject() !== null) {
            return $responseService->createStatusResponse(StatusEnum::TILE_NOT_EMPTY);
        }

        $building = $entityManager->getRepository(Building::class)->find($buildingId);
        if (!$building) {
            return $responseService->createStatusResponse(StatusEnum::BUILDING_NOT_FOUND);
        }

        $builtObject = new BuiltObject();
        $builtObject->setLevel(0);
        $builtObject->setObject($building->getId());
        $builtObject->setType(BuildingTypeEnum::CATALOG);
        $entityManager->persist($builtObject);
        $entityManager->flush();

        $tile->setBuiltObject($builtObject->getId());
        $entityManager->persist($building);
        $entityManager->flush();

        return $responseService->createResponseWithContent([$builtObject]);
    }

    public function addInfrastructure(
        int $tileId,
        int $infrastructureId,
        ResponseService $responseService,
        EntityManagerInterface $entityManager
    ) {
        if (!in_array($infrastructureId, [
            InfrastructureEnum::ROAD,
            InfrastructureEnum::RAILS,
            InfrastructureEnum::CROSSING,
            InfrastructureEnum::BRIDGE_RAILS,
            InfrastructureEnum::BRIDGE_ROAD
        ])) {
            return $responseService->createStatusResponse(StatusEnum::GENERAL_INVALID_REQUEST);
        }

        $tile = $entityManager->getRepository(Tile::class)->find($tileId);
        if (!$tile) {
            return $responseService->createStatusResponse(StatusEnum::TILE_NOT_FOUND);
        }
        if ($tile->getBuiltObject() !== null || $tile->getInfrastructure() !== null) {
            return $responseService->createStatusResponse(StatusEnum::TILE_NOT_EMPTY);
        }

        $tile->setInfrastructure($infrastructureId);
        $entityManager->persist($tile);
        $entityManager->flush();

        return $responseService->createResponseWithContent([$tile]);
    }

    public function addInfrastructureMultiple(
        ResponseService $responseService,
        EntityManagerInterface $entityManager,
        JsonValidator $jsonValidator
    ) {
        $data = Request::createFromGlobals()->query->all();
        if (false === $jsonValidator->validateByFile(JsonSchemaFileEnum::INFRA_ADD_MULTIPLE, $data)) {
            return $responseService->createResponseWithContent($data);
            return $responseService->createStatusResponse(StatusEnum::GENERAL_INVALID_REQUEST);
        }

        $tilesResponse = [];
        foreach ($data['tiles'] as $tile) {
            $tile_id = $tile['tileId'];
            $infrastructureId = $tile['infraId'];

            if (!in_array($infrastructureId, [
                InfrastructureEnum::ROAD,
                InfrastructureEnum::RAILS,
                InfrastructureEnum::CROSSING,
                InfrastructureEnum::BRIDGE_RAILS,
                InfrastructureEnum::BRIDGE_ROAD
            ])) {
                $tilesResponse[$tile_id]['code'] = StatusEnum::GENERAL_INVALID_REQUEST;
            } else {
                $tile = $entityManager->getRepository(Tile::class)->find($tile_id);
                if (!$tile) {
                    $tilesResponse[$tile_id]['code'] = StatusEnum::TILE_NOT_FOUND;
                } elseif ($tile->getBuiltObject() !== null || $tile->getInfrastructure() !== null) {
                    $tilesResponse[$tile_id]['code'] = StatusEnum::TILE_NOT_EMPTY;
                } else {
                    $tile->setInfrastructure($infrastructureId);
                    $entityManager->persist($tile);
                    $tilesResponse[$tile_id]['code'] = StatusEnum::GENERAL_SUCCESS;
                }
            }
        }
        $entityManager->flush();

        return $responseService->createResponseWithContent($tilesResponse);
    }
}
