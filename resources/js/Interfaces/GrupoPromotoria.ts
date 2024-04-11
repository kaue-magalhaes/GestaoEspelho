import {Promotoria} from "@/Interfaces/Promotoria";
import {Municipio} from "@/Interfaces/Municipio";

export interface GrupoPromotoria {
    id: string;
    nome: string;
    municipio_id: string;
    created_at: string;
    updated_at: string;
    promotorias?: Promotoria[];
    municipio?: Municipio;
}
