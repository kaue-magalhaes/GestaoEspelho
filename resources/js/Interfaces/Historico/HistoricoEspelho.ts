import {HistoricoPromotoria} from "@/Interfaces/Historico/HistoricoPromotoria";

export interface HistoricoEspelho {
    id: string;
    periodo_inicio: string;
    periodo_fim: string;
    historico_id: number;
    promotorias?: HistoricoPromotoria[];
}
