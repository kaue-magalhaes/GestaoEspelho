import {User} from "@/Interfaces/User";
import {Promotor} from "@/Interfaces/Promotor";
import {UrgenciaAtendimento} from "@/Interfaces/UrgenciaAtendimento";

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    promotores: Promotor[];
    urgenciaAtendimentos: UrgenciaAtendimento[];
};
