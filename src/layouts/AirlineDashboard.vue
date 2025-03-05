<template>
  <div>
    <h1>Airline Dashboard</h1>
    <p>Zone: {{ store.selected_zone }}</p>

    {{ airlines }}
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'
import axios from 'axios'
import { useAppState } from 'src/stores/appState'
const data = 'TESTING DATA'
const store = useAppState()
const airlines = ref<any[]>([])
const props = defineProps<{
  zone: string
}>()

onMounted(() => {
  getAirlines()
})

async function getAirlines() {
  try {
    const response = await axios.post(
      `${import.meta.env.VITE_API_URL}load_airlines.php`,
      {
        zone: data,
      }
    )
    console.log(response.data)
    airlines.value = response.data
  } catch (error) {
    console.error(error)
  }
}
</script>
