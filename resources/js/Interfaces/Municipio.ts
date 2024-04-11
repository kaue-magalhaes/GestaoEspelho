import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria";

export interface Municipio {
    id: string;
    nome: string;
    created_at: string;
    updated_at: string;
    grupoPromotorias?: GrupoPromotoria[];
}
