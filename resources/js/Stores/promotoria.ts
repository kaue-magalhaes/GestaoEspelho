import {defineStore} from 'pinia';
import axios from 'axios';
import {PromotoriasPaginate} from "@/Interfaces/Promotoria/PromotoriaPaginate";
import {router} from "@inertiajs/vue3";


export const usePromotoriaStore = defineStore('promotoria', () => {

    const getPromotorias = async (): Promise<PromotoriasPaginate> => {
        const response = await axios.get<PromotoriasPaginate>('http://localhost:8000/api/promotorias');
        return response.data;
    }

    function deletePromotoria(id: string) {
        router.delete(route('promotoria.destroy', id));
    }

    return {
        getPromotorias,
        deletePromotoria
    };
});
