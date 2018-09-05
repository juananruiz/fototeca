<?php

namespace App\Controller;

use App\Entity\Image\Image;
use App\Repository\AuthorRepository;
use App\Repository\ImageRepository;
use App\Repository\ItemRepository;
use App\Repository\MediumRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * @var ImageRepository
     */
    protected $repository;

    /**
     * @param ImageRepository $imageRepository
     */
    function __construct(ImageRepository $imageRepository)
    {
        $this->repository = $imageRepository;
    }

    /**
     * @Route("/imagen/{id}", requirements={"id": "\d+"}, name="image_view")
     * @param Request $request
     * @return Response
     */
    public function view(Request $request)
    {
        $id = $request->get('id');
        $image = $this->repository->find($id);

        return $this->render('public/item/image_view.html.twig', array("image" => $image));
    }

    /**
     * @Route("/admin/imagen/grabar", name="admin_image_save")
     * @param Request $request
     * @param AuthorRepository $authorRepository
     * @param ItemRepository $itemRepository
     * @param MediumRepository $mediumRepository
     * @param FileUploader $fileUploader
     * @return RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Request $request, AuthorRepository $authorRepository, ItemRepository $itemRepository,
                         MediumRepository $mediumRepository, FileUploader $fileUploader)
    {
        $data = array();
        $data['comments'] = $request->get('comments');
        $data['conservation'] = $request->get('conservation');
        $data['itemId'] = $request->get('itemId');
        $data['location'] = $request->get('location');
        $data['medium'] = $mediumRepository->find($request->get('mediumId'));
        $data['author'] = $authorRepository->find($request->get('authorId'));
        // Editing or adding
        if ($data['id'] = $request->get('id')) {
            $image = $this->repository->find($data['id']);
            $this->addFlash('success', "Image data has been updated");

        } else {
            $image = new Image();
            $image->setCreatedAt(new \DateTime());
            $item = $itemRepository->find($data['itemId']);
            $image->setItem($item);
            // Sube el fichero al directorio específico del item, cambiamos el nombre por el id del registro
            // TODO: Controlar que el campo del fichero de la imagen no vaya vacio la condicion else parece que no funciona
            /** @var FileBag $fileBag */
            $fileBag = $request->files;
            if (is_object($fileBag->get('imageFile'))) {
                $fileName = $fileUploader->upload($data['itemId'], $fileBag->get('imageFile'));
                $image->setFileName($fileName);
            } else {
                $fileName = null;
                $this->addFlash('danger', "Not uploaded file");
            }
            $this->addFlash('success', "Image has been created");

        }
        $image->setComments($data['comments']);
        $image->setConservation($data['conservation']);
        $image->setLocation($data['location']);
        $image->setMedium($data['medium']);
        $image->setAuthor($data['author']);
        $this->repository->save($image);
        $redirect = $this->redirectToRoute('admin_item_edit', array('id' => $data['itemId']));

        return $redirect;
    }

    /**
     * @Route("/admin/imagen/crear", name="admin_image_add")
     * @param Request $request
     * @param MediumRepository $mediumRepository
     * @param AuthorRepository $authorRepository
     * @return Response
     */
    public function add(Request $request, MediumRepository $mediumRepository, AuthorRepository $authorRepository)
    {
        $itemId = $request->get('item_id');
        $item = $this->repository->find($itemId);
        $mediums = $mediumRepository->findAll();
        $criteria = array('job.name' => 'Fotógrafo');
        $order = array('lastName' => 'DESC');
        $authors = $authorRepository->findBy($criteria, $order);
        return $this->render('admin/image/image_add.html.twig', array(
            "item" => $item,
            "mediums" => $mediums,
            "photographers" => $authors,
        ));
    }

    /**
     * @Route("/admin/imagen/editar/{id}", requirements={"id": "\d+"}, name="admin_image_edit")
     * @param $id Image id
     * @param MediumRepository $mediumRepository
     * @param AuthorRepository $authorRepository
     * @return Response
     */
    public function edit($id, MediumRepository $mediumRepository, AuthorRepository $authorRepository)
    {
        $image = $this->repository->find($id);
        $mediums = $mediumRepository->findAll();
        $criteria = array('job.name' => 'Fotógrafo');
        $order = array('lastname' => 'DESC');
        $authors = $authorRepository->findBy($criteria, $order);

        return $this->render('admin/image/image_edit.html.twig', array(
            "image" => $image,
            "mediums" => $mediums,
            "authors" => $authors,
        ));
    }

    /**
     * @Route("/admin/image/borrar/{id}", requirements={"id": "\d+"}, name="admin_image_delete")
     * @param Request $request
     * @param FileUploader $file
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Request $request, FileUploader $file)
    {
        $id = $request->get('id');
        /** @var Image $image */
        $image = $this->repository->find($id);
        $itemId = $image->getItem()->getId();
        $file->remove($itemId, $image->getFileName());
        $this->repository->delete($image);
        return $this->redirectToRoute('admin_item_view', array('id' => $itemId));
    }
}
