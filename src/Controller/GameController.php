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
        $userName      = $requestObject->payload->userName;
        $userScore     = $requestObject->payload->userScore;
        $userWin       = $requestObject->payload->userWin;
        $cpuScore      = $requestObject->payload->cpuScore;

        $match = new Match();
        $match->setUserName($userName);
        $match->setUserScore($userScore);
        $match->setUserWin($userWin);
        $match->setCpuScore($cpuScore);
        $match->setCreated(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($match);
        $em->flush();

        return new Response('Match outcome successfully recorded.');;
    }
}
