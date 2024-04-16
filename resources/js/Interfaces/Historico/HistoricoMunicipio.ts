import {HistoricoGrupoPromotoria} from "@/Interfaces/Historico/HistoricoGrupoPromotoria";

export interface HistoricoMunicipioMunicipio {
    id: string;
    nome: string;
    created_at: string;
    updated_at: string;
    grupoPromotorias?: HistoricoGrupoPromotoria[];
}
