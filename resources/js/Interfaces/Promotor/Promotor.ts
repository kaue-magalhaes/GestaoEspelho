import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";
import {Evento} from "@/Interfaces/Evento";
import {UrgenciaAtendimento} from "@/Interfaces/UrgenciaAtendimento";

export interface Promotor {
    id: string;
    nome: string;
    is_substituto: boolean;
    created_at: string;
    updated_at: string;
    promotorias?: Promotoria[];
    eventos?: Evento[];
    urgenciasAtendimento?: UrgenciaAtendimento[];
}
