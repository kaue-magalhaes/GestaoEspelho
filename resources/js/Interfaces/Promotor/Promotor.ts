import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";
import {Evento} from "@/Interfaces/Evento/Evento";
import {UrgenciaAtendimento} from "@/Interfaces/UrgenciaAtendimento/UrgenciaAtendimento";

export interface Promotor {
    id: string;
    nome: string;
    is_substituto: boolean;
    promotorias?: Promotoria[];
    eventos?: Evento[];
    urgenciasAtendimento?: UrgenciaAtendimento[];
}
