import {Promotor} from "@/Interfaces/Promotor/Promotor";
import {Espelho} from "@/Interfaces/Espelho/Espelho";
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria/GrupoPromotoria";

export interface Promotoria {
    id: string;
    nome: string;
    is_especializada: boolean;
    espelho_id: string;
    promotor_titular_id: string;
    grupo_promotoria_id: string;
    created_at: string;
    espelho?: Espelho;
    promotor?: Promotor;
    grupo_promotoria?: GrupoPromotoria;
}
