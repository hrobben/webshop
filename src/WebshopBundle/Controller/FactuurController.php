<?php

namespace WebshopBundle\Controller;

use WebshopBundle\Entity\Factuur;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use WebshopBundle\Entity\Producten;
use WebshopBundle\Entity\Regel;

/**
 * Factuur controller.
 *
 * @Route("factuur")
 */
class FactuurController extends Controller
{
    /**
     * Lists all factuur entities.
     *
     * @Route("/", name="factuur_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $factuurs = $em->getRepository('WebshopBundle:Factuur')->findAll();
        } else {
            $factuurs = $em->getRepository('WebshopBundle:Factuur')->findBy(['klantId' => $this->getUser()]);
        }

        return $this->render('WebshopBundle:factuur:index.html.twig', array(
            'factuurs' => $factuurs,
        ));
    }

    /**
     * Creates a new factuur entity.
     *
     * @Route("/new", name="factuur_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $factuur = new Factuur();
        $factuur->setDatum(new \DateTime("now"));
        $form = $this->createForm('WebshopBundle\Form\FactuurType', $factuur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($factuur);
            $em->flush();

            return $this->redirectToRoute('factuur_show', array('id' => $factuur->getId()));
        }

        return $this->render('WebshopBundle:factuur:new.html.twig', array(
            'factuur' => $factuur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a factuur entity.
     *
     * @Route("/{id}", name="factuur_show")
     * @Method("GET")
     */
    public function showAction(Factuur $factuur)
    {
        $em = $this->getDoctrine()->getManager();

        $regels = $em->getRepository('WebshopBundle:Regel')->findby(['factuurId' => $factuur->getId()]);
        $products = $em->getRepository(Producten::class)->findall();

        // dump($regels);
        $deleteForm = $this->createDeleteForm($factuur);

        return $this->render('WebshopBundle:factuur:show.html.twig', array(
            'factuur' => $factuur,
            'products' => $products,
            'regels' => $regels,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing factuur entity.
     *
     * @Route("/{id}/edit", name="factuur_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Factuur $factuur)
    {
        $em = $this->getDoctrine()->getManager();
        $regels = $em->getRepository(Regel::class)->findby(['factuurId' => $factuur->getId()]);
        $products = $em->getRepository(Producten::class)->findall();

        $factuur->setRegels($regels);

        $deleteForm = $this->createDeleteForm($factuur);
        $editForm = $this->createForm('WebshopBundle\Form\FactuurType', $factuur);
        $previousCollections = array(
            'regels' => $factuur->getRegels(),
        );
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->deleteCollections($em, $previousCollections, $factuur);

            // put in collection of forms items
            foreach ($factuur->getRegels() as $regel) {
                $em->persist($regel);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('factuur_edit', array('id' => $factuur->getId()));
        }

        return $this->render('WebshopBundle:factuur:edit.html.twig', array(
            'factuur' => $factuur,
            'products' => $products,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * to remove collection of forms items
     * @param $em
     * @param $init
     * @param $final
     */
    private function deleteCollections($em, $init, $final)
    {
        if (empty($init)) {
            return;
        }

        if (!$final->getRegels() instanceof \Doctrine\ORM\PersistentCollection) {
            foreach ($init['regels'] as $addr) {
                $em->remove($addr);
            }
        }
    }

    /**
     * Deletes a factuur entity.
     *
     * @Route("/{id}", name="factuur_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Factuur $factuur)
    {
        $form = $this->createDeleteForm($factuur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($factuur);
            $em->flush();
        }

        return $this->redirectToRoute('factuur_index');
    }

    /**
     * Creates a form to delete a factuur entity.
     *
     * @param Factuur $factuur The factuur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Factuur $factuur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('factuur_delete', array('id' => $factuur->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
