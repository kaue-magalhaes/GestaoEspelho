import {User} from "@/Interfaces/User";

export interface Espelhos {
    id: number;
    titulo: string;
    periodo_inicio: string;
    periodo_fim: string;
    usuario_id: number;
    historico_id: number;
    created_at: string;
    updated_at: string;
    user: User;
}
