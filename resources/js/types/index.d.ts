import {User} from "@/Interfaces/User";
import {Espelho} from "@/Interfaces/Espelho";
import {Promotor} from "@/Interfaces/Promotor";
import {Promotoria} from "@/Interfaces/Promotoria";
import {Evento} from "@/Interfaces/Evento";

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    espelho: Espelho[];
    promotores: Promotor[];
    promotorias: Promotoria[];
    eventos: Evento[];
};
