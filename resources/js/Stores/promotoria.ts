import { defineStore } from 'pinia';
import axios from 'axios';
import {PromotoriasPaginate} from "@/Interfaces/Promotoria/PromotoriaPaginate";


export const usePromotoriaStore = defineStore('promotoria', () => {
    const getPromotorias = async (): Promise<PromotoriasPaginate> => {
        const response = await axios.get<PromotoriasPaginate>('http://localhost:8000/api/promotorias');
        return response.data;
    }

    return {
        getPromotorias,
    };
});
