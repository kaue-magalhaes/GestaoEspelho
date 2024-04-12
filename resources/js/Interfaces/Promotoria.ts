import {Promotor} from "@/Interfaces/Promotor";
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria";
import {Espelho} from "@/Interfaces/Espelho";

export interface Promotoria {
    id: string;
    nome: string;
    is_especializada: boolean;
    espelho_id: string;
    promotor_titular_id: string;
    grupo_promotoria_id: string;
    created_at: string;
    updated_at: string;
    espelho?: Espelho;
    promotor?: Promotor;
    grupo_promotoria: GrupoPromotoria;
}
