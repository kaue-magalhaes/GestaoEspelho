export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export interface Espelho {
    id: number;
    periodo_inicio: string;
    periodo_fim: string;
    created_at: string;
    updated_at: string;
    promotorias: Promotoria[];
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
    nome_grupo_promotorias: string;
    municipio: string;
    is_especializada: boolean;
    espelho_id: number;
    promotor_titular_id: number;
    created_at: string;
    updated_at: string;
}

export interface Evento {
    id: number;
    titulo: string;
    tipo: string;
    periodo_inicio: string;
    periodo_fim: string;
    promotor_titular_id: number;
    promotor_designado_id: number;
}

export interface UrgenciaAtendimento {
    id: number;
    periodo_inicio: string;
    periodo_fim: string;
    promotor_designado_id: number;
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
    }[];
}

export interface AtendimentoUrgencia {
    id: number;
    nome_promotor: string;
    periodo: any;
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
