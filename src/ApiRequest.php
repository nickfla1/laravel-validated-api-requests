<?php

/**
 * @author nickfla1
 */

declare(strict_types=1);

namespace Nickfla1\Utilities;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Nickfla1\Utilities\Exceptions\ApiRequestException;

/**
 * Class ApiRequest
 * @package Nickfla1\Utilities
 */
class ApiRequest extends Request
{
    /**
     * ApiRequest constructor.
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param null $content
     * @throws ApiRequestException
     */
    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        // Perform request validation
        $this->performValidation();
    }

    /**
     * @throws ApiRequestException
     * @return void
     */
    private function performValidation()
    {
        $rules = $this->rules();

        // Don't validate if no rule has been set
        if (!$rules || count($rules) === 0) {
            return;
        }

        // Select data source
        if ($this->json()->count() > 0 || $this->isJson()) {
            $data = $this->json()->all();
        } else {
            $data = $this->all();
        }

        // Create validator
        $messages = $this->messages();
        $customAttributes = $this->customAttributes();
        $validator = Validator::make($data, $rules, $messages, $customAttributes);

        if (!$validator->fails()) {
            // Don't do anything if the validation is successful
            return;
        }

        // Throw an Exception on failed validation
        throw new ApiRequestException(
            $this,
            $validator->errors()
        );
    }

    /**
     * Define validation rules.
     *
     * @return array|null
     */
    protected function rules()
    {
        return null;
    }

    /**
     * Override default validation messages.
     *
     * @return array
     */
    protected function messages()
    {
        return [];
    }

    /**
     * Override attributes name.
     *
     * @return array
     */
    protected function customAttributes()
    {
        return [];
    }

    /**
     * Executed by ApiRequestException to render the exception
     * in case of failed validation.
     *
     * @param Request|null $request
     * @return Response|null
     */
    public function exceptionRender($request)
    {
        return null;
    }

    /**
     * Executed in ApiRequestException to report the execption
     * in case of failed validation.
     *
     * @return mixed|null
     */
    public function exceptionReport()
    {
        return null;
    }

    /**
     * Override ApiRequestException's default message.
     *
     * @return string|null
     */
    public function exceptionMessage()
    {
        return null;
    }

    /**
     * Override ApiRequestException's default code.
     *
     * @return mixed|null
     */
    public function exceptionCode()
    {
        return null;
    }
}