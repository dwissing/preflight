<template>
  <q-card>
    <div class="row">
      <q-card-section class="col-6">
        <h6>Today's terminals</h6>
        {{ today }}
        <div class="row">
          <div
            v-for="airline in todays_airlines"
            :key="airline.airline_id"
            class="airline"
          >
            <SingleAirline :airline="airline" />
          </div>
        </div>
      </q-card-section>
      <q-card-section class="col-6">
        <h6>Tomorrow's terminals</h6>
        <div class="row">
          <div
            v-for="airline in tomorrows_airlines"
            :key="airline.airline_id"
            class="airline"
          >
            <SingleAirline :airline="airline" />
          </div>
        </div>
      </q-card-section>
    </div>
  </q-card>
</template>

<script setup lang="ts">
import { onMounted, ref, watch, computed } from 'vue'
import dayjs from 'dayjs'
import axios from 'axios'
import { useAppState } from 'src/stores/appState'
import type { Airline } from 'src/types/airline.interface'
import SingleAirline from 'src/components/SingleAirline.vue'
const store = useAppState()
const airlines = ref<Airline[]>([])

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
const today = computed(() => dayjs().format('dddd').toLowerCase())
const tomorrow = computed(() =>
  dayjs().add(1, 'day').format('dddd').toLowerCase()
)
const todays_airlines = computed(() =>
  airlines.value.filter((airline) => {
    const dayKey = today.value as keyof typeof airline
    return airline[dayKey] !== null
  })
)
const tomorrows_airlines = computed(() =>
  airlines.value.filter((airline) => {
    const dayKey = tomorrow.value as keyof typeof airline
    return airline[dayKey] !== null
  })
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

<style scoped>
.airline {
  width: 200px;
  max-width: 300px;
}
</style>
