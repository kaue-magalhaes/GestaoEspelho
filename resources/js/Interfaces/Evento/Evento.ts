import {Promotor} from "@/Interfaces/Promotor/Promotor";

export interface Evento {
    id?: string;
    uuid?: string;
    titulo?: string;
    tipo: string;
    periodo_inicio: Date;
    periodo_fim: Date;
    promotor_titular_id: string;
    promotor_designado_id: string;
    promotorTitular?: Promotor;
    promotorDesignado?: Promotor;
}
