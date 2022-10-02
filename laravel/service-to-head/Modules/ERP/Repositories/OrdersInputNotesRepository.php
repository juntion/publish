<?php


namespace Modules\ERP\Repositories;

use Modules\ERP\Entities\OrdersInputNotes;
use Modules\ERP\Contracts\OrdersInputNotesRepository as OrdersInputNotesRepositoryInterface;

class OrdersInputNotesRepository implements OrdersInputNotesRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function store(OrdersInputNotes $ordersInputNotes)
    {
        $store = OrdersInputNotes::create($ordersInputNotes->toArray());
        return $store->refresh();
    }
}
