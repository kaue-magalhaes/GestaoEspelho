import {defineStore} from 'pinia';
import {router, usePage} from "@inertiajs/vue3";
import {toast} from "vue-sonner";


export const usePromotoriaStore = defineStore('promotoria', () => {

    function editPromotoria(id: string, request: any) {
        router.put(route('promotoria.update', id), request, {
            onFinish: () => {
                const successMessage = usePage().props.flash.success;
                if (successMessage) {
                    toast.success(`${successMessage}`);
                }
            },
        });
    }

    function deletePromotoria(id: string, nome: string) {
        router.delete(route('promotoria.destroy', id), {
            onFinish: () => {
                const successMessage = usePage().props.flash.success;
                if (successMessage) {
                    toast.success(`${successMessage}`);
                }
            },
        });
    }

    return {
        editPromotoria,
        deletePromotoria
    };
});
