<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Entity\User;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class AnonymousController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/api/anonymous/allSub")
     * @Rest\View(serializerGroups={"sub"})
     */
    public function getApiSub(SubscriptionRepository $subscriptionRepository)
    {
         $sub = $subscriptionRepository->findAll();
         return $this->view($sub);
    }

    /**
     * @Rest\Get("/api/anonymous/Sub/{id}")
     * @Rest\View(serializerGroups={"sub"})
     */
    public function getApiSubId(Subscription $subscription)
    {
        return $this->view($subscription);
    }

    /**
     * @Rest\Get("/api/anonymous/allUser")
     * @Rest\View(serializerGroups={"user"})
     */
    public function getApiUser(UserRepository $userRepository)
    {
        $user = $userRepository->findAll();
        return $this->view($user);
    }

    /**
     * @Rest\Get("/api/anonymous/User/{id}")
     * @Rest\View(serializerGroups={"user"})
     */
    public function getApiUserId(User $user)
    {
        return $this->view($user);
    }

    /**
     * @Rest\Post("/api/anonymous/User")
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @Rest\View(serializerGroups={"user"})
     */

    public function postApiUser(User $user, EntityManagerInterface $entityManager)
    {
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->view($user);
    }


}
