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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $data = new User();
        $data->setActive(1);
        $data->setEmail("test@test");
        $data->setPassword("test");
        $data->setRoles(["role"]);
        $data->setStartedAt(new \DateTime("now"));

        return $this->render('base.html.twig');
    }

}