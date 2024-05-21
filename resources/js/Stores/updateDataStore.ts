import { defineStore } from "pinia";
import {ref} from "vue";

export const useUpdateDataStore = defineStore("updateData", () => {

    const existsChanges = ref(false);
    const loading = ref(false);


    return {
        existsChanges,
        loading,
    };
});
