<?php

namespace App\Controller;

use App\Entity\Match;
use App\Repository\MatchRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller used to manage the card game
 * 
 * @Route("/game")
 */
class GameController extends AbstractController
{
    /**
     * @Route("/leaderboard", methods="GET", name="leaderboard") 
     */
    public function leaderboard(Request $request, MatchRepository $matches): Response
    {
        $results = $matches->findUserWinCount();

        return $this->json($results);
    }

    /**
     * @Route("/save", methods="POST", name="save") 
     */
    public function save(Request $request): Response
    {
        $requestJson   = $request->getContent();
        $requestObject = json_decode($requestJson);
        $validRequest  = $this->validateRequest($requestObject->payload);

        if ( ! $validRequest) {
            return new Response('Invalid match parameters.');
        }

        $match = new Match();
        $match->setUserName($requestObject->payload->userName);
        $match->setUserScore($requestObject->payload->userScore);
        $match->setUserWin($requestObject->payload->userWin);
        $match->setCpuScore($requestObject->payload->cpuScore);
        $match->setCreated(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($match);
        $em->flush();

        return new Response('Match outcome successfully recorded.');
    }

    private function validateRequest($payload) : bool
    {
        if (empty($payload->userName)) {
            return false;
        }

        if ($payload->userWin != 1 && $payload->userWin != 0) {
            return false;
        }

        if (is_null($payload->userScore) || is_null($payload->cpuScore)) {
            return false;
        }

        return true;
    }
}
