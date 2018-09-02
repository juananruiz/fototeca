<?php

namespace App\Controller;

use App\Repository\MediumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
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

        return $this->render('public/index.html.twig', array(
            "pictures" => $pictures
        ));
    }

    /**
     * @Route("/series", name="series")
     */
    public function series()
    {
        return $this->render('public/index.html.twig');
    }


    /**
     * @Route("/fotografos", name="photographers")
     */
    public function photographers()
    {
        return $this->render('public/index.html.twig');
    }

    /**
     * @Route("/contactar", name="contact")
     */
    public function contact()
    {
        return $this->render('public/index.html.twig');
    }

    /**
     * @Route("/conocenos", name="about")
     */
    public function about()
    {
        return $this->render('public/index.html.twig');
    }

}
