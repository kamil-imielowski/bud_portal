<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 28.03.2018
 * Time: 03:07
 */

namespace AppBundle\Controller;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Swift_Mailer;
use Swift_SmtpTransport;


class NewsletterAdminController extends  BaseAdminController
{
    protected function newAction()
    {
        $this->dispatch(EasyAdminEvents::PRE_NEW);

        $entity = $this->executeDynamicMethod('createNew<EntityName>Entity');

        $easyadmin = $this->request->attributes->get('easyadmin');
        $easyadmin['item'] = $entity;
        $this->request->attributes->set('easyadmin', $easyadmin);

        $fields = $this->entity['new']['fields'];

        $newForm = $this->executeDynamicMethod('create<EntityName>NewForm', array($entity, $fields));

        $newForm->handleRequest($this->request);
        if ($newForm->isSubmitted() && $newForm->isValid()) {
            $this->dispatch(EasyAdminEvents::PRE_PERSIST, array('entity' => $entity));

            $this->executeDynamicMethod('prePersist<EntityName>Entity', array($entity));
            $this->executeDynamicMethod('persist<EntityName>Entity', array($entity));

            $this->dispatch(EasyAdminEvents::POST_PERSIST, array('entity' => $entity));

            //wysłanie e-mailow
            //$mailer = $this->container->get("swiftmailer.mailer");

            $emails = ['kamil@imielowski.pl', "toma4wow@wp.pl"];

            foreach ($emails as $email){
//                $message = (new \Swift_Message('Hello Email'))
//                    ->setFrom('send@example.com')
//                    ->setTo($email)
//                    ->setBody(
//                        $this->renderView(
//                            'emails/newsletter.html.twig',
//                            array('name' => $email)
//                        ),
//                        'text/html'
//                    );
//
//
//                $mailer->send($message);
                $message = \Swift_Message::newInstance(null)
                    ->setSubject($entity->getTitle())
                    ->setFrom($this->container->getParameter("newsletter_email"))
                    ->setTo($email)
                    ->setBody($entity->getContent(), 'text/html')
//                    ->setBody(
//                        $this->renderView(
//                            'emails/newsletter.html.twig',
//                            array('name' => $email)
//                        ), 'text/html'
//                    )
                ;
                $this->get('mailer')->send($message);
            }

            return $this->redirectToReferrer();
        }

        $this->dispatch(EasyAdminEvents::POST_NEW, array(
            'entity_fields' => $fields,
            'form' => $newForm,
            'entity' => $entity,
        ));

        $parameters = array(
            'form' => $newForm->createView(),
            'entity_fields' => $fields,
            'entity' => $entity,
        );

        return $this->executeDynamicMethod('render<EntityName>Template', array('new', $this->entity['templates']['new'], $parameters));
    }
}