<?php

namespace App\Controller;

use App\Repository\MediumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends Controller
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
     * @Route("/", name="home")
     * @return Response
     */
    public function home()
    {
        $criteria = array();
        $orderBy = array('name' => 'ASC');

        $pictures = $this->repository->findBy($criteria, $orderBy);

        return $this->render('index.html.twig', array(
            "pictures" => $pictures
        ));
    }
}