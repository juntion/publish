<?php


namespace Modules\ERP\Entities;


class OrdersInputNotes extends Model
{

    protected $table = 'orders_input_notes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'type', 'related_id', 'status', 'data', 'remark', 'create_at'
    ];

    /**
     * @inheritDoc
     */
    public function export(): array
    {
        // TODO: Implement export() method.
    }

    public function orders()
    {
        return $this->belongsTo(Order::class, 'orders_id', 'related_id');
    }
}
