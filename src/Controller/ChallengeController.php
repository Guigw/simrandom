<?php

namespace Yrial\Simrandom\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChallengeController extends AbstractController
{
    /**
     * @Route("/challenge", name="challenge")
     */
    public function index(): Response
    {
        $challenges = array_map(function ($challenge) {
            return ['id' => $challenge['id'], 'name' => $challenge['name'], 'count' => count($challenge['randomizers'])];
        }, $this->getParameter('generator.challenges'));
        return $this->json(
            $challenges
        );
    }

    /**
     * @Route ("/challenge/{id}", name="challenge_randomizers")
     * @param int $id
     * @return Response
     */
    public function getRandomizerList(int $id): Response
    {
        $response = array_filter($this->getParameter('generator.challenges'), function ($challenge) use ($id) {
            return $challenge['id'] == $id;
        });
        if (empty($response)) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
        return $this->json($response[0]);
    }
}
