import { defineStore } from "pinia";
import {reactive, ref} from "vue";
import {UrgenciaAtendimentos} from "@/Interfaces/UrgenciaAtendimento/UrgenciaAtendimentos";

export const useUrgenciaAtendimentosStore = defineStore("urgenciaAtendimentos", () => {
    const urgenciaAtendimentos = reactive<UrgenciaAtendimentos>({
        data: [],
    });
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
        }
    }

    return {
        urgenciaAtendimentos,
        loading,
        getUrgenciaAtendimentos
    };
});
