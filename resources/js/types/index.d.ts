export interface User {
    id: string;
    name: string;
    email: string;
    email_verified_at: string;
}

export interface Espelho {
    id: string;
    periodo_inicio: string;
    periodo_fim: string;
    created_at: string;
    updated_at: string;
    promotorias: Promotoria[];
}

export interface Promotor {
    id: string;
    nome: string;
    is_substituto: boolean;
    created_at: string;
    updated_at: string;
}

export interface Promotoria {
    id: string;
    nome: string;
    nome_grupo_promotorias: string;
    municipio: string;
    is_especializada: boolean;
    espelho_id: string;
    promotor_titular_id: string;
    created_at: string;
    updated_at: string;
}

export interface Evento {
    uuid: string;
    titulo: string;
    tipo: string;
    periodo_inicio: string;
    periodo_fim: string;
    promotor_titular_id: string;
    promotor_designado_id: string;
}

export interface UrgenciaAtendimentoClientSide {
    uuid: string;
    periodo_inicio: string;
    periodo_fim: string;
    promotor_designado_id: string;
}

export interface UrgenciaAtendimentoServeSide {
    id: string;
    periodo_inicio: string;
    periodo_fim: string;
    promotor_designado_id: string;
}

export interface GrupoPromotoria {
    nome_grupo_promotorias: string;
    promotorias: Promotoria[];
    eventos: Evento[];
}

export interface Atribuicoes {
    nome_promotor: string;
    atribuicoes: Evento[];
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    espelho: Espelho[];
    promotores: Promotor[];
    promotorias: Promotoria[];
    eventos: Evento[];
    urgenciaAtendimentos: UrgenciaAtendimento[];
};
