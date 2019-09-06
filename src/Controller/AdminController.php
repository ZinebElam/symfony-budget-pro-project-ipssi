<?php

namespace App\Controller;

use App\Entity\Card;
use App\Entity\Subscription;
use App\Entity\User;
use App\Repository\CardRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class AdminController extends AbstractFOSRestController
{

    /**
     * @Rest\Get("/api/admin/user")
     * @Rest\View(serializerGroups={"getUserMe"})
     */
    public function getApiAdminUserAll(UserRepository $userRepository){
        $user = $userRepository->findAll();
        return $this->view($user);
    }

    /**
     * @Rest\Get("/api/admin/user/{id}")
     * @Rest\View(serializerGroups={"getUserMe"})
     */
    public function getApiAdminUserId(User $user){
        return $this->view($user);
    }

    /**
     * @Rest\Patch("/api/admin/user/{id}")
     * @Rest\View(serializerGroups={"getUserMe"})
     */
    public function patchApiAdminUserId(User $user,EntityManagerInterface $entityManager, Request $request){
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $email = $request->get('email');
        $address = $request->get('address');
        $country = $request->get('country');
        $card = $request->get('cards');

        if($firstname !== null){
            $user->setFirstname($firstname);
        }
        if($lastname !== null){
            $user->setLastname($lastname);
        }
        if($email !== null){
            $user->setEmail($email);
        }
        if($address !== null){
            $user->setAddress($address);
        }
        if($country!== null){
            $user->setCountry($country);
        }

        $entityManager->persist($user);
        $entityManager->flush();
        return $this->view($user);
    }

    /**
     * @Rest\Delete("/api/admin/user/delete/{id}")
     * @Rest\View(serializerGroups={"getUserMe"})
     * @ParamConverter("card", converter="fos_rest.request_body")
     */
    public function apiAdminDeleteUser(User $user, Card $card ,EntityManagerInterface $entityManager){

        $entityManager->remove($user);
        $entityManager->flush();
        $user->removeCard($card);
        return $this->view($user);
    }

    /**
     * @Rest\Get("/api/admin/card")
     * @Rest\View(serializerGroups={"getUserMe"})
     */
    public function apiAdminGetCard(CardRepository $cardRepository){
        $card = $cardRepository->findAll();
        return $this->view($card);
    }

    /**
     * @Rest\Get("/api/admin/card/{id}")
     * @Rest\View(serializerGroups={"getUserMe"})
     */
    public function apiAdminGetCardId(Card $card){
        return $this->view($card);
    }
    /**
     * @Rest\Post("/api/admin/card")
     * @Rest\View(serializerGroups={"getUserMe"})
     * @ParamConverter("card", converter="fos_rest.request_body")
     */
    public function apiAdminPostCard(Card $card, EntityManagerInterface $entityManager){
        $entityManager->persist($card);
        $entityManager->flush();
        return $this->view($card);
    }

    /**
     * @Rest\Patch("/api/admin/card/{id}")
     * @Rest\View(serializerGroups={"getUserMe"})
     */
    public function apiAdminPatchCard(Request $request, Card $card, EntityManagerInterface $entityManager){
        $name = $request->get('name');
        $creditCardType = $request->get('creditCardType');
        $creditCardNumber = $request->get('creditCardNumber');
        $currencyCode = $request->get('currencyCode');
        $value = $request->get('value');


        if($name !== null){
            $card->setName($name);
        }
        if($creditCardNumber !== null){
            $card->setName($creditCardNumber);
        }
        if($creditCardType !== null){
            $card->setName($creditCardType);
        }
        if($currencyCode !== null){
            $card->setName($currencyCode);
        }
        if($value !== null){
            $card->setName($value);
        }
        $entityManager->persist($card);
        $entityManager->flush();
        return $this->view($card);
    }

    /**
     * @Rest\Delete("/api/admin/card/delete/{id}")
     * @Rest\View(serializerGroups={"getUserMe"})
     */
    public function apiAdminDeleteCard(Card $card, EntityManagerInterface $entityManager){
        $entityManager->remove($card);
        $entityManager->flush();
        return $this->view($card);
    }

    /**
     * @Rest\Get("/api/admin/subscription")
     * @Rest\View(serializerGroups={"getUserMe"})
     */
    public function apiAdminGetSubscription(SubscriptionRepository $subscription){
        $sub = $subscription->findAll();
        return $this->view($sub);
    }

    /**
     * @Rest\Get("/api/admin/subscription/{id}")
     * @Rest\View(serializerGroups={"getUserMe"})
     */
    public function apiAdminGetSubscriptionId(Subscription $subscription){
        return $this->view($subscription);
    }

    /**
     * @Rest\Post("/api/admin/subscription")
     * @Rest\View(serializerGroups={"getUserMe"})
     */
    public function apiAdminPostSubscription(EntityManagerInterface $entityManager, Subscription $subscription){
        $entityManager->persist($subscription);
        $entityManager->flush();
        return $this->view($subscription);
    }

    /**
     * @Rest\Patch("/api/admin/subscription/{id}")
     * @Rest\View(serializerGroups={"getUserMe"})
     */
    public function apiAdminPatchSubscription(Request $request, EntityManagerInterface $entityManager, Subscription $subscription){
        $name = $request->get('name');
        $slogan = $request->get('slogan');
        $url = $request->get('url');

        if($name !== null){
            $subscription->setName($name);
        }
        if($slogan !== null){
            $subscription->setSlogan($slogan);
        }
        if($url !== null){
            $subscription->setUrl($url);
        }

        $entityManager->persist($subscription);
        $entityManager->flush();
        return $this->view($subscription);
    }

    /**
     * @Rest\Delete("/api/admin/subscription/{id}")
     * @Rest\View(serializerGroups={"getUserMe"})
     */
    public function apiAdminDeleteSubscription(EntityManagerInterface $entityManager, Subscription $subscription){
        $entityManager->persist($subscription);
        $entityManager->flush();
        return $this->view($subscription);
    }
}
