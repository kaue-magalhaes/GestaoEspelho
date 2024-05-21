import {HistoricoPromotoria} from "@/Interfaces/Historico/HistoricoPromotoria";
import {HistoricoEvento} from "@/Interfaces/Historico/HistoricoEvento";
import {HistoricoUrgenciaAtendimento} from "@/Interfaces/Historico/HistoricoUrgenciaAtendimento";

export interface HistoricoPromotor {
    id: string;
    nome: string;
    is_substituto: boolean;
    promotorias?: HistoricoPromotoria[];
    eventos?: HistoricoEvento[];
    urgenciasAtendimento?: HistoricoUrgenciaAtendimento[];
}
