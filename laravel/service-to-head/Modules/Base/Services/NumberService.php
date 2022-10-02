<?php


namespace Modules\Base\Services;

use InvalidArgumentException;
use Modules\Base\Contracts\Number\Factory;
use Modules\Base\Contracts\Number\Number;
use Modules\Base\Services\Number\CWNumber;
use Modules\Base\Services\Number\DKNumber;
use Modules\Base\Services\Number\TagNumber;

class NumberService implements Factory
{
    protected $numbers = [];

    public function create($type = null): Number
    {
        if (!$type) {
            throw new InvalidArgumentException(__('base::number.noTypeSpecified'));
        }

        return $this->numbers[$type] ?? $this->numbers[$type] = $this->resolve($type);
    }

    protected function resolve($type)
    {
        switch ($type) {
            case 'DK':
                return new DKNumber();
                break;
            case 'TAG':
                return new TagNumber();
                break;
            case 'CW':
                return new CWNumber();
                break;
            default:
                break;
        }

        throw new InvalidArgumentException(__('base::number.unsupportedType', ['type' => $type]));
    }
}
