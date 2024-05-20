import {HistoricoGrupoPromotoria} from "@/Interfaces/Historico/HistoricoGrupoPromotoria";

export interface HistoricoMunicipio {
    id: string;
    nome: string;
    grupoPromotorias?: HistoricoGrupoPromotoria[];
}
