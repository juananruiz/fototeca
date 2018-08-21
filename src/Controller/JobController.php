<?php

namespace App\Controller;

use App\Entity\Author\Job;
use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class JobController extends AbstractController
{
    /**
     * @var JobRepository
     */
    protected $repository;

    /**
     * @param jobRepository $jobRepository
     */
    function __construct(JobRepository $jobRepository)
    {
        $this->repository = $jobRepository;
    }

    /**
     * @Route("/admin/oficios", name="admin_job_list")
     * @return Response
     */
    public function list()
    {
        $criteria = array();
        $orderBy = array('name' => 'ASC');

        $jobs = $this->repository->findBy($criteria, $orderBy);

        return $this->render('admin/job/job_list.html.twig', array(
            "jobs" => $jobs
        ));
    }

    /**
     * @Route("/admin/oficio/grabar", name="admin_job_save")
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Request $request)
    {
        $name = $request->get('name');
        // Editing or adding
        if ($id = $request->get('id')) {
            $job = $this->repository->find($id);
        } else {
            $job = new Job();
        }
        $job->setName($name);
        $this->repository->save($job);

        return $this->redirectToRoute('admin_job_list');
    }

    /**
     * @Route("/admin/oficio/crear", name="admin_job_add")
     * @return Response
     */
    public function add()
    {
        return $this->render('admin/job/job_add.html.twig');
    }

    /**
     * @Route("/admin/oficio/editar/{id}", requirements={"id": "\d+"}, name="admin_job_edit")
     * @param $id Job id
     * @return Response
     */
    public function edit($id)
    {
        $job = $this->repository->find($id);
        return $this->render('admin/job/job_edit.html.twig', array("job" => $job));
    }

    /**
     * @Route("/admin/oficio/borrar/{id}", requirements={"id": "\d+"}, name="admin_job_delete")
     * @param Request $request
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @return Response
     */
    public function delete(Request $request)
    {
        $id = $request->get('id');
        /** @var Job $job */
        $job = $this->repository->find($id);
        $this->repository->delete($job);

        return $this->redirectToRoute('admin_job_list');
    }
}