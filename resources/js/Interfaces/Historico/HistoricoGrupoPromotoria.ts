import {HistoricoPromotoria} from "@/Interfaces/Historico/HistoricoPromotoria";
import {HistoricoMunicipio} from "@/Interfaces/Historico/HistoricoMunicipio";

export interface HistoricoGrupoPromotoria {
    id: string;
    nome: string;
    historico_municipio_id: string;
    historico_id: number;
    promotorias?: HistoricoPromotoria[];
    municipio?: HistoricoMunicipio;
}
