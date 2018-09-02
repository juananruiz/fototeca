<?php

namespace App\Controller;

use App\Entity\Image\Medium;
use App\Repository\MediumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MediumController extends AbstractController
{
    /**
     * @var MediumRepository
     */
    protected $repository;

    /**
     * @param mediumRepository $mediumRepository
     */
    function __construct(MediumRepository $mediumRepository)
    {
        $this->repository = $mediumRepository;
    }

    /**
     * @Route("/admin/medios", name="admin_medium_list")
     * @return Response
     */
    public function list()
    {
        $criteria = array();
        $orderBy = array('name' => 'ASC');

        $mediums = $this->repository->findBy($criteria, $orderBy);

        return $this->render('admin/medium/medium_list.html.twig', array(
            "mediums" => $mediums
        ));
    }

    /**
     * @Route("/admin/medio/grabar", name="admin_medium_save")
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Request $request)
    {
        $name = $request->get('name');
        // Editing or adding
        if ($id = $request->get('id')) {
            $medium = $this->repository->find($id);
        } else {
            $medium = new Medium();
        }
        $medium->setName($name);
        $this->repository->save($medium);

        return $this->redirectToRoute('admin_medium_list');
    }

    /**
     * @Route("/admin/medio/crear", name="admin_medium_add")
     * @return Response
     */
    public function add()
    {
        return $this->render('admin/medium/medium_add.html.twig');
    }

    /**
     * @Route("/admin/medio/editar/{id}", requirements={"id": "\d+"}, name="admin_medium_edit")
     * @param $id Medium id
     * @return Response
     */
    public function edit($id)
    {
        $medium = $this->repository->find($id);
        return $this->render('admin/medium/medium_edit.html.twig', array("medium" => $medium));
    }

    /**
     * @Route("/admin/medio/borrar/{id}", requirements={"id": "\d+"}, name="admin_medium_delete")
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Request $request)
    {
        $id = $request->get('id');
        /** @var Medium $medium */
        $medium = $this->repository->find($id);
        $this->repository->delete($medium);

        return $this->redirectToRoute('admin_medium_list');
    }
}
