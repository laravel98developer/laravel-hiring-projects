<?php


namespace App\Abstracts;

use App\Repositories\AvailabilityRepository;
use App\Repositories\ImportDataRepository;
use App\Repositories\ProductRepository;

abstract class AbstractProvider
{
    /**
     * @var bool
     */
    public bool $hasTour = false;

    /**
     * @var bool
     */
    public bool $hasEvent = false;

    /**
     * @var bool
     */
    public bool $hasActivity = false;

    /**
     * @var string
     */
    public string $baseUrl;

    /**
     * @var ProductRepository
     */
    public ProductRepository $productRepo;

    /**
     * @var ImportDataRepository
     */
    public ImportDataRepository $importDataRepo;

    /**
     * @var AvailabilityRepository
     */
    public AvailabilityRepository $availabilityRepo;

    /**
     * ProductController constructor.
     * @param ProductRepository $productRepo
     * @param ImportDataRepository $importDataRepo
     * @param AvailabilityRepository $availabilityRepo
     */
    public function __construct(
        ProductRepository $productRepo,
        ImportDataRepository $importDataRepo,
        AvailabilityRepository $availabilityRepo)
    {
        $this->productRepo = $productRepo;
        $this->importDataRepo = $importDataRepo;
        $this->availabilityRepo = $availabilityRepo;
    }

    abstract public function getTours();

    abstract public function getActivities();

    abstract public function getEvents();
}
