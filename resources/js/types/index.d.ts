export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export interface Promotor {
    id: number;
    nome: string;
    is_substituto: boolean;
    created_at: string;
    updated_at: string;
}

export interface Promotoria {
    id: number;
    nome: string;
    municipio: string;
    is_especializada: boolean;
    promotor_id: number;
    created_at: string;
    updated_at: string;
    promotor: Promotor;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    promotores: Promotor[];
    promotorias: {
        all: Promotoria[];
    }
};
