<?php

namespace App\Application\Common\Controller;

use Exception;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;

class HealthcheckController
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function healthcheck(): JsonResponse
    {
        try {
            $this->connection->executeQuery('SELECT 1');
        } catch (Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => 'Database not reachable'], 500);
        }

        // You can add other checks like caching, external APIs, etc.
        return new JsonResponse(['status' => 'ok'], 200);
    }
}
