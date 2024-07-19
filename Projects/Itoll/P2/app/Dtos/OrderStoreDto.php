<?php

namespace App\Dtos;

use App\Contracts\DtoInterface;

readonly class OrderStoreDto implements DtoInterface
{
    public function __construct(
        private string $fromDestinationLatitude,
        private string $fromDestinationLongitude,
        private string $toDestinationLatitude,
        private string $toDestinationLongitude,
        private string $address,
        private int $supplierId,
        private string $supplierName,
        private string $supplierPhone,
        private string $receiverName,
        private string $receiverPhone,
    ) {
    }

    public function getFromDestinationLatitude(): string
    {
        return $this->fromDestinationLatitude;
    }

    public function getFromDestinationLongitude(): string
    {
        return $this->fromDestinationLongitude;
    }

    public function getToDestinationLatitude(): string
    {
        return $this->toDestinationLatitude;
    }

    public function getToDestinationLongitude(): string
    {
        return $this->toDestinationLongitude;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getSupplierId(): int
    {
        return $this->supplierId;
    }

    public function getSupplierName(): string
    {
        return $this->supplierName;
    }

    public function getSupplierPhone(): string
    {
        return $this->supplierPhone;
    }

    public function getReceiverName(): string
    {
        return $this->receiverName;
    }

    public function getReceiverPhone(): string
    {
        return $this->receiverPhone;
    }

    public function toArray(): array
    {
        return [
            'from_destination_latitude' => $this->fromDestinationLatitude,
            'from_destination_longitude' => $this->fromDestinationLongitude,
            'to_destination_latitude' => $this->toDestinationLatitude,
            'to_destination_longitude' => $this->toDestinationLongitude,
            'address' => $this->address,
            'supplier_id' => $this->supplierId,
            'supplier_name' => $this->supplierName,
            'supplier_phone' => $this->supplierPhone,
            'receiver_name' => $this->receiverName,
            'receiver_phone' => $this->receiverPhone,
        ];
    }
}
