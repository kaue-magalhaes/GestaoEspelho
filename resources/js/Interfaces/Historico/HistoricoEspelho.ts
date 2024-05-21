import {HistoricoPromotoria} from "@/Interfaces/Historico/HistoricoPromotoria";

export interface HistoricoEspelho {
    id: string;
    periodo_inicio: Date;
    periodo_fim: Date;
    historico_id: number;
    promotorias?: HistoricoPromotoria[];
}
