<template>
  <div>
    <h6>Airline Dashboard</h6>
    <p>Zone: {{ store.selected_zone }}</p>
    <div class="row">
      <div v-for="airline in airlines" :key="airline.airline_id">
        <SingleAirline :airline="airline" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref, watch } from 'vue'
import axios from 'axios'
import { useAppState } from 'src/stores/appState'
import SingleAirline from 'src/components/SingleAirline.vue'
const store = useAppState()
const airlines = ref<any[]>([])

onMounted(() => {
  getAirlines()
})
watch(
  () => store.selected_zone,
  () => {
    getAirlines()
  },
  { immediate: true }
)
async function getAirlines() {
  try {
    const response = await axios.post(
      `${import.meta.env.VITE_API_URL}load_airlines.php`,
      {
        zone: store.selected_zone,
      },
      {
        headers: {
          'Content-Type': 'application/json',
        },
      }
    )
    console.log(response.data)
    airlines.value = response.data
  } catch (error) {
    console.error(error)
  }
}
</script>
