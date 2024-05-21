import { defineStore } from "pinia";
import {reactive, ref, watch} from "vue";
import {UrgenciaAtendimentos} from "@/Interfaces/UrgenciaAtendimento/UrgenciaAtendimentos";
import {useUpdateDataStore} from "@/stores/updateDataStore";

import { v4 as uuidv4 } from 'uuid';
import {toast} from "vue-sonner";

export const useUrgenciaAtendimentosStore = defineStore("urgenciaAtendimentos", () => {
    const urgenciaAtendimentos = reactive<UrgenciaAtendimentos>({
        data: [],
    });
    const dataNotChanged = ref<string[]>([]);
    const loading = ref(false);

    async function getUrgenciaAtendimentos() {
        try {
            loading.value = true;
            const response = await fetch('/api/urgencia-atendimentos');
            const responseValue = await response.json();
            urgenciaAtendimentos.data = responseValue.data;
        } catch (error) {
            console.error(error);
        } finally {
            loading.value = false;
            watch(urgenciaAtendimentos, (newVal, oldVal) => {
                const updateDataStore = useUpdateDataStore();
                updateDataStore.existsChanges = true;
            });
        }
    }

    function addNewUrgenciaAtendimento() {
        if (dataNotChanged.value.length > 0) {
            toast.warning('Termine de preencher o campo atual!');
            return;
        }

        const newData = {
            id: uuidv4(),
            periodo_inicio: new Date(),
            periodo_fim: new Date(),
            promotor_designado_id: '',
        }

        urgenciaAtendimentos.data.push(newData);
        dataNotChanged.value.push(newData.id);
    }

    function removeUrgenciaAtendimento(id: string) {
        const index = urgenciaAtendimentos.data.findIndex((item) => item.id === id);
        if (index !== -1) {
            urgenciaAtendimentos.data.splice(index, 1);
        }
        removeDataNotChanged(id);
    }

    function removeDataNotChanged(id: string) {
        if (dataNotChanged.value.includes(id)) {
            const indexDataNotChanged = dataNotChanged.value.findIndex((item) => item === id);
            dataNotChanged.value.splice(indexDataNotChanged, 1);
        }

        if (existsInErrosArray(id)) {
            const updateDataStore = useUpdateDataStore();
            const indexErrors = updateDataStore.errors.findIndex((item) => item === id);
            updateDataStore.errors.splice(indexErrors, 1);
        }
    }

    function existsInErrosArray(id: string) {
        const updateDataStore = useUpdateDataStore();

        return updateDataStore.errors.includes(id);
    }

    return {
        urgenciaAtendimentos,
        loading,
        dataNotChanged,
        getUrgenciaAtendimentos,
        addNewUrgenciaAtendimento,
        removeUrgenciaAtendimento,
        removeDataNotChanged,
        existsInErrosArray,
    };
});
