import {User} from "@/Interfaces/User";
import {Promotor} from "@/Interfaces/Promotor";
import {UrgenciaAtendimento} from "@/Interfaces/UrgenciaAtendimento";
import {HistoricoPromotor} from "@/Interfaces/Historico/HistoricoPromotor";
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria";

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    flash: {
        success: string;
    }
    grupoPromotorias: GrupoPromotoria[];
    historicoPromotores: HistoricoPromotor[];
    urgenciaAtendimentos: UrgenciaAtendimento[];
};
