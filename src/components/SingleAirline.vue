<template>
  <q-card class="my-card">
    <q-card-section>
      <h6>{{ props.airline.abbreviation }}</h6>
      <p>{{ props.airline.name }}</p>
    </q-card-section>
  </q-card>
</template>

<script setup lang="ts">
import { ref, onMounted, PropType } from 'vue'
import { Airline } from '../types/airline.interface'
import { Terminal } from '../types/terminal.interface'

const terminals = ref<Terminal[]>([])

const props = defineProps({
  airline: {
    type: Object as PropType<Airline>,
    required: true,
  },
})

onMounted(() => {
  getTerminals()
})

async function getTerminals() {
  try {
    const response = await fetch(
      `${import.meta.env.VITE_API_URL}load_terminals.php`,
      {
        method: 'POST',
        body: JSON.stringify({ airline_id: props.airline.airline_id }),
      }
    )
    const data = await response.json()
    terminals.value = data
  } catch (error) {
    console.error(error)
  }
}
</script>

<style scoped>
.my-card {
  width: 300px;
  max-width: 300px;
}
</style>
