<?php

namespace PortlandLabs\Concrete\Releases\Api\Controller;

use Concrete\Core\Api\ApiController;
use Doctrine\ORM\EntityManager;
use League\Fractal\Resource\Collection;
use PortlandLabs\Concrete\Releases\Api\Transformer\ConcreteReleaseTransformer;
use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;
use Symfony\Component\HttpFoundation\JsonResponse;
use Concrete\Core\Http\Request;

class ConcreteReleases extends ApiController
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(Request $request, EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($request);
    }


    /**
     * @OA\Get(
     *     path="/api/1.0/libraries/releases/concretecms",
     *     tags={"releases"},
     *     summary="Returns a list of Concrete CMS release objects.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ConcreteRelease")
     *         ),
     *     ),
     * )
     */
    public function getList()
    {
        $releases = $this->entityManager->getRepository(ConcreteRelease::class)->findAll();
        usort($releases, function($a, $b) {
            return version_compare($b->getVersionNumber(), $a->getVersionNumber());
        });
        return new Collection($releases, new ConcreteReleaseTransformer());
    }

    /**
     * @OA\Get(
     *     path="/api/1.0/libraries/releases/concretecms/{releaseId}",
     *     tags={"releases"},
     *     summary="Find a Concrete release by its ID",
     *     @OA\Parameter(
     *         name="releaseId",
     *         in="path",
     *         description="ID of Release to return",
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ConcreteRelease"),
     *     ),
     * )
     */
    public function getRelease(string $releaseId)
    {
        $release = $this->entityManager->find(ConcreteRelease::class, $releaseId);
        if ($release) {
            return $this->transform($release, new ConcreteReleaseTransformer());
        } else {
            return $this->error('Release not found', 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/1.0/libraries/releases/concretecms/getByVersionNumber/{version}",
     *     tags={"releases"},
     *     summary="Find a Concrete release by its version number",
     *     @OA\Parameter(
     *         name="version",
     *         in="path",
     *         description="Version number",
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ConcreteRelease"),
     *     ),
     * )
     */
    public function getByVersionNumber(string $version)
    {
        $release = $this->entityManager->getRepository(ConcreteRelease::class)
            ->findOneByVersionNumber($version);
        if ($release) {
            return $this->transform($release, new ConcreteReleaseTransformer());
        } else {
            return $this->error('Release not found', 404);
        }
    }

}
