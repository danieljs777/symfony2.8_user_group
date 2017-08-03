<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserGroup;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Usergroup controller.
 *
 * @Route("group")
 */
class UserGroupController extends Controller
{
    /**
     * Lists all userGroup entities.
     *
     * @Route("/", name="group_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userGroups = $em->getRepository('AppBundle:UserGroup')->findAll();

        return $this->render('usergroup/index.html.twig', array(
            'userGroups' => $userGroups,
        ));
    }

    /**
     * Creates a new userGroup entity.
     *
     * @Route("/new", name="group_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userGroup = new Usergroup();
        $form = $this->createForm('AppBundle\Form\UserGroupType', $userGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($userGroup);
            $em->flush();

            return $this->redirectToRoute('group_show', array('id' => $userGroup->getId()));
        }

        return $this->render('usergroup/new.html.twig', array(
            'userGroup' => $userGroup,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a userGroup entity.
     *
     * @Route("/{id}", name="group_show")
     * @Method("GET")
     */
    public function showAction(UserGroup $userGroup)
    {
        $deleteForm = $this->createDeleteForm($userGroup);

        return $this->render('usergroup/show.html.twig', array(
            'userGroup' => $userGroup,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userGroup entity.
     *
     * @Route("/{id}/edit", name="group_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserGroup $userGroup)
    {
        $deleteForm = $this->createDeleteForm($userGroup);
        $editForm = $this->createForm('AppBundle\Form\UserGroupType', $userGroup);
        $editForm->handleRequest($request);
       
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entity = $editForm->getData(); 
            $this->getDoctrine()->getManager()->persist($entity);            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('group_edit', array('id' => $userGroup->getId()));
        }

        return $this->render('usergroup/edit.html.twig', array(
            'userGroup' => $userGroup,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userGroup entity.
     *
     * @Route("/{id}", name="group_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserGroup $userGroup)
    {
        $this->get('session')->getFlashBag()->clear();
        
        $form = $this->createDeleteForm($userGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && sizeof($userGroup->getUsers()) == 0) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userGroup);
            $em->flush();
        }
        
        if(sizeof($userGroup->getUsers()) > 0)
            $this->addFlash('error', 'This group has related users, it can\'t be removed');

        return $this->redirectToRoute('group_index');
    }

    /**
     * Creates a form to delete a userGroup entity.
     *
     * @param UserGroup $userGroup The userGroup entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserGroup $userGroup)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('group_delete', array('id' => $userGroup->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    public function getGroupAction($id = "")
    {} // "get_group"   [GET] /group/{$id}
    
    public function createGroupAction()
    {} // "create_group"   [POST] /group/
    
    public function updateGroupAction($id)
    {} // "update_group"   [PUT] /group/{$id}
    
    public function deleteGroupAction($id)
    {} // "delete_group"   [DELETE] /group/{$id}
    
    public function addUserGroupAction($groupid, $userid)
    {} // "add_user_group"   [POST] /group/{$groupid}/add_user_group/{userid}
    
    public function deleteUserFromGroupAction($groupid, $userid)
    {} // "delete_user_group"   [DELETE] /group/{$groupid}/delete_user/{userid}
    
}
