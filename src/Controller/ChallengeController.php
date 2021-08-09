<?php

namespace Yrial\Simrandom\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChallengeController extends AbstractController
{
    /**
     * @Route("/challenge", name="challenge")
     */
    public function index(): Response
    {
        $challenges = $this->getParameter('generator.challenges');
        return $this->json(
            //'count' => count($challenges),
            //'details' => $challenges,
            $challenges
        );
    }
}
