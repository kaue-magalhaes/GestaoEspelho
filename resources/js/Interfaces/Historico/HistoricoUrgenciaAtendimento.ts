import {HistoricoPromotor} from "@/Interfaces/Historico/HistoricoPromotor";

export interface HistoricoUrgenciaAtendimento {
    id: string;
    uuid?: string;
    periodo_inicio: Date;
    periodo_fim: Date;
    historico_promotor_designado_id: string;
    promotor?: HistoricoPromotor;
}
