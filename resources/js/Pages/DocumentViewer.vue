<template>
  <div>
    <embed :src="pdfUrl" type="application/pdf" width="100%" height="600px" />
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  setup() {
    const pdfUrl = ref(null);

    const loadPdf = async () => {
      const response = await fetch('/document/preview/', {
        method: 'POST',
        body: JSON.stringify({
          nome: 'doidera',
          dates: ['2022-01-01', '2022-01-02'],
          conteudo: 'Conteúdo',
        }),
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
      });

      if (response.ok) {
        const blob = await response.blob();
        pdfUrl.value = URL.createObjectURL(blob);
      }
    };

    loadPdf();

    return { pdfUrl };
  },
};
</script>