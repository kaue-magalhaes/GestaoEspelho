import {HistoricoEspelhos} from "@/Interfaces/Historico/HistoricoEspelhos";
import {Links} from "@/Interfaces/Links";

export interface HistoricoEspelhosPaginate {
    current_page: number;
    data: HistoricoEspelhos[];
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: Links[];
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
}
