<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Property;
use App\Entity\Propriete;
use App\Entity\UserNotifications;
// use Symfony\Component\Mailer\MailerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\NotificationService;
use Symfony\Bridge\Twig\Mime\NotificationEmail;

final class BienPersister implements ContextAwareDataPersisterInterface
{
    private $decorated;
    private $entityManager;
    private $mailer;
    private $notificationService;

    public function __construct(ContextAwareDataPersisterInterface $decorated,
    \Swift_Mailer $mailer,EntityManagerInterface $entityManager, NotificationService $notificationService)
    {
        $this->decorated = $decorated;
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
        $this->notificationService = $notificationService;
    }

    public function supports($data, array $context = []): bool
    {
        return $this->decorated->supports($data, $context);
    }

    public function persist($data, array $context = [])
    {
        $result = $this->decorated->persist($data, $context);
        if ($data instanceof Property && (($context['collection_operation_name'] ?? null) === 'post')) {
            $this->sendAddPropertyEmail($data);
            $this->transformData($data);
        }

        if ($data instanceof Property && (($context['item_operation_name'] ?? null) === 'put')) {
            $data->setStatus("en attente");
            $data->setIsPublished(false);
            $this->entityManager->persist($data);
            $this->entityManager->flush();
        }

        if ($data instanceof Property && (($context['item_operation_name'] ?? null) === 'patch')) {
            $this->sendResponseAdmissionEmail($data);
        }

        if ($data instanceof Propriete && (($context['collection_operation_name'] ?? null) === 'post')) {
            $this->sendOwnerEmailsAdd($data);
        }

        if ($data instanceof Propriete && (($context['item_operation_name'] ?? null) === 'put')) {
            $this->sendOwnerEmailsUpdate($data);
        }

        if ($data instanceof Propriete && (($context['item_operation_name'] ?? null) === 'delete')) {
            $this->sendOwnerEmailsDelete($data);
        }
        return $result;
    }

    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data, $context);
    }
    
    private function sendAddPropertyEmail(Property $property)
    {
        $message=(new \Swift_Message('Atypik\'House vous a envoyé une notification'))
                ->setFrom('m.manet@yopmail.com')
                ->setTo('b.derrien12@yopmail.com')
                // ->setTo($property->getUser()->getEmail())
                ->setBody('Bonjour '.$property->getUser()->getEmail().
                ' Votre bien est en cours d\'etude. Nous vous informerons
                bientot des que nous avons une reponse');
        $this->mailer->send($message);
        $this->notificationService->sendNotificationMessage($property->getUser(), 
        'Votre bien est en cours d\"etude par notre équipe');
    }

    private function sendResponseAdmissionEmail(Property $property)
    {
        $message=(new \Swift_Message($property->getUser()->getEmail().
        ' Nous avons terminé d\'examiner votre bien'))
                ->setFrom('m.manet@yopmail.com')
                ->setTo('b.derrien12@yopmail.com')
                ->setBody('Bonjour '.$property->getUser()->getEmail().' Votre bien a été '
                        .$property->getStatus().' par Atypik\'House');
        
        $this->mailer->send($message);
        $this->notificationService->sendNotificationMessage($property->getUser(), 'Votre bien a été '.$property->getStatus().' par Atypik\'House');
    }
    
    private function transformData(Property $property){
        $valeurs = $property->getValeurs();

        foreach ($valeurs as $valeur){
            if ($valeur->getPropriete()->getType() === "integer"){
                $valeur->setSavedValue(\intval($valeur->getValue()));
            }
            if ($valeur->getPropriete()->getType() === "boolean"){
                $valeur->setSavedValue(var_export($valeur->getValue(), true));
            }
            if ($valeur->getPropriete()->getType() === "string"){
                $valeur->setSavedValue($valeur->getValue());
            }
            $this->entityManager->persist($valeur);
            $this->entityManager->flush();
        }
    }

    private function sendOwnerEmailsAdd(Propriete $data){
        $properties=$data->getTypeProperty()->getProperties();
        foreach ($properties as $property){
            $this->notificationService->sendNotificationMessage($property->getUser(), 'Une nouvelle propriété a été ajouté à la catégorie '.$data->getTypeProperty()->getTitle().' par Atypik\'House');

            $message=(new \Swift_Message($property->getUser()->getEmail().
            ' Une propriété a été ajoutée à votre catégorie de biens'))
                ->setFrom('m.manet@yopmail.com')
                ->setTo($property->getUser()->getEmail())
                ->setBody('Bonjour '.$property->getUser()->getEmail().' Une propriété 
                dynamique a été ajoutée à votre catégorie de biens sur Atypik\'House');
        $this->mailer->send($message);
        }
    }

    private function sendOwnerEmailsUpdate(Propriete $data){
        $properties=$data->getTypeProperty()->getProperties();

        if ($properties !== []){
            foreach ($properties as $property){
                $this->notificationService->sendNotificationMessage($property->getUser(), 'La propriété '.$data->getName().' a été modifié par Atypik\'House');
                
                $message=(new \Swift_Message($property->getUser()->getEmail().
                ' Une propriété a été ajoutée à votre catégorie de biens'))
                    ->setFrom('m.manet@yopmail.com')
                    ->setTo($property->getUser()->getEmail())
                    ->setBody('Bonjour '.$property->getUser()->getEmail().'La propriété '.$data->getName().' a été modifié par Atypik\'House');
            $this->mailer->send($message);
            }
        }
    }

    private function sendOwnerEmailsDelete(Propriete $data){
        $properties=$data->getTypeProperty()->getProperties();

        if ($properties !== []){
            foreach ($properties as $property){
                $this->notificationService->sendNotificationMessage($property->getUser(), 'La propriété '.$data->getName().' a été supprimée par Atypik\'House');
                
                $message=(new \Swift_Message($property->getUser()->getEmail().
                ' Une propriété a été ajoutée à votre catégorie de biens'))
                    ->setFrom('m.manet@yopmail.com')
                    ->setTo($property->getUser()->getEmail())
                    ->setBody('Bonjour '.$property->getUser()->getEmail().'La propriété '.$data->getName().' a été supprimée par Atypik\'House');
            $this->mailer->send($message);
            }
        }
    }
    public function resumable(array $context = []): bool 
    {
        return true;
    }
}