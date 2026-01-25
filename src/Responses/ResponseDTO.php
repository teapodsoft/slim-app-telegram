<?php

namespace Teapodsoft\Responses;


/**
 * ResponseDTO
 *
 * @package Teaposoft\Responses
 * @description Обработчик для работы с единой структурой данных для ответа
 */
final class ResponseDTO
{

    /**
     * @var string
     */
    private string $version = '1.0';

    /**
     * @param mixed $data
     */
    public function __construct(
        private readonly mixed $data,
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
