<?php

namespace App\Controller;

use App\Entity\Image\Image;
use App\Repository\AuthorRepository;
use App\Repository\ImageRepository;
use App\Repository\ItemRepository;
use App\Repository\MediumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File;
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
     * @return RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Request $request, AuthorRepository $authorRepository, ItemRepository $itemRepository,
                         MediumRepository $mediumRepository)
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
            $message = "Image data has been updated"; // in case of success
        } else {
            $image = new Image();
            $image->setCreatedAt(new \DateTime());
            $item = $itemRepository->find($data['itemId']);
            $image->setItem($item);
            // Sube el fichero al directorio específico del item, cambiamos el nombre por el id del registro
            // TODO: Controlar que el campo del fichero de la imagen no vaya vacio la condicion else parece que no funciona
            /** @var FileBag $fileBag */
            $fileBag = $request->files;
            if (is_object($fileBag->get('itemImageFile'))) {
                $fileName = $this->uploadFile($data['itemId'], $fileBag);
                $image->setFileName($fileName);
            } else {
                $fileName = null;
                $message = "Not uploaded file";
                $this->addFlash('danger', $message);
            }
            $message = "Image has been created"; // in case of success
        }
        $image->setComments($data['comments']);
        $image->setConservation($data['conservation']);
        $image->setLocation($data['location']);
        $image->setMedium($data['medium']);
        $image->setAuthor($data['author']);
        $this->repository->save($image);
        $this->addFlash('success', $message);
        $redirect = $this->redirectToRoute('admin_item_view', array('id' => $data['itemId']));

        return $redirect;
    }

    /**
     * @param integer $itemId
     * @param FileBag $fileBag
     * @return string
     */
    private function uploadFile($itemId, FileBag $fileBag)
    {
        $itemUploadPath = __DIR__ . '/../../var/upload/' . $itemId . '/';
        // Crea el directorio de destino si no existe
        if (!is_file($itemUploadPath) && !is_dir($itemUploadPath)) {
            mkdir($itemUploadPath);
            chmod($itemUploadPath, 0755);
        }
        /** @var File\UploadedFile $file */
        $file = $fileBag->get('itemImageFile');
        $fileName = uniqid('img') . '.' . $file->guessExtension();
        $file->move($itemUploadPath, $fileName);

        return $fileName;
    }

    /**
     * Borra el fichero anterior si existe y pasa el nuevo a uploadFile
     * @param Image $image
     * @param FileBag $fileBag
     * @return string
     */
    public function updateFile(Image $image, FileBag $fileBag)
    {
        $uploadPath = __DIR__ . '/../../var/upload/';
        $itemId = $image->getItem()->getId();
        $actualFilePath = $uploadPath . $itemId . '/' . $image->getFileName();
        if (is_file($actualFilePath)) {
            unlink($actualFilePath);
        }

        return $this->uploadFile($itemId, $fileBag);
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
        $order = array('lastname' => 'DESC');
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
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Request $request)
    {
        $id = $request->get('id');
        /** @var Image $image */
        $image = $this->repository->find($id);
        $imagePath = __DIR__ . '/../../var/upload/' . $image->getItem()->getId() . '/' . $image->getFileName();
        if (is_file($imagePath)) {
            unlink($imagePath);
        }
        $itemId = $image->getItem()->getId();
        $this->repository->delete($image);
        return $this->redirectToRoute('admin_item_view', array('id' => $itemId));
    }
}