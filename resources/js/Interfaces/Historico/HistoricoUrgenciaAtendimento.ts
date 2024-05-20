import {HistoricoPromotor} from "@/Interfaces/Historico/HistoricoPromotor";

export interface HistoricoUrgenciaAtendimento {
    id: string;
    uuid?: string;
    periodo_inicio: string;
    periodo_fim: string;
    historico_promotor_designado_id: string;
    promotor?: HistoricoPromotor;
}
