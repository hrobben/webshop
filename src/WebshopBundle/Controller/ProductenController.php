<?php

namespace WebshopBundle\Controller;

use Symfony\Component\HttpFoundation\File\File;
use WebshopBundle\Entity\Producten;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Producten controller.
 *
 * @Route("producten")
 */
class ProductenController extends Controller
{
    /**
     * Lists all producten entities.
     *
     * @Route("/", name="producten_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $productens = $em->getRepository('WebshopBundle:Producten')->findAll();

        return $this->render('@Webshop/producten/index.html.twig', array(
            'productens' => $productens,
        ));
    }

    /**
     * Creates a new producten entity.
     *
     * @Route("/new", name="producten_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $producten = new Producten();
        $form = $this->createForm('WebshopBundle\Form\ProductenType', $producten);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $producten->getImagepath();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $producten->setImagepath($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($producten);
            $em->flush();

            return $this->redirectToRoute('producten_show', array('id' => $producten->getId()));
        }

        return $this->render('@Webshop/producten/new.html.twig', array(
            'producten' => $producten,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a producten entity.
     *
     * @Route("/{id}", name="producten_show")
     * @Method("GET")
     */
    public function showAction(Producten $producten)
    {
        $deleteForm = $this->createDeleteForm($producten);

        return $this->render('@Webshop/producten/show.html.twig', array(
            'producten' => $producten,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing producten entity.
     *
     * @Route("/{id}/edit", name="producten_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Producten $producten)
    {
        $deleteForm = $this->createDeleteForm($producten);
        $editForm = $this->createForm('WebshopBundle\Form\ProductenType', $producten);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $producten->setImagepath(
                new File($this->getParameter('images_directory').'/'.$producten->getImagepath())
            );
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $producten->getImagepath();

/*            if ($file) {
                unlink($file);
            }*/

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $producten->setImagepath($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('producten_edit', array('id' => $producten->getId()));
        }

        return $this->render('@Webshop/producten/edit.html.twig', array(
            'producten' => $producten,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a producten entity.
     *
     * @Route("/{id}", name="producten_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Producten $producten)
    {
        $form = $this->createDeleteForm($producten);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $producten->getImagepath();

            $filename = $this->getParameter('images_directory').'/'.$file;
            if ($filename) {
                unlink($filename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->remove($producten);
            $em->flush();
        }

        return $this->redirectToRoute('producten_index');
    }

    /**
     * Creates a form to delete a producten entity.
     *
     * @param Producten $producten The producten entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Producten $producten)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('producten_delete', array('id' => $producten->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
