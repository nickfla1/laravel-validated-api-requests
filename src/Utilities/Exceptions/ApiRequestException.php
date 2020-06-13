<?php

/**
 * @author nickfla1
 */

declare(strict_types=1);

namespace Nickfla1\Utilities\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Nickfla1\Utilities\ApiRequest;

/**
 * Class ApiRequestException
 * @package Nickfla1\Utilities\Exceptions
 */
class ApiRequestException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'API request is invalid.';

    /**
     * @var ApiRequest
     */
    private $request;

    /**
     * @var MessageBag|null
     */
    private $errors;

    /**
     * ApiRequestException constructor.
     *
     * @param ApiRequest $request
     * @param MessageBag|null $errors
     */
    public function __construct(ApiRequest $request, $errors = null)
    {
        $this->request = $request;
        $this->errors = $errors;

        $requestMessage = $this->request->exceptionMessage();
        $requestCode = $this->request->exceptionCode();

        $message = $requestMessage ?: $this->message;
        $code = $requestCode ?: ($this->code ?: 0);

        parent::__construct($message, $code, null);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|null
     */
    public function render(Request $request)
    {
        return $this->request->exceptionRender($this, $request);
    }

    /**
     * @return mixed|null
     */
    public function report()
    {
        return $this->request->exceptionReport($this);
    }

    /**
     * @return MessageBag|null
     */
    public function getErrors()
    {
        return $this->errors;
    }
}