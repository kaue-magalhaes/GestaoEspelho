import './bootstrap';
import '../css/app.css';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Preview from '@/Components/EspelhoComponents/Preview.vue';
import Editor from '@/Components/EspelhoComponents/Editor.vue';

import EntranciaFinalSantanaEditor from '@/Components/EspelhoComponents/EditorComponents/EntranciaFinalSantanaEditor.vue';
import EntranciaFinalMacapaEditor from '@/Components/EspelhoComponents/EditorComponents/EntranciaFinalMacapaEditor.vue';
import EntranciaInicialEditor from '@/Components/EspelhoComponents/EditorComponents/EntranciaInicialEditor.vue';

import PlantaoCaraterUrgenciaEditor from '@/Components/EspelhoComponents/EditorComponents/PlantaoCaraterUrgenciaEditor.vue';
import TabelaPromotoriaEditor from '@/Components/EspelhoComponents/EditorComponents/TabelaPromotoriaEditor.vue';

import EntranciaFinalMacapaPreview from '@/Components/EspelhoComponents/PreviewComponents/EntranciaFinalMacapaPreview.vue';
import EntranciaFinalSantanaPreview from '@/Components/EspelhoComponents/PreviewComponents/EntranciaFinalSantanaPreview.vue';
import EntranciaInicialPreview from '@/Components/EspelhoComponents/PreviewComponents/EntranciaInicialPreview.vue'
import TabelaPromotoresSubstitutosPreview from '@/Components/EspelhoComponents/PreviewComponents/TabelaPromotoresSubstitutosPreview.vue';

import PlantaoCaraterUrgenciaPreview from "@/Components/EspelhoComponents/PreviewComponents/PlantaoCaraterUrgenciaPreview.vue";
import TabelaPromotoriaPreview from '@/Components/EspelhoComponents/PreviewComponents/TabelaPromotoriaPreview.vue';

import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger} from '@/Components/ui/alert-dialog'
import { Dialog, DialogContent, DialogTrigger, DialogHeader, DialogTitle, DialogDescription, DialogFooter } from '@/Components/ui/dialog';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue} from '@/Components/ui/select';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/Components/ui/carousel';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import DatePicker from '@/Components/DatePicker.vue';


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .component('AuthenticatedLayout', AuthenticatedLayout)
            .component('Preview', Preview)
            .component('Editor', Editor)
            .component('EntranciaFinalSantanaEditor', EntranciaFinalSantanaEditor)
            .component('EntranciaFinalMacapaEditor', EntranciaFinalMacapaEditor)
            .component('EntranciaInicialEditor', EntranciaInicialEditor)
            .component('PlantaoCaraterUrgenciaEditor', PlantaoCaraterUrgenciaEditor)
            .component('TabelaPromotoriaEditor', TabelaPromotoriaEditor)
            .component('EntranciaFinalMacapaPreview', EntranciaFinalMacapaPreview)
            .component('EntranciaFinalSantanaPreview', EntranciaFinalSantanaPreview)
            .component('EntranciaInicialPreview', EntranciaInicialPreview)
            .component('TabelaPromotoresSubstitutosPreview', TabelaPromotoresSubstitutosPreview)
            .component('PlantaoCaraterUrgenciaPreview', PlantaoCaraterUrgenciaPreview)
            .component('TabelaPromotoriaPreview', TabelaPromotoriaPreview)
            .component('AlertDialog', AlertDialog)
            .component('AlertDialogAction', AlertDialogAction)
            .component('AlertDialogCancel', AlertDialogCancel)
            .component('AlertDialogContent', AlertDialogContent)
            .component('AlertDialogDescription', AlertDialogDescription)
            .component('AlertDialogFooter', AlertDialogFooter)
            .component('AlertDialogHeader', AlertDialogHeader)
            .component('AlertDialogTitle', AlertDialogTitle)
            .component('AlertDialogTrigger', AlertDialogTrigger)
            .component('Dialog', Dialog)
            .component('DialogContent', DialogContent)
            .component('DialogTrigger', DialogTrigger)
            .component('DialogHeader', DialogHeader)
            .component('DialogTitle', DialogTitle)
            .component('DialogDescription', DialogDescription)
            .component('DialogFooter', DialogFooter)
            .component('Select', Select)
            .component('SelectContent', SelectContent)
            .component('SelectGroup', SelectGroup)
            .component('SelectItem', SelectItem)
            .component('SelectLabel', SelectLabel)
            .component('SelectTrigger', SelectTrigger)
            .component('SelectValue', SelectValue)
            .component('Carousel', Carousel)
            .component('CarouselContent', CarouselContent)
            .component('CarouselItem', CarouselItem)
            .component('CarouselNext', CarouselNext)
            .component('CarouselPrevious', CarouselPrevious)
            .component('Card', Card)
            .component('CardContent', CardContent)
            .component('CardHeader', CardHeader)
            .component('CardTitle', CardTitle)
            .component('Button', Button)
            .component('Input', Input)
            .component('Label', Label)
            .component('DatePicker', DatePicker)
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
