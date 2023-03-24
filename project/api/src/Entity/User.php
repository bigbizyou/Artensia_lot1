<?php

namespace App\Entity;

use App\Controller\MeController;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
// use ApiPlatform\Core\Action\NotFoundAction;
use ApiPlatform\Action\NotFoundAction;
// use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;



use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ApiResource(
    security: 'is_granted("ROLE_USER")',
    operations: [
        new Get(
            normalizationContext: ['groups' => 'read:User'],
            name: 'me',
            uriTemplate:'/me',
            controller: MeController::class,
            read: false,
            openapiContext: [
                'security' => [['bearerAuth' => []]]
            ]
        )
        // new GetCollection(
        //     controller: NotFoundAction::class,
        //     read: false, 
        //     output: false,
        //     openapiContext: [
        //         'security' => [['bearerAuth' => []]]
        //     ]
        //     // normalizationContext: ['groups' => 'read:User']
        // )
    ],
    // // security: 'is_granted("ROLE_USER")',
    // collectionOperations: [
    //     'me' => [
    //         'pagination_enabled' => false,
    //         'path' => '/me',
    //         'method' => 'get',
    //         'controller' => MeController::class,
    //         'read' => false,
    //         'openapi_context' => [
    //             'security' => [['bearerAuth' => []]]
    //         ],
    //     ]
    // ],
    // itemOperations: [
    //     'get'
    //     // 'get' => [
    //     //     'controller' => NotFoundAction::class,
    //     //     'openapi_context' => ['summary' => 'hidden'],
    //     //     'read' => false,
    //     //     'output' => false
    //     // ]
    // ],
    // normalizationContext: [
    //     'groups' => ['read:User']
    // ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface, JWTUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:User'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:User'])]
    #[Assert\Email(
        message: 'l\'email {{ value }} n\'est pas valide.',
    )]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['read:User'])]
    private ?bool $isActive = null;

    #[ORM\Column(type: 'json')]
    #[Groups(['read:User'])]
    private $roles = [];

    #[ORM\Column(length: 255)]
    #[Groups(['read:User'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:User'])]
    private ?string $lastname = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id):self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

     /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        // $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $roles[] = 'PUBLIC_ACCESS';
        $this->roles = array_unique($roles);

        return $this;
    }

    public static function createFromPayload($identityField, array $payload)
    {
        // $username is the id
        $user = new User();
        $user->setEmail($identityField);
        $user->setRoles( $payload['roles'] );
        // $user->setEmail($payload['email']);
        // $user->setCompanyName($payload['compagnyName']);
        return $user;   
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

}
