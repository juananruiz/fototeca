<?php

namespace App\Controller;

use App\Entity\Item\Item;
use App\Repository\AuthorRepository;
use App\Repository\CountryRepository;
use App\Repository\ItemRepository;
use App\Repository\MediumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ItemController extends AbstractController
{
    /**
     * @var ItemRepository
     */
    protected $repository;

    /**
     * @param itemRepository $itemRepository
     */
    function __construct(ItemRepository $itemRepository)
    {
        $this->repository = $itemRepository;
    }

    /**
     * @Route("/admin/items", name="admin_item_list")
     * @return Response
     */
    public function list()
    {
        $criteria = array();
        $orderBy = array('name' => 'ASC');

        $items = $this->repository->findBy($criteria, $orderBy);

        return $this->render('admin/item/item_list.html.twig', array(
            "items" => $items
        ));
    }

    /**
     * @Route("/admin/item/grabar", name="admin_item_save")
     * @param Request $request
     * @param CountryRepository $countryRepository
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Request $request, CountryRepository $countryRepository)
    {
        $name = $request->get('name');
        $comments = $request->get('comments');
        $countryId = $request->get('country_id');
        $locality = $request->get('locality');
        $province = $request->get('province');
        // Editing or adding
        if ($id = $request->get('id')) {
            $item = $this->repository->find($id);
        } else {
            $item = new Item();
            $item->setCreatedAt(new \DateTime());
        }
        $item->setName($name);
        $item->setComments($comments);
        $item->setCountry($countryRepository->find($countryId));
        $item->setLocality($locality);
        $item->setProvince($province);
        $this->repository->save($item);

        return $this->redirectToRoute('admin_item_list');
    }

    /**
     * @Route("/admin/item/crear", name="admin_item_add")
     * @param CountryRepository $countryRepository
     * @return Response
     */
    public function add(CountryRepository $countryRepository)
    {
        $countries = $countryRepository->findBy(array(), array("nameEs" => "ASC"));
        return $this->render('admin/item/item_add.html.twig', array(
            "countries" => $countries));
    }

    /**
     * @Route("/admin/item/editar/{id}", requirements={"id": "\d+"}, name="admin_item_edit")
     * @param CountryRepository $countryRepository
     * @param MediumRepository $mediumRepository
     * @param AuthorRepository $authorRepository
     * @param $id Item id
     * @return Response
     */
    public function edit($id, CountryRepository $countryRepository, MediumRepository $mediumRepository,
                         AuthorRepository $authorRepository)
    {
        $countries = $countryRepository->findBy(array(), array("nameEs" => "ASC"));
        $mediums = $mediumRepository->findBy(array(), array("name" => "ASC"));
        $authors = $authorRepository->findBy(array(), array("lastName" => "ASC"));
        $item = $this->repository->find($id);
        return $this->render('admin/item/item_edit.html.twig', array(
            "item" => $item,
            "countries" => $countries,
            "mediums" => $mediums,
            "authors" => $authors));
    }

    /**
     * @Route("/admin/item/borrar/{id}", requirements={"id": "\d+"}, name="admin_item_delete")
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Request $request)
    {
        $id = $request->get('id');
        /** @var Item $item */
        $item = $this->repository->find($id);
        $this->repository->delete($item);

        return $this->redirectToRoute('admin_item_list');
    }

    /**
     * @Route("/admin/item/{id}", requirements={"id" : "\d+"}, name="admin_item_view")
     */
    public function view()
    {

    }
}
