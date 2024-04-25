import {defineStore} from "pinia";
import {ref} from "vue";

export const usePromotoriaStore = defineStore('promotoria', () => {

    const promotorias = ref([])
    function getPromotorias() {
        axios.get('/api/promotorias').then(response => {
            console.log(response.data);
            promotorias.value = response.data
        })
    }

    return {
        promotorias,
        getPromotorias
    }
})
