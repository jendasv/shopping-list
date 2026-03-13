<?php

namespace App\EventListener;

use App\Exception\Domain\ResourceNotFoundException;
use App\Exception\Domain\ValidationException;
use App\Exception\Http\ApiException;
use App\Exception\Infrastructure\DatabaseOperationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ApiExceptionListener
{

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ResourceNotFoundException) {
            $response = new JsonResponse(
                ['error' => $exception->getMessage()],
                404
            );
        } elseif ($exception instanceof ValidationException) {
            $response = new JsonResponse(
                [
                    'error' => $exception->getMessage(),
                    'details' => $exception->getErrors()
                ],
                400
            );
        } elseif ($exception instanceof DatabaseOperationException) {
            $response = new JsonResponse(
                ['error' => $exception->getMessage()],
                500
            );
        } else {
            $response = new JsonResponse(
                ['error' => 'Unexpected error: '.$exception->getMessage()],
                500
            );
        }
        $event->setResponse($response);

    }

}
