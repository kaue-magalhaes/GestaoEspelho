<?php

namespace App\Listeners\EspelhoUpdated;

use App\Events\EspelhoUpdatedEvent;
use App\Models\Espelho;
use App\Utils\ChecksArray;
use App\Utils\DateConverter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdatePeriodoEspelhoListener
{
    public function __construct()
    {
        //
    }

    public function handle(EspelhoUpdatedEvent $event): void
    {
        $id             = $event->getId();
        $periodoEspelho = $event->getPeriodoEspelho();

        ChecksArray::is_array($periodoEspelho);
        ChecksArray::checkArraySizeEquals($periodoEspelho, 2);

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
