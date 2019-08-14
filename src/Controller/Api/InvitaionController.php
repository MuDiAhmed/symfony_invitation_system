<?php

namespace App\Controller\Api;

use App\Entity\Invitaion;
use App\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use FOS\RestBundle\Controller\Annotations as Rest;

class InvitaionController extends FOSRestController
{
    /**
     * @Rest\Get("/invitation/sent", name="api_invitaion_sent")
     */
    public function sentInvitations()
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user = $entity_manager->getRepository(User::class)->findOneBy(['email'=>$user->getEmail()]);
        $invitations = $user->getSentInvitations();
        return View::create($invitations, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/invitation/received", name="api_invitaion_received")
     */
    public function receivedInvitations()
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user = $entity_manager->getRepository(User::class)->findOneBy(['email'=>$user->getEmail()]);
        $invitations = $user->getReceivedInvitations();
        return View::create($invitations, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/invitation", name="api_invitaion_create")
     */
    public function createInvitation(ValidatorInterface $validator, Request $request)
    {
        $user = $this->getUser();
        $entity_manager = $this->getDoctrine()->getManager();
        $email = $request->get('email');
        $receiver = $entity_manager->getRepository(User::class)->findOneBy(['email'=>$email]);
        $sender = $entity_manager->getRepository(User::class)->findOneBy(['email'=>$user->getEmail()]);
        $invitation = new Invitaion();
        $invitation->setSender($sender);
        $invitation->setReceiver($receiver);
        $errors = $validator->validate($invitation);
        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }
        $entity_manager->persist($invitation);
        $entity_manager->flush();
        return View::create($invitation, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Put("/invitation/{id}", name="api_invitaion_accept_reject", requirements={"id"="\d+"})
     */
    public function acceptRejectInvitation(ValidatorInterface $validator, Request $request, Invitaion $invitation)
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $isAccept = $request->get('accept');
        $invitation->setAccept($isAccept);
        $entity_manager->persist($invitation);
        $entity_manager->flush();
        return View::create($invitation, Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/invitation/{id}", name="api_invitaion_remove", requirements={"id"="\d+"})
     */
    public function removeInvitation(ValidatorInterface $validator, Request $request, Invitaion $invitation)
    {
        $user = $this->getUser();
        if($user->getEmail() !== $invitation->getSender()->getEmail()){
            return View::create("Unauthorized", Response::HTTP_UNAUTHORIZED);
        }
        $entity_manager = $this->getDoctrine()->getManager();
        $sender = $entity_manager->getRepository(User::class)->findOneBy(['email'=>$user->getEmail()]);
        $sender->removeSentInvitation($invitation);
        $entity_manager->persist($sender);
        $entity_manager->flush();
        return View::create($invitation, Response::HTTP_OK);
    }
}
