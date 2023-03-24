<?php 
// src/Admin/CategoryAdmin.php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserAdmin extends AbstractAdmin
{   

    public function __construct(UserPasswordHasherInterface $userPasswordHasher) {

        $this->userPasswordHasher = $userPasswordHasher;

    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('firstname', TextType::class , ["label"=>"Prénom"]);
        $form->add('lastname', TextType::class , ["label"=>"Nom"]);
        // $form->add('username', TextType::class);
        $form->add('email', TextType::class , ["label"=>"Email"]);

        if($this->getSubject()->getPassword() === NULL)
            $form->add('password', TextType::class , ['mapped' => false , 'required' => true , 'label'=>'Mot de passe'] );
        else
            $form->add('password', TextType::class , ['mapped' => false , 'required' => false , 'label'=>'Mot de passe'] );

        // $form->add('password', TextType::class);
        $form->add('roles', ChoiceType::class, [
            'choices' => [
                'ROLE_USER' => 'ROLE_USER',
                // 'ROLE_ADMIN' => 'ROLE_ADMIN',
                // 'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                'ROLE_ARTENSIA_ADMIN' => 'ROLE_SONATA_ADMIN',
            ],
            'placeholder' => 'Choisir un role.',
            'multiple' => true,
            'required' => true
        ]);
        $form->add('isActive', ChoiceType::class, [
            'choices' => [
                'Yes' => true,
                'No' => false
            ],
            'label' =>'Actif'
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('email');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->add('firstname', null , ['label'=>'Prénom'] );
        $list->add('lastname', null , ['label'=>'Nom']);
        $list->addIdentifier('email');
        $list->addIdentifier('isActive' , null , ['label'=>'Actif']);
        $list->add(ListMapper::NAME_ACTIONS, null, [
            'actions' => [
                'show' => [],
                'edit' => [],
                'delete' => [],
                // 'clone' => [
                //     'template' => '@App/CRUD/list__action_clone.html.twig',
                // ]
                ],
                'label'=>''
        ]);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('firstname', TextType::class);
        $show->add('lastname', TextType::class);
        $show->add('email');
        $show->add('isActive');
    }

    ////// ACTIONS UPDATE AND CREATE
    /// for update
    public function preUpdate(object $user) : void {

        $uniqid = $this->getRequest()->query->get('uniqid');
        // $formData = $this->getRequest()->request->get($uniqid);
        $formData = $this->getRequest()->request->all()[$uniqid];
        $password = $formData['password'];
        
        if($password != "") {
            $user->setPassword( $this->userPasswordHasher->hashPassword(
                $user,
                $password
            ));
        }
        
    }

    /// for new user creation
    public function prePersist(object $user) : void {

        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->all()[$uniqid];    
        $password = $formData['password'];
        $user->setPassword( $this->userPasswordHasher->hashPassword(
                    $user,
                    $password
        ));

    }


    public function postPersist( object $user): void {
        $this->getRequest()->getSession()->getFlashBag()->add("success", "Utilisateur créé avec succès.");
    }

    public function postUpdate( object $user): void {
        $this->getRequest()->getSession()->getFlashBag()->add("success", "Utilisateur modifié avec succès.");
    }


}