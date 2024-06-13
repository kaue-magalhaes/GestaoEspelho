import { defineStore } from "pinia";
import { ref } from "vue";
import {Espelho} from "@/Interfaces/Espelho/Espelho";

export const useEspelhoStore = defineStore("espelho", () => {

    const espelho = ref<Espelho>();
    const loading = ref(false);

    async function getEspelhos() {
        try {
            loading.value = true;
            const response = await fetch('/api/espelho');
            const responseValue: Espelho = await response.json();
            espelho.value = responseValue;
        } catch (error) {
            console.error(error);
        } finally {
            loading.value = false;
        }
    }

    return {
        espelho,
        loading,
        getEspelhos,
    };
});
