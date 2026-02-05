<?php

namespace Teapodsoft\Responses;


/**
 * ResponseDTO
 *
 * @package Teaposoft\Responses
 * @description Обработчик для работы с единой структурой данных для ответа
 */
readonly final class ResponseDTO
{

    /**
     * @param mixed $data
     * @param string $version
     */
    public function __construct(
        private mixed  $data,
        private string $version = '1.0'
    )
    {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode([
            'version' => $this->version,
            'data' => $this->data,
        ]);
    }

}
