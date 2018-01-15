<?php

namespace App\Controller;

use App\Entity\Building;
use App\Enum\JsonSchemaFileEnum;
use App\Service\JsonValidator;
use App\Service\ResponseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HouseController
 * @package App\Controller
 */
final class BuildingController extends Controller
{

    public function add(JsonValidator $jsonValidator, ResponseService $responseService, EntityManagerInterface $entityManager): Response
    {
        $message = '';
        $error = 0;
        $data = Request::createFromGlobals()->query->all();

        if ($jsonValidator->validateByFile(JsonSchemaFileEnum::HOUSE_ADD, $data)) {
            $validation = 1;

            $house = $entityManager->getRepository(House::class)->findOneBy(['x' => $data['x'], 'y' => $data['y']]);

            if ($house) {
                $error = 1;
                $message = 'Dieses Feld ist bereits bebaut!';
            } else {
                $house = new House();
                $house->setX($data['x']);
                $house->setY($data['y']);
                $house->setName($data['house']);

                $entityManager->persist($house);
                $entityManager->flush();

                $message = 'Das Haus wurde gebaut!';
            }
        } else {
            $validation = 0;
        }

        return $responseService->createResponseWithContent([
            'validation' => $validation,
            'error' => $error,
            'message' => $message
        ]);
    }

    public function getList(ResponseService $responseService, EntityManagerInterface $entityManager): Response
    {

        $buildings = $entityManager->getRepository(Building::class)->findAll();

        if (count($buildings) === 0) {
            $building = new Building();
            $building->setName('Haus 1');
            $building->setTerrains('0');
            $building->setCategory(0);
            $building->setPrice(0);
            $entityManager->persist($building);
            $building = new Building();
            $building->setName('Haus 2');
            $building->setTerrains('0');
            $building->setCategory(0);
            $building->setPrice(0);
            $entityManager->persist($building);
            $building = new Building();
            $building->setName('Haus 3');
            $building->setTerrains('0');
            $building->setCategory(0);
            $building->setPrice(0);
            $entityManager->persist($building);

            $entityManager->flush();
            $buildings = $entityManager->getRepository(Building::class)->findAll();
        }
        return $responseService->createResponseWithContent($buildings);
    }
}
