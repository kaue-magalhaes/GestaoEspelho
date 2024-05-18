import {Promotor} from "@/Interfaces/Promotor/Promotor";

export interface UrgenciaAtendimento {
    id: string;
    uuid?: string;
    periodo_inicio: string;
    periodo_fim: string;
    promotor_designado_id: string;
    created_at: string;
    updated_at: string;
    promotor?: Promotor;
}
