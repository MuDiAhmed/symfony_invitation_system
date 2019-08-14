<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, JWTUserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Invitaion", mappedBy="sender", orphanRemoval=true)
     * @Serializer\SerializedName("sent_invitations")
     */
    private $SentInvitations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Invitaion", mappedBy="Receiver", orphanRemoval=true)
     * @Serializer\SerializedName("receiver_invitations")
     */
    private $ReceivedInvitations;

    public function __construct($email = null, array $roles = [])
    {
        $this->email = $email;
        $this->roles = $roles;
        $this->SentInvitations = new ArrayCollection();
        $this->ReceivedInvitations = new ArrayCollection();
    }

    public static function createFromPayload($username, array $payload)
    {
        return new self(
            $username,
            $payload['roles']
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|Invitaion[]
     */
    public function getSentInvitations(): Collection
    {
        return $this->SentInvitations;
    }

    public function addSentInvitation(Invitaion $sentInvitation): self
    {
        if (!$this->SentInvitations->contains($sentInvitation)) {
            $this->SentInvitations[] = $sentInvitation;
            $sentInvitation->setSender($this);
        }

        return $this;
    }

    public function removeSentInvitation(Invitaion $sentInvitation): self
    {
        if ($this->SentInvitations->contains($sentInvitation)) {
            $this->SentInvitations->removeElement($sentInvitation);
            // set the owning side to null (unless already changed)
            if ($sentInvitation->getSender() === $this) {
                $sentInvitation->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Invitaion[]
     */
    public function getReceivedInvitations(): Collection
    {
        return $this->ReceivedInvitations;
    }

    public function addReceivedInvitation(Invitaion $receivedInvitation): self
    {
        if (!$this->ReceivedInvitations->contains($receivedInvitation)) {
            $this->ReceivedInvitations[] = $receivedInvitation;
            $receivedInvitation->setReceiver($this);
        }

        return $this;
    }

    public function removeReceivedInvitation(Invitaion $receivedInvitation): self
    {
        if ($this->ReceivedInvitations->contains($receivedInvitation)) {
            $this->ReceivedInvitations->removeElement($receivedInvitation);
            // set the owning side to null (unless already changed)
            if ($receivedInvitation->getReceiver() === $this) {
                $receivedInvitation->setReceiver(null);
            }
        }

        return $this;
    }
}
