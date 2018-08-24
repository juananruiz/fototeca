<?php

namespace App\Controller;

use App\Entity\User\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @param userRepository $userRepository
     */
    function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * @Route("/admin/usuarios", name="admin_user_list")
     * @return Response
     */
    public function list()
    {
        $users = $this->repository->findBy(array(), array('lastName' => 'ASC'));

        return $this->render('admin/user/user_list.html.twig', array(
            "users" => $users
        ));
    }

    /**
     * @Route("/admin/usuario/grabar", name="admin_user_save")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
        $email = $request->get('email');
        $gender = $request->get('gender');
        $plainPassword = $request->get('password');
        // Editing or adding
        if ($id = $request->get('id')) {
            $user = $this->repository->find($id);
        } else {
            $user = new User();
            $user->setStartDate(new \DateTime());
        }
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->setGender($gender);
        if (strlen($plainPassword) > 3){
            $password = $passwordEncoder->encodePassword($user, $plainPassword);
            $user->setPassword($password);
        }
        $this->repository->save($user);

        return $this->redirectToRoute('admin_user_list');
    }

    /**
     * @Route("/admin/usuario/crear", name="admin_user_add")
     * @return Response
     */
    public function add()
    {

        return $this->render('admin/user/user_add.html.twig', array(
        ));
    }

    /**
     * @Route("/admin/usuario/editar/{id}", requirements={"id": "\d+"}, name="admin_user_edit")
     * @param $id User id
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->repository->find($id);

        return $this->render('admin/user/user_edit.html.twig', array(
            "user" => $user,
        ));
    }

    /**
     * @Route("/admin/usuario/borrar/{id}", requirements={"id": "\d+"}, name="admin_user_delete")
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Request $request)
    {
        $id = $request->get('id');
        /** @var User $user */
        $user = $this->repository->find($id);
        $this->repository->delete($user);

        return $this->redirectToRoute('admin_user_list');
    }
}
