<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Person;
use AppBundle\Form\PersonType;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

/**
 * Person controller.
 *
 * @Route("/person")
 */
class PersonController extends Controller
{

    /**
     * Lists all Person entities.
     *
     * @Route("/", name="person")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Person')->createQueryBuilder("p")->getQuery()->getArrayResult();


        // $query = $em->createQuery("
        //     SELECT p FROM AppBundle:Person p
        // ")->getArrayResult();





        return new JsonResponse($entities);
    }
    /**
     * Creates a new Person entity.
     *
     * @Route("/", name="person_create")
     * @Method("POST")
     * @Template("AppBundle:Person:new.html.twig")
     */
    public function createAction(Request $request)
    {

        $entity = new Person();
        $entity->setName($request->request->get('name'));
        $entity->setLastName($request->request->get('last_name'));
        $entity->setBirthDate(new \DateTime($request->request->get('birthdate')));

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);

        $em->flush();

        return $this->showAction($entity->getId());

        // return $this->redirect($this->generateUrl('person_show', array('id' => $entity->getId())));


        // return array(
        //     'entity' => $entity,
        //     'form'   => $form->createView(),
        // );
    }

    /**
     * Creates a form to create a Person entity.
     *
     * @param Person $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Person $entity)
    {
        $form = $this->createForm(new PersonType(), $entity, array(
            'action' => $this->generateUrl('person_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Person entity.
     *
     * @Route("/new", name="person_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Person();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Person entity.
     *
     * @Route("/{id}", name="person_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery("SELECT p FROM AppBundle:Person p where p.id = $id")->getArrayResult();
        // if (!$query) {
        //     throw $this->createNotFoundException('Unable to find Person entity.');
        //  }
        return new JsonResponse($query);
        /*  
        $entity = $em->getRepository('AppBundle:Person')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $query,
            'delete_form' => $deleteForm->createView(),
        );
        */
    }

    /**
     * Displays a form to edit an existing Person entity.
     *
     * @Route("/{id}/edit", name="person_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();



        $entity = $em->getRepository('AppBundle:Person')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Person entity.
     *
     * @param Person $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Person $entity)
    {
        $form = $this->createForm(new PersonType(), $entity, array(
            'action' => $this->generateUrl('person_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Person entity.
     *
     * @Route("/{id}", name="person_update")
     * @Method("PUT")
     * @Template("AppBundle:Person:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Person')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }
        $name = $request->request->get('name');
        $last_name = $request->request->get('last_name');
        $birth_date = new \DateTime($request->request->get('birth_date'));

        $entity->setName($name);
        $entity->setLastName($last_name);
        $entity->setBirthDate($birth_date);
        $em->flush();

        return new JsonResponse($entity);
    }
    /**
     * Deletes a Person entity.
     *
     * @Route("/{id}", name="person_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Person')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $em->remove($entity);
        $em->flush();

        return new JsonResponse($entity);
    }

    /**
     * Creates a form to delete a Person entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('person_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
