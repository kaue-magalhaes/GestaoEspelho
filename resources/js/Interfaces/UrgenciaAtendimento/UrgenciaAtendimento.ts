import {Promotor} from "@/Interfaces/Promotor/Promotor";

export interface UrgenciaAtendimento {
    id: string;
    uuid?: string;
    periodo_inicio: Date;
    periodo_fim: Date;
    promotor_designado_id: string;
    promotor?: Promotor;
}
