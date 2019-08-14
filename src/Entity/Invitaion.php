<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvitaionRepository")
 */
class Invitaion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="SentInvitations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ReceivedInvitations")
     * @ORM\JoinColumn(nullable=false)
     * @Serializer\SerializedName("receiver")
     */
    private $Receiver;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $accept;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?User
    {
        return $this->Receiver;
    }

    public function setReceiver(?User $Receiver): self
    {
        $this->Receiver = $Receiver;

        return $this;
    }

    public function getAccept(): ?bool
    {
        return $this->accept;
    }

    public function setAccept(?bool $accept): self
    {
        $this->accept = $accept;

        return $this;
    }
}
