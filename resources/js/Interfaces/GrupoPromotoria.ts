import {Promotoria} from "@/Interfaces/Promotoria";
import {Evento} from "@/Interfaces/Evento";

export interface GrupoPromotoria {
    nome_grupo_promotorias: string;
    promotorias: Promotoria[];
    eventos: Evento[];
}