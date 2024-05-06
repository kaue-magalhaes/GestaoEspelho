import {HistoricoPromotor} from "@/Interfaces/Historico/HistoricoPromotor";

export interface HistoricoEvento {
    id: string;
    uuid?: string;
    titulo?: string;
    tipo: string;
    periodo_inicio: string;
    periodo_fim: string;
    historico_promotor_titular_id: string;
    historico_promotor_designado_id: string;
    historico_id: number;
    promotorTitular?: HistoricoPromotor;
    promotorDesignado?: HistoricoPromotor;
}
