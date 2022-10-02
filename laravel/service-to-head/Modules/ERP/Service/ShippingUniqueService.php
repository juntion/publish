<?php


namespace Modules\ERP\Service;

use Modules\ERP\Contracts\ShippingUniqueService as ContractsShippingUniqueService;
use Modules\ERP\Contracts\ShippingUniqueRepository;


class ShippingUniqueService implements ContractsShippingUniqueService
{
    protected $shippingUniqueRepository;

    public function __construct(ShippingUniqueRepository $shippingUniqueRepository)
    {
        $this->shippingUniqueRepository = $shippingUniqueRepository;
    }

    /**
     * @param string $prefix
     * @param string $number
     * @param int $count
     * @return mixed|string
     */
    public function factory($prefix = 'Fy', $number = '', $count = 0)
    {
        $count = $count < 1 ? $this->shippingUniqueRepository->showDayCount() : $count + 1;

        if (empty($number)) {
            $number = $prefix . date('Ymd', time()) . sprintf("%04d", $count + 1) . mt_rand(10, 99);
        }
        $verifyExists = $this->shippingUniqueRepository->get(['income_number' => $number])->exists ?? false;
        if ($verifyExists) {
            $number = self::factory($prefix, $prefix . date('Ymd', time()) . sprintf("%04d", substr($number, -4, 4) + 1) . mt_rand(10, 99), $count);
        }
        return $number;
    }

}
