import {Promotor} from "@/Interfaces/Promotor/Promotor";

export interface UrgenciaAtendimento {
    id: string;
    uuid?: string;
    periodo_inicio: any;
    periodo_fim: any;
    promotor_designado_id: string;
    promotor?: Promotor;
}
