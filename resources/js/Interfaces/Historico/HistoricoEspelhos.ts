import {User} from "@/Interfaces/User";

export interface HistoricoEspelhos {
    id: number;
    titulo: string;
    periodo_inicio: Date;
    periodo_fim: Date;
    usuario_id: number;
    historico_id: number;
    created_at: string;
    updated_at: string;
    user: User;
}
