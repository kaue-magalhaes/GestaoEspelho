import {Promotor} from "@/Interfaces/Promotor";

export interface Evento {
    id: string;
    titulo?: string;
    tipo: string;
    periodo_inicio: string;
    periodo_fim: string;
    promotor_titular_id: string;
    promotor_designado_id: string;
    promotorTitular?: Promotor;
    promotorDesignado?: Promotor;
}
