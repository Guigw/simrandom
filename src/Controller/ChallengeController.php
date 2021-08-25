<?php

namespace Yrial\Simrandom\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Yrial\Simrandom\Entity\SavedChallenge;
use Yrial\Simrandom\Form\ResultListDTO;
use Yrial\Simrandom\Form\Type\ResultList;
use Yrial\Simrandom\Repository\RandomizerResultRepository;
use Yrial\Simrandom\Repository\SavedChallengeRepository;

class ChallengeController extends AbstractController
{
    private $savedChallengeRepository;

    public function __construct(SavedChallengeRepository $savedChallengeRepository)
    {
        $this->savedChallengeRepository = $savedChallengeRepository;
    }

    /**
     * @Route("/challenge", name="challenge", methods={"GET"})
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
     * @Route ("/challenge/{id}", name="challenge_randomizers", requirements={"page"="\d+"}, methods={"GET"})
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

    /**
     * @Route ("/challenge/save", name="challenge_save", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function saveChallenge(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(ResultList::class);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ResultListDTO $data */
            $data = $form->getData();
            $results = $data->getResultList();
            $challenge = $this->savedChallengeRepository->saveChallenge($data->getName());
            $this->savedChallengeRepository->finishedChallenge($results, $challenge);
            return $this->json(['id' => $challenge->getId()], Response::HTTP_CREATED);
        } else {
            return new JsonResponse(['message' => $form->getErrors()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route ("/challenge/{id}/results", name="get_saved_challenge", methods={"GET"})
     * @ParamConverter("challenge", class="YrialSimrandomBundle:SavedChallenge")
     * @param SavedChallenge $challenge
     * @return Response
     */
    public function findSavedChallenge(SavedChallenge $challenge): Response
    {
        $result = [];
        $result['id'] = $challenge->getId();
        $result['name'] = $challenge->getName();
        $result['count'] = count($challenge->getResults());
        $result['randomizers'] = [];
        foreach ($challenge->getResults() as $randomizer) {
            $random = [];
            $random['id'] = $randomizer->getId();
            $random['title'] = $randomizer->getName();
            $random['result'] = $randomizer->getResult();
            $result['randomizers'][] = $random;
        }
        return $this->json($result);
    }

}
