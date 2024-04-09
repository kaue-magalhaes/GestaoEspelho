<script setup lang="ts">
import {ref, watchEffect, onMounted} from 'vue'

import { cn } from '@/lib/utils'
import { format } from 'date-fns';

import { Button } from '@/Components/ui/button';
import { Calendar } from '@/Components/ui/calendar'
import {Popover, PopoverContent, PopoverTrigger} from '@/Components/ui/popover'

import { Calendar as CalendarIcon } from 'lucide-vue-next';

const emit = defineEmits(['update:period'])

const props = defineProps({
  period_start: {
    type: Date,
    default: new Date(),
  },
  period_end: {
    type: Date,
    default: new Date(),
  },
  range: {
    type: Boolean,
    default: false,
  },
  wasChanged: {
    type: Boolean,
    default: false,
  },
  isValidation: {
    type: Boolean,
    default: false,
  },
  placeholder: {
    type: String,
    default: '',
  },
})

const localPeriod = ref({
  start: props.period_start,
  end: props.period_end,
})
const wasChanged = ref(props.wasChanged)

const emitirMudanca = (value: any) => {
  wasChanged.value = true
  emit('update:period', value, wasChanged.value)
}

watchEffect(() => {
  localPeriod.value = {
    start: props.period_start,
    end: props.period_end,
  }
})

</script>

<template>
  <div :class="cn('grid gap-2', $attrs.class ?? '')">
    <Popover>
      <PopoverTrigger as-child>
        <Button
          v-if="props.range"
          id="date"
          :variant="'outline'"
          :class="cn(
            'w-[300px] justify-start text-left font-normal',
            !localPeriod && 'text-muted-foreground',
            props.isValidation && 'border-2 border-red-500 text-red-500',
          )"
        >
          <CalendarIcon class="mr-2 h-4 w-4" />

          <span>
            {{ localPeriod.start && wasChanged ? (
              localPeriod.end ? `${format(localPeriod.start, 'LLL dd, y')} - ${format(localPeriod.end, 'LLL dd, y')}`
              : format(localPeriod.start, 'LLL dd, y')
            ) : props.placeholder || 'Selecione o periodo' }}
          </span>
        </Button>
        <span v-if="props.isValidation" class="text-red-500 text-sm">Selecione o periodo</span>
      </PopoverTrigger>
      <PopoverContent class="w-auto p-0" align="start">
        <Calendar
          v-if="props.range"
          v-model.range="localPeriod"
          :columns="2"
          @update:model-value="emitirMudanca($event)"
        />
      </PopoverContent>
    </Popover>
  </div>
</template>
