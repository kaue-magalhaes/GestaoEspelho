import {defineStore} from "pinia";
import {ref} from "vue";

import {toast} from "vue-sonner";

export const useUpdateDataStore = defineStore("updateData", () => {

    const existsChanges = ref(false);
    const loading = ref(false);

    async function saveChanges(id: number) {
        try {
            loading.value = true;
            await fetch(`/espelho/${id}`, {
                method: 'PUT',
                body: JSON.stringify({teste: 'teste', teste2: 'teste2'}),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
        } catch (error) {
            console.error(error);
        } finally {
            loading.value = false;
            existsChanges.value = false;

            toast.success('Alteração foi salva com sucesso!');
        }
    }

    return {
        existsChanges,
        loading,
        saveChanges
    };
});
