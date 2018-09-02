<?php

namespace App\Controller;

use App\Repository\MediumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminHomeController extends AbstractController
{
    /**
     * @var MediumRepository
     */
    protected $repository;

    /**
     * @param MediumRepository $mediumRepository
     */
    function __construct(MediumRepository $mediumRepository)
    {
        $this->repository = $mediumRepository;
    }

    /**
     * @Route("/admin", name="admin_home")
     * @Route("/admin/", name="admin_home")
     * @return Response
     */
    public function home()
    {
        $criteria = array();
        $orderBy = array('name' => 'ASC');

        $pictures = $this->repository->findBy($criteria, $orderBy);

        return $this->render('admin/index.html.twig', array(
            "pictures" => $pictures
        ));
    }
}
