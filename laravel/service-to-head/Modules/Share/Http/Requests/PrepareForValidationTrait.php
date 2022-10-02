<?php


namespace Modules\Share\Http\Requests;


trait PrepareForValidationTrait
{
    /**
     * 预处理传值为空的
     */
    public function prepareForValidation()
    {
        foreach ($this->notMustData as $item) {
            if ($this->request->has($item) && $this->request->get($item) === null) {
                $this->request->remove($item);
            }
        }
    }
}
