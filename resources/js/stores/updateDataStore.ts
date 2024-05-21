import {defineStore} from "pinia";
import {ref} from "vue";

import {toast} from "vue-sonner";
import {getCsrfToken} from "@/utils/csrfToken";
import {useEspelhoStore} from "@/stores/espelhoStore";
import {useUrgenciaAtendimentosStore} from "@/stores/urgenciaAtendimentoStore";

export const useUpdateDataStore = defineStore("updateData", () => {

    const existsChanges = ref(false);
    const loading = ref(false);
    const errors = ref<string[]>([]);

    async function saveChanges(id: string) {
        const espelhoStore = useEspelhoStore();
        const urgenciaAtendimentosStore = useUrgenciaAtendimentosStore();
        try {
            if (urgenciaAtendimentosStore.dataNotChanged.length > 0) {
                errors.value = [...urgenciaAtendimentosStore.dataNotChanged];
                toast.error('Existem campos não preenchidos!');
                throw new Error('Existem campos vazios!');
            }
            loading.value = true;
            await fetch(`/espelho/${id}`, {
                method: 'PUT',
                body: JSON.stringify({
                    espelho: espelhoStore.espelho,
                    urgenciaAtendimentos: urgenciaAtendimentosStore.urgenciaAtendimentos.data
                }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                }
            });
            toast.success('Alteração foi salva com sucesso!');
        } catch (error) {
            console.error(error);
        } finally {
            loading.value = false;
            existsChanges.value = false;
        }
    }

    return {
        existsChanges,
        loading,
        errors,
        saveChanges,
    };
});
