<script setup>
import { ArrowRight } from "lucide-vue-next";
import { useCarousel } from "./useCarousel";
import { cn } from "@/lib/utils";
import { Button } from "@/Components/ui/button";

const props = defineProps({
  class: { type: null, required: false },
});

const { orientation, canScrollNext, scrollNext } = useCarousel();
</script>

<template>
  <Button
    :disabled="!canScrollNext"
    :class="
      cn(
        'touch-manipulation absolute',
        orientation === 'horizontal'
          ? '-right-32 top-5 -translate-y-1/2'
          : '-bottom-12 left-1/2 -translate-x-1/2 rotate-90',
        !canScrollNext && 'hidden',
        props.class
      )
    "
    variant="outline"
    @click="scrollNext"
  >
    <slot>
      Preview <ArrowRight class="ml-2 h-4 w-4 text-current" />
    </slot>
  </Button>
</template>
