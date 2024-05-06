import {HistoricoPromotor} from "@/Interfaces/Historico/HistoricoPromotor";
import {HistoricoGrupoPromotoria} from "@/Interfaces/Historico/HistoricoGrupoPromotoria";
import {HistoricoEspelho} from "@/Interfaces/Historico/HistoricoEspelho";

export interface HistoricoPromotoria {
    id: string;
    nome: string;
    is_especializada: boolean;
    historico_espelho_id: string;
    historico_promotor_titular_id: string;
    historico_grupo_promotoria_id: string;
    created_at: string;
    updated_at: string;
    espelho?: HistoricoEspelho;
    promotor?: HistoricoPromotor;
    grupo_promotoria: HistoricoGrupoPromotoria;
}
