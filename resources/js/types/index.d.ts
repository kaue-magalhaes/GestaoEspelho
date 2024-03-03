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
    nome_grupo: string;
    nome: string;
    municipio: string;
    is_especializada: boolean;
    promotor_id: number;
    created_at: string;
    updated_at: string;
    promotor: Promotor;
}

export interface GrupoPromotoria {
    nome: string;
    promotorias: {
        nome: string;
        municipio: string;
        is_especializada: boolean;
        nomePromotor: string;
        eventos: {
        id: number;
        tipo: string;
        periodo: any;
        titulo: string;
        promotor_designado_evento: string;
        }[];
    }[];
}

export interface Atribuicoes {
    id: number;
    nome_promotor: string;
    atribuicoes: {
        id: number;
        tipo: string;
        periodo: string[];
        titulo: string;
        promotor_designado_evento: string;
    }[]
};

export interface AtendimentoUrgencia {
    id: number;
    nome_promotor: string;
    periodo: any;
};

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    promotores: Promotor[];
    promotorias: {
        all: Promotoria[];
    }
};
