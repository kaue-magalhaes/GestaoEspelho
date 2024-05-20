import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";

export interface Espelho {
    id: string;
    periodo_inicio: string;
    periodo_fim: string;
    promotorias?: Promotoria[];
}
