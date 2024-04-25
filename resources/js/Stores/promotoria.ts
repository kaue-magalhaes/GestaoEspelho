import { defineStore } from 'pinia';
import axios from 'axios';
import {Promotoria} from "@/Interfaces/Promotoria";


export const usePromotoriaStore = defineStore('promotoria', () => {
    const getPromotorias = async (): Promise<Promotoria[]> => {
        const response = await axios.get<Promotoria[]>('http://localhost:8000/api/promotorias');
        return response.data;
    }

    return {
        getPromotorias,
    };
});
