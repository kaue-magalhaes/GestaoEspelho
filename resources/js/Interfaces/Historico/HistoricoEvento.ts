import {HistoricoPromotor} from "@/Interfaces/Historico/HistoricoPromotor";

export interface HistoricoEvento {
    id: string;
    uuid?: string;
    titulo?: string;
    tipo: string;
    periodo_inicio: Date;
    periodo_fim: Date;
    historico_promotor_titular_id: string;
    historico_promotor_designado_id: string;
    historico_id: number;
    promotorTitular?: HistoricoPromotor;
    promotorDesignado?: HistoricoPromotor;
}
