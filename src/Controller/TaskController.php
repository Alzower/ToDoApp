<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/task')]
final class TaskController extends AbstractController
{
    #[Route(name: 'app_task_index', methods: ['GET'])]
    public function index(Request $request, TaskRepository $taskRepository): Response
    {
        $status = $request->query->get('status');

        if ($status !== null) {
            $status = (bool)$status;

            $tasks = $taskRepository->findBy(['status' => $status]);
        } else {
            $tasks = $taskRepository->findAll();
        }

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }


    #[Route('/{id}', name: 'app_task_status_check', methods: ['PUT'])]
    public function markAsDone(EntityManagerInterface $entityManager, Int $id): Response
    {
        $taskUpdateCheck = $entityManager->getRepository(Task::class)->find($id);
        if ($taskUpdateCheck) {
            $taskUpdateCheck->setStatus(true);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_task_index');
    }


    #[Route('/new', name: 'app_task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_show', methods: ['GET'])]
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Int $id,): Response
    {

        $taskToDelete = $entityManager->getRepository(Task::class)->find($id);
        if ($taskToDelete) {
            $entityManager->remove($taskToDelete);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
    }
}
