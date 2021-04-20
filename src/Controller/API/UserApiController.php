<?php
/**
 * Created by PhpStorm.
 * User: starwox
 * Date: 19/04/2021
 * Time: 17:22
 */

namespace App\Controller\API;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @Route("/test", name="users_api")
 */
class UserApiController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/all-users", name="get_all_users", methods={"GET"})
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

    /**
     * @Route("/add-user", name="add_users", methods={"POST"})
     * @Assert\Json(
     *     message = "You've entered an invalid Json."
     * )
     */
    public function addUser(Request $request): JsonResponse
    {

        // DATA POST
        $email = $request->request->get('email');
        $plainPassword = $request->request->get('password');
        $job = $request->request->get('$job');
        $firstName = $request->request->get('firstName');
        $lastname = $request->request->get('lastname');
        $age = $request->request->get('age');

        // CHECKER
        if (empty($firstName)) {
            $jsonId = json_decode(file_get_contents("php://input"), true);

            $firstName = $jsonId['firstName'];
        }

        if (empty($lastname)) {
            $jsonId = json_decode(file_get_contents("php://input"), true);

            $lastname = $jsonId['lastname'];
        }

        if (empty($email)) {
            $jsonId = json_decode(file_get_contents("php://input"), true);

            $email = $jsonId['email'];
        }

        if (empty($plainPassword)) {
            $jsonId = json_decode(file_get_contents("php://input"), true);

            $plainPassword = $jsonId['password'];
        }

        if (empty($age)) {
            $jsonId = json_decode(file_get_contents("php://input"), true);

            $age = $jsonId['age'];
        }

        $options = [
            'cost' => 12,
        ];
        $password = password_hash($plainPassword, PASSWORD_BCRYPT, $options);

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setFirstname($firstName);
        $user->setLastname($lastname);
        $user->setAge($age);
        $user->setJob($job);

        $this->em->persist($user);
        $this->em->flush($user);

        $response = new JsonResponse([
            "status" => 200,
            "data" => 'success'
        ]);

        return $response;
    }

    /**
     * @Route("/delete-user/{id}", name="delete_user", methods={"GET"})
     */
    public function removeUser(User $user, $id): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(User::class);

        $user = $repository->find($id);
        if (empty($user)) {
            return $this->json([
                "status" => 400,
                "operation" => "Not found"
            ]);
        }

        $this->em->remove($user);
        $this->em->flush();


        return $this->json([
            "status" => 200,
            "operation" => "Deleted"
        ]);
    }
}