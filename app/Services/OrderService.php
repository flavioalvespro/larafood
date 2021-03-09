<?php

namespace App\Services;

use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\TableRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;

class OrderService
{
    private $orderRepository, $tenantRepository, $tableRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        TenantRepositoryInterface $tenantRepository,
        TableRepositoryInterface $tableRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->tenantRepository = $tenantRepository;
        $this->tableRepository = $tableRepository;
    }

    public function createNewOrder(array $order)
    {
        $identify = $this->getIdentifyOrder(8);
        $total = $this->getTotalOrder([]);
        $status = 'open';
        $tenantId = $this->getTenantIdOrder($order['token_company']);
        $comment = isset($order['comment']) ? $order['comment'] : '';
        $clientId = $this->getClientIdOrder();
        $tableId = $this->getTableIdOrder($order['table'] ?? '');

        $order = $this->orderRepository->createNewOrder($identify, $total, $status, $tenantId, $comment, $clientId, $tableId);

        return $order;
    }

    private function getIdentifyOrder(int $qtyCaraceters = 8)
    {
        $smallLetters = str_shuffle('abcdefghijlmnopqrstuvxz');

        $numbers = (((date('Ymd') / 12) * 24) + mt_rand(800, 9999));
        $numbers .= 1234567890;

        $characters = $smallLetters.$numbers;

        $identify = substr(str_shuffle($characters), 0, $qtyCaraceters);

        return $identify;
    }

    private function getTotalOrder(array $products): float
    {
        return (float) 90;   
    }

    private function getTenantIdOrder(string $uuid)
    {
        $tenant = $this->tenantRepository->getTenantByUuid($uuid);

        return $tenant->id;
    }

    private function getTableIdOrder(string $uuid = '')
    {
        if ($uuid) {
            $table = $this->tableRepository->getTableByUuid($uuid);

            return $table->id;
        }

        return $uuid;
    }

    private function getClientIdOrder()
    {
        $client = auth()->check() ? auth()->user()->id : '';

        return $client;
    }
}