import {Promotor} from "@/Interfaces/Promotor";

export interface HistoricoEvento {
    id: string;
    uuid?: string;
    titulo?: string;
    tipo: string;
    periodo_inicio: string;
    periodo_fim: string;
    promotor_titular_id: string;
    promotor_designado_id: string;
    promotorTitular?: Promotor;
    promotorDesignado?: Promotor;
}