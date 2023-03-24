<?php

namespace App\Entity;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use App\Controller\UserController;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    operations:
    [
        new Get(uriTemplate:'/users/{id}',
            controller: UserController::class,
            name:'get_user'),
        new GetCollection(uriTemplate:'/users',
            controller: UserController::class,
            name:'get_users'),
        new Post(uriTemplate:'/users/{id}',
            controller: UserController::class,
            name:'create_users'),
        new Delete(uriTemplate:'/users/{id}',
            controller: UserController::class,
            name:'delete_user'),
        new Patch(uriTemplate:'/users/{id}',
            controller: UserController::class,
            name:'update_user'),
        new Put(uriTemplate:'/users/{id}',
            controller: UserController::class,
            name:'rewrite_user')
    ])]

/** A user
 * @ORM\Entity
 */
class User
{
    /** The id of the user
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /** The username of the user
     *
     * @ORM\Column(type="string", length=40, options={"fixed" = false}, unique=true)
     */
    private string $username;

    /** The first_name of the user
     *
     * @ORM\Column(type="string", length=20, options={"fixed" = false})
     */
    private string $first_name;

    /** The last_name of the user
     *
     * @ORM\Column(type="string", length=20, options={"fixed" = false})
     */
    private string $last_name;

    /**
     * @return int|null
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }
}