<script setup lang="ts">
import { ref, PropType, watch } from 'vue'

import { cn } from '@/lib/utils'
import { format } from 'date-fns';

import { Button } from '@/Components/ui/button';
import { Calendar } from '@/Components/ui/calendar'
import {Popover, PopoverContent, PopoverTrigger} from '@/Components/ui/popover'

import { Calendar as CalendarIcon } from 'lucide-vue-next';

const emit = defineEmits(['update:period'])

const props = defineProps({
  period: {
    type: Object as PropType<{ start: Date; end: Date }>,
    default: () => ({ start: null, end: null }),
  },

  range: {
    type: Boolean,
    default: false,
  },
})

const localPeriod = ref(props.period)

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
          )"
        >
          <CalendarIcon class="mr-2 h-4 w-4" />

          <span>
            {{ localPeriod.start ? (
              localPeriod.end ? `${format(localPeriod.start, 'LLL dd, y')} - ${format(localPeriod.end, 'LLL dd, y')}`
              : format(localPeriod.start, 'LLL dd, y')
            ) : 'Selecione o periodo' }}
          </span>
        </Button>
        <Button
          v-else
          id="date"
          :variant="'outline'"
          :class="cn(
            'w-[300px] justify-start text-left font-normal',
            !localPeriod && 'text-muted-foreground',
          )"
        >
          <CalendarIcon class="mr-2 h-4 w-4" />

          <span>
            {{ localPeriod.start ? format(localPeriod.start, 'LLL dd, y') : 'Selecione a data' }}
          </span>
        </Button>
      </PopoverTrigger>
      <PopoverContent class="w-auto p-0" align="start">
        <Calendar
          v-if="props.range"
          v-model.range="localPeriod"
          :columns="2"
          @update:model-value="emit('update:period', $event)"
        />
        <Calendar
          v-else
          v-model="localPeriod.start"
          :columns="1"
          @update:model-value="emit('update:period', $event)"
        />
      </PopoverContent>
    </Popover>
  </div>
</template>