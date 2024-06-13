import {useUpdateDataStore} from "@/stores/updateDataStore";

export function updateAnyPeriodo(dados: any, value: { start: Date; end: Date; }) {
    dados.periodo_inicio = value.start;
    dados.periodo_fim = value.end;

    const updateDataStore = useUpdateDataStore();
    updateDataStore.existsChanges = true;
}
