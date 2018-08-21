<?php

namespace App\Controller;

use App\Entity\Author\Author;
use App\Repository\AuthorRepository;
use App\Repository\CountryRepository;
use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AuthorController extends Controller
{
    /**
     * @var AuthorRepository
     */
    protected $repository;

    /**
     * @param authorRepository $authorRepository
     */
    function __construct(AuthorRepository $authorRepository)
    {
        $this->repository = $authorRepository;
    }

    /**
     * @Route("/admin/autores", name="admin_author_list")
     * @return Response
     */
    public function list()
    {
        $authors = $this->repository->findBy(array(), array('lastName' => 'ASC'));

        return $this->render('admin/author/author_list.html.twig', array(
            "authors" => $authors
        ));
    }

    /**
     * @Route("/admin/autor/grabar", name="admin_author_save")
     * @param Request $request
     * @param CountryRepository $countryRepository
     * @param JobRepository $jobRepository
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Request $request, CountryRepository $countryRepository, JobRepository $jobRepository)
    {
        $firstName = $request->get('first_name');
        $lastName = $request->get('last_name');
        $birthDate = new \DateTime($request->get('birth_date'));
        $deathDate = new \DateTime($request->get('death_date'));
        $comment = $request->get('comment');
        $countryId = $request->get('country_id');
        $jobId = $request->get('job_id');

        // Editing or adding
        if ($id = $request->get('id')) {
            $author = $this->repository->find($id);
        } else {
            $author = new Author();
            $author->setCreatedAt(new \DateTime());
        }
        $author->setFirstName($firstName);
        $author->setLastName($lastName);
        $author->setBirthDate($birthDate);
        $author->setDeathDate($deathDate);
        $author->setComment($comment);
        $author->setCountry($countryRepository->find($countryId));
        $author->setJob($jobRepository->find($jobId));
        $this->repository->save($author);

        return $this->redirectToRoute('admin_author_list');
    }

    /**
     * @Route("/admin/autor/crear", name="admin_author_add")
     * @param CountryRepository $countryRepository
     * @param JobRepository $jobRepository
     * @return Response
     */
    public function add(CountryRepository $countryRepository, JobRepository $jobRepository)
    {
        $countries = $countryRepository->findBy(array(), array("nameEs" => "ASC"));
        $jobs = $jobRepository->findBy(array(), array("name" => "ASC"));

        return $this->render('admin/author/author_add.html.twig', array(
            "countries" => $countries,
            "jobs" => $jobs
        ));
    }

    /**
     * @Route("/admin/autor/editar/{id}", requirements={"id": "\d+"}, name="admin_author_edit")
     * @param $id Author id
     * @param CountryRepository $countryRepository
     * @param JobRepository $jobRepository
     * @return Response
     */
    public function edit($id,CountryRepository $countryRepository, JobRepository $jobRepository)
    {
        $author = $this->repository->find($id);
        $countries = $countryRepository->findAll();
        $jobs = $jobRepository->findAll();

        return $this->render('admin/author/author_edit.html.twig', array(
            "author" => $author,
            "countries" => $countries,
            "jobs" => $jobs
        ));
    }

    /**
     * @Route("/admin/autor/borrar/{id}", requirements={"id": "\d+"}, name="admin_author_delete")
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Request $request)
    {
        $id = $request->get('id');
        /** @var Author $author */
        $author = $this->repository->find($id);
        $this->repository->delete($author);

        return $this->redirectToRoute('admin_author_list');
    }
}