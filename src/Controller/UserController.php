<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method json(array $array)
 * @method createNotFoundException(string $string)
 */
class UserController extends AbstractController
{
    private EntityManagerInterface $entityManagerInterface;

    /**
     * @Route("/users/{id}", name="get_user", methods={"GET"})
     */
    public function Get(int $id): JsonResponse
    {
        //Достать одного пользователя из бд по id
        $user = $this->entityManagerInterface->getRepository(User::class)->find($id);

        //Исключение, если нет такого id
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        return $this->json($user);
    }

    /**
     * @Route("/users", name="get_users", methods={"GET"})
     */
    public function GetCollection(): JsonResponse
    {
        //Достать всех пользователей из бд
        $users = $this->entityManagerInterface->getRepository(User::class)->findAll();

        //Возврат http кода и списка пользователей
        return $this->json([
            'users' => $users,
        ]);
    }

    /**
     * @Route("/users", name="create_users", methods={"POST"})
     */
    public function Post(Request $request): JsonResponse
    {
        //Создание нового объекта
        $user = new User();

        //Обращение к данным из тела
        $data = json_decode($request->getContent(), true);

        //Запись свойств юзера
        $user->setFirstName($data['first_name'] ?? null);
        $user->setLastName($data['last_name'] ?? null);
        $user->setUsername($data['username'] ?? null);

        //Сохранение изменений в бд
        $this->entityManagerInterface->persist($user);
        $this->entityManagerInterface->flush();

        //Возврат http кода и данных пользователя
        return $this->json([
            'message' => 'User created successfully',
            'user' => $user,
        ]);
    }

    /**
     * @Route("/users/{id}", name="delete_user", methods={"DELETE"})
     */
    public function Delete(User $user, EntityManagerInterface $entityManagerInterface): JsonResponse
    {
        $user = $this->entityManagerInterface->getRepository(User::class)->find($user);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        //Удаление данных пользователя
        $entityManagerInterface->remove($user);
        $entityManagerInterface->flush();

        return new JsonResponse(['message' => 'User deleted']);
    }

    /**
     * @Route("/users/{id}", name="update_user", methods={"PATCH"})
     */
    public function Patch(Request $request, User $user): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        //Обновление свойств юзера
        if (isset($data['FirstName'])) {
            $user->setFirstName($data['FirstName']);
        }
        if (isset($data['LastName'])) {
            $user->setLastName($data['LastName']);
        }
        if (isset($data['Username'])) {
            $user->setUsername($data['Username']);
        }

        $this->entityManagerInterface->persist($user);
        $this->entityManagerInterface->flush();

        return $this->json([
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }

    /**
     * @Route("/users/{id}", name="rewrite_user", methods={"PUT"})
     */
    public function Put(Request $request, User $user): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user->setFirstName($data['FirstName'] ?? $user->getFirstName());
        $user->setLastName($data['LastName'] ?? $user->getLastName());
        $user->setUsername($data['Username'] ?? $user->getUsername());

        $this->entityManagerInterface->persist($user);
        $this->entityManagerInterface->flush();

        return $this->json([
            'message' => 'User rewrote successfully',
            'user' => $user,
        ]);
    }

}