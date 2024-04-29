import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";

export interface Espelho {
    id: string;
    periodo_inicio: string;
    periodo_fim: string;
    created_at: string;
    updated_at: string;
    promotorias?: Promotoria[];
}
