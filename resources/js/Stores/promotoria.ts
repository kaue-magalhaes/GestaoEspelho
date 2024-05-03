import {defineStore} from 'pinia';
import {router} from "@inertiajs/vue3";


export const usePromotoriaStore = defineStore('promotoria', () => {

    function editPromotoria(id: string, request: any) {
        router.put(route('promotoria.update', id), request);
    }

    function deletePromotoria(id: string) {
        router.delete(route('promotoria.destroy', id));
    }

    return {
        editPromotoria,
        deletePromotoria
    };
});
