<?php

namespace WebshopBundle\Controller;

use WebshopBundle\Entity\Regel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Regel controller.
 *
 * @Route("regel")
 */
class RegelController extends Controller
{
    /**
     * Lists all regel entities.
     *
     * @Route("/", name="regel_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $regels = $em->getRepository('WebshopBundle:Regel')->findAll();

        return $this->render('WebshopBundle:regel:index.html.twig', array(
            'regels' => $regels,
        ));
    }

    /**
     * Creates a new regel entity.
     *
     * @Route("/new", name="regel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $regel = new Regel();
        $form = $this->createForm('WebshopBundle\Form\RegelType', $regel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($regel);
            $em->flush();

            return $this->redirectToRoute('regel_show', array('id' => $regel->getId()));
        }

        return $this->render('WebshopBundle:regel:new.html.twig', array(
            'regel' => $regel,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a regel entity.
     *
     * @Route("/{id}", name="regel_show")
     * @Method("GET")
     */
    public function showAction(Regel $regel)
    {
        $deleteForm = $this->createDeleteForm($regel);

        return $this->render('WebshopBundle:regel:show.html.twig', array(
            'regel' => $regel,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing regel entity.
     *
     * @Route("/{id}/edit", name="regel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Regel $regel)
    {
        $deleteForm = $this->createDeleteForm($regel);
        $editForm = $this->createForm('WebshopBundle\Form\RegelType', $regel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('regel_edit', array('id' => $regel->getId()));
        }

        return $this->render('WebshopBundle:regel:edit.html.twig', array(
            'regel' => $regel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a regel entity.
     *
     * @Route("/{id}", name="regel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Regel $regel)
    {
        $form = $this->createDeleteForm($regel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($regel);
            $em->flush();
        }

        return $this->redirectToRoute('regel_index');
    }

    /**
     * Creates a form to delete a regel entity.
     *
     * @param Regel $regel The regel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Regel $regel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('regel_delete', array('id' => $regel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
