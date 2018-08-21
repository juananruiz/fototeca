<?php

namespace App\Controller;

use App\Entity\Item\Serie;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SerieController extends AbstractController
{
    /**
     * @var SerieRepository
     */
    protected $repository;

    /**
     * @param serieRepository $serieRepository
     */
    function __construct(SerieRepository $serieRepository)
    {
        $this->repository = $serieRepository;
    }

    /**
     * @Route("/admin/series", name="admin_serie_list")
     * @return Response
     */
    public function list()
    {
        $criteria = array();
        $orderBy = array('name' => 'ASC');

        $series = $this->repository->findBy($criteria, $orderBy);

        return $this->render('admin/serie/serie_list.html.twig', array(
            "series" => $series
        ));
    }

    /**
     * @Route("/admin/serie/grabar", name="admin_serie_save")
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Request $request)
    {
        $name = $request->get('name');
        $description = $request->get('description');
        $isJewel = $request->get('is_jewel');
        // Editing or adding
        if ($id = $request->get('id')) {
            $serie = $this->repository->find($id);
        } else {
            $serie = new Serie();
        }
        $serie->setName($name);
        $serie->setDescription($description);
        $serie->setIsJewel($isJewel);
        $this->repository->save($serie);

        return $this->redirectToRoute('admin_serie_list');
    }

    /**
     * @Route("/admin/serie/crear", name="admin_serie_add")
     * @return Response
     */
    public function add()
    {
        return $this->render('admin/serie/serie_add.html.twig');
    }

    /**
     * @Route("/admin/serie/editar/{id}", requirements={"id": "\d+"}, name="admin_serie_edit")
     * @param $id Serie id
     * @return Response
     */
    public function edit($id)
    {
        $serie = $this->repository->find($id);
        return $this->render('admin/serie/serie_edit.html.twig', array("serie" => $serie));
    }

    /**
     * @Route("/admin/serie/borrar/{id}", requirements={"id": "\d+"}, name="admin_serie_delete")
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Request $request)
    {
        $id = $request->get('id');
        /** @var Serie $serie */
        $serie = $this->repository->find($id);
        $this->repository->delete($serie);

        return $this->redirectToRoute('admin_serie_list');
    }
}