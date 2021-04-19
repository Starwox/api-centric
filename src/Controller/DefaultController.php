<?php
/**
 * Created by PhpStorm.
 * User: starwox
 * Date: 15/03/2021
 * Time: 19:46
 */

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    /**
     * @Route("/test/all-users", name="get_all_users", methods={"GET"})
     * @Assert\Json(
     *     message = "You've entered an invalid Json."
     * )
     */
    public function getAllUsers(): JsonResponse
    {
        $users = $this->em->getRepository(User::class)->findAll();
        return $this->json([
            "status" => 200,
            "data" => $users
        ]);
    }

}