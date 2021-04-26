<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/task/new", name="task_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUser($this->getUser());
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render(
            'admin/task/new.html.twig',
            [
                'task' => $task,
                'form' => $form->createView(),
            ]
        );
    }
}
