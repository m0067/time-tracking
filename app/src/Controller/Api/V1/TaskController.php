<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Dto\TaskFilterDto;
use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskController extends AbstractController
{
    /**
     * @Route("/v1/tasks", name="v1_task", methods={"GET","HEAD"})
     */
    public function index(Request $request, TaskRepository $taskRepository, ValidatorInterface $validator): JsonResponse
    {
        $taskFilterDto = new TaskFilterDto($request);
        $errors = $validator->validate($taskFilterDto);

        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $tasks = $taskRepository->findByUserPeriod($this->getUser(), $taskFilterDto);

        return $this->json(
            [
                'data' => array_map(
                    function (Task $task) {
                        return array_values($task->toArray());
                    },
                    $tasks
                ),
            ]
        );
    }
}
