import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria/GrupoPromotoria";

export interface Municipio {
    id: string;
    nome: string;
    grupoPromotorias?: GrupoPromotoria[];
}
