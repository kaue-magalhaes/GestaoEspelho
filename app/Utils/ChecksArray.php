<?php

namespace App\Utils;

class ChecksArray
{
    /**
     * Check if the array is empty
     *
     * @param  array<string|array{uuid: string, periodo_inicio: string, periodo_fim: string, promotor_designado_id: string}>  $atendimentosUrgenciaDados
     */
    public static function is_array(array $atendimentosUrgenciaDados): void
    {
        if (! is_array($atendimentosUrgenciaDados)) {
            throw new \InvalidArgumentException('atenimentosUrgenciaDados deve ser um array');
        }
    }

    /**
     * Check if the array has the correct size
     *
     * @param  array<string>  $periodoEspelho
     */
    public static function checkArraySizeEquals(array $periodoEspelho, int $size): void
    {
        if (count($periodoEspelho) !== $size) {
            throw new \InvalidArgumentException('periodoEspelho deve ser um array com ' . $size . ' posições');
        }
    }
}
