<script setup lang="ts">
import { ArrowLeft } from 'lucide-vue-next'
import { useCarousel } from './useCarousel'
import type { WithClassAsProps } from './interface'
import { cn } from '@/lib/utils'
import { Button } from '@/Components/ui/button'

const props = defineProps<WithClassAsProps>()

const { orientation, canScrollPrev, scrollPrev } = useCarousel()
</script>

<template>
  <Button
    :disabled="!canScrollPrev"
    :class="cn(
      'touch-manipulation absolute',
      orientation === 'horizontal'
        ? '-left-32 top-5 -translate-y-1/2'
        : '-top-12 left-1/2 -translate-x-1/2 rotate-90',
      !canScrollPrev && 'hidden',
      props.class,
    )"
    variant="outline"
    @click="scrollPrev"
  >
    <slot>
      <ArrowLeft class="h-4 w-4 text-current mr-2" /> Voltar
    </slot>
  </Button>
</template>
