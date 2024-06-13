import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";
import {Municipio} from "@/Interfaces/Municipio";

export interface GrupoPromotoria {
    id: string;
    nome: string;
    municipio_id: string;
    promotorias?: Promotoria[];
    municipio?: Municipio;
}
