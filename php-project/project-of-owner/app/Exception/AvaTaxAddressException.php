<?php


namespace App\Exception;

use Throwable;
use App\Request\AvaTaxAddressRequest;

class AvaTaxAddressException extends \ Exception
{
    private $customMessage;
    private $request;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->customMessage = $message = $message ? $message : "data is empty";
        $this->request = new AvaTaxAddressRequest();
        parent::__construct($message, $code, $previous);
    }

    /**
     * 错误异常处理
     *
     * @return \stdClass
     */
    public function handleError()
    {
        $class = new \stdClass();
        $class->resolutionQuality = 'NotCoded';
        if (!empty($this->customMessage)) {
            if (!$this->isNotJson($this->customMessage)) {
                $data = json_decode($this->customMessage);
                $data->severity = 'Error';
                    $data->source = 'validate by FS system';
                foreach ($this->request->rules() as $k => $v) {
                    if (property_exists($data, $k)) {
                        $data->refersTo = 'Address.' . $k;
                        $data->details = $data->$k;
                        break;
                    }
                }
                $class->messages[] = $data;
            }
        }
        return $class;
    }

    public function isNotJson($str = "")
    {
        return is_null(json_decode($str));
    }
}
