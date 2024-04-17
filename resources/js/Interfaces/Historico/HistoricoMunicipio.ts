import {HistoricoGrupoPromotoria} from "@/Interfaces/Historico/HistoricoGrupoPromotoria";

export interface HistoricoMunicipio {
    id: string;
    nome: string;
    created_at: string;
    updated_at: string;
    grupoPromotorias?: HistoricoGrupoPromotoria[];
}
