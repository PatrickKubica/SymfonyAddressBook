<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\FileUploader;

/**
 * Contact controller.
 *
 */
class ContactController extends Controller
{
    /**
     * Lists all contact entities.
     *
     * @Route("/", name="contact_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contacts = $em->getRepository('AppBundle:Contact')->findAll();

        return $this->render('contact/index.html.twig', array(
            'contacts' => $contacts,
        ));
    }

    /**
     * Creates a new contact entity.
     *
     * @Route("/new", name="contact_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, FileUploader $fileUploader)
    {
        $contact = new Contact();
        $form = $this->createForm('AppBundle\Form\ContactType', $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            /** @var UploadedFile $pictureFile */
            $pictureFile = $form->get('picture')->getData();

            //check if a picture was uploaded and process it if so
            if ($pictureFile) {
                $pictureFileName = $fileUploader->upload($pictureFile);
                //save the picture filename instead of the content
                $contact->setPicture($pictureFileName);
            }
            $em->persist($contact);
            $em->flush();

            $this->addFlash('notice', 'Contact added');
            return $this->redirectToRoute('contact_show', array('id' => $contact->getId()));
        }

        return $this->render('contact/new.html.twig', array(
            'contact' => $contact,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a contact entity.
     *
     * @Route("/{id}", name="contact_show")
     * @Method("GET")
     */
    public function showAction(Contact $contact)
    {
        return $this->render('contact/show.html.twig', array(
            'contact' => $contact,
        ));
    }

    /**
     * Displays a form to edit an existing contact entity.
     *
     * @Route("/{id}/edit", name="contact_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Contact $contact, FileUploader $fileUploader)
    {
        $editForm = $this->createForm('AppBundle\Form\ContactType', $contact);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            /** @var UploadedFile $pictureFile */
            $pictureFile = $editForm->get('picture')->getData();

            //check if a picture was uploaded and process it if so
            if ($pictureFile) {
                $pictureFileName = $fileUploader->upload($pictureFile);
                //save the picture filename instead of the content
                $contact->setPicture($pictureFileName);
            }
            $em->persist($contact);
            $em->flush();

            $this->addFlash('notice', 'Contact edited');
            return $this->redirectToRoute('contact_index');
        }

        return $this->render('contact/edit.html.twig', array(
            'contact' => $contact,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a contact entity.
     *
     * @Route("/delete/{id}", name="contact_delete")
     */
    public function deleteAction(Request $request, Contact $contact)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();

        $this->addFlash('notice', 'Contact deleted');
        return $this->redirectToRoute('contact_index');
    }
}
