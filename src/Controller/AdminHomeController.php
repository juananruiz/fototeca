<?php

namespace App\Controller;

use App\Repository\ItemRepository;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminHomeController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     * @Route("/admin/", name="admin_home")
     * @param ItemRepository $itemRepository
     * @param SerieRepository $serieRepository
     * @return Response
     */
    public function home(ItemRepository $itemRepository, SerieRepository $serieRepository)
    {
        $criteria = array();
        $orderBy = array('modifiedAt' => 'DESC');
        $recentItems = $itemRepository->findBy($criteria, $orderBy);

        $series = $serieRepository->findAll();
        return $this->render('admin/index.html.twig', array(
            "items" => $recentItems,
            "series" => $series,
        ));
    }
}
