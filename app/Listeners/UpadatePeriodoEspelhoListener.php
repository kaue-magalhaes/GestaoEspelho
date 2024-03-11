<?php

namespace App\Listeners;

use App\Events\EspelhoUpdatedEvent;
use App\Models\Espelho;
use App\Utils\DateConverter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpadatePeriodoEspelhoListener
{
    public function __construct()
    {
        //
    }

    public function handle(EspelhoUpdatedEvent $event): void
    {
        $id             = $event->getId();
        $periodoEspelho = $event->getPeriodoEspelho();

        // Valida se o período do espelho é um array com 2 posições
        if (!is_array($periodoEspelho) || count($periodoEspelho) !== 2) {
            throw new \InvalidArgumentException('Invalid periodoEspelho data');
        }

        try {
            $periodoEspelhoConvertido = DateConverter::convertDateFormat($periodoEspelho);
            DB::transaction(function () use ($id, $periodoEspelhoConvertido) {
                Espelho::where('id', $id)->update(['periodo_inicio' => $periodoEspelhoConvertido['inicio'], 'periodo_fim' => $periodoEspelhoConvertido['fim']]);
            });
            Log::info('Período do espelho atualizado com sucesso para: ' . $periodoEspelhoConvertido['inicio'] . ' - ' . $periodoEspelhoConvertido['fim']);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar o período do espelho: ' . $e->getMessage());
            throw new \Exception('Erro ao atualizar o período do espelho');
        }
    }
}
