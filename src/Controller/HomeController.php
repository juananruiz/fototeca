<?php

namespace App\Controller;

use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ItemRepository $itemRepository
     * @return Response
     */
    public function home(ItemRepository $itemRepository)
    {
        $criteria = array();
        $orderBy = array('name' => 'ASC');
        $items = $itemRepository->findBy($criteria, $orderBy);

        return $this->render('public/index.html.twig', array(
            "items" => $items
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
