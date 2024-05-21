import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";

export interface Espelho {
    id: string;
    periodo_inicio: Date;
    periodo_fim: Date;
    promotorias?: Promotoria[];
}
