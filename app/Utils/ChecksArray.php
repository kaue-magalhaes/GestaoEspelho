<?php
namespace App\Utils;

class ChecksArray
{
    public static function is_array(array $atendimentosUrgenciaDados): void
    {
        if (!is_array($atendimentosUrgenciaDados)) {
            throw new \InvalidArgumentException('atenimentosUrgenciaDados deve ser um array');
        }
    }

    public static function checkArraySizeEquals(array $periodoEspelho, int $size): void
    {
        if (count($periodoEspelho) !== $size) {
            throw new \InvalidArgumentException('periodoEspelho deve ser um array com ' . $size . ' posições');
        }
    }
}
