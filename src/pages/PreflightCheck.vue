<template>
  <q-card class="container">
    <div class="section row justify-between">
      <div class="">
        <div class="flight_number">
          {{ my_airline.abbreviation }} Gate
          {{ my_gate.gate_number }}
        </div>
        <div class="start_time">
          start time {{ formatTime(my_gate.start_time) }}
        </div>
      </div>
      <div class="">
        <q-btn
          icon="mdi-arrow-up"
          @click="next_gate"
          :disable="!next_gate_available"
        />
        <q-btn
          icon="mdi-arrow-down"
          @click="prev_gate"
          :disable="!prev_gate_available"
        />
      </div>
    </div>
    <SinglePreflightCheck :gate="my_gate" :key="my_gate.gate_number" />
  </q-card>
</template>

<script setup lang="ts">
import { onMounted, computed } from 'vue'
import { useAppState } from '../stores/appState'
import SinglePreflightCheck from '../components/SinglePreflightCheck.vue'
import dayjs from 'dayjs'
const store = useAppState()

onMounted(async () => {
  await store.load_gates()
  if (!store.selected_gate) {
    store.selected_gate = store.gates.filter(
      (gate) => gate.airline_id === store.selected_airline.id
    )[0]
  }
})
const my_airline = computed(() => store.selected_airline)
const my_gate = computed(() => store.selected_gate)

function formatTime(time: string) {
  // Handle cases where time might be null or undefined
  if (!time) return ''

  // Create a full date string for today with the time
  const today = dayjs().format('YYYY-MM-DD')
  const dateTime = `${today} ${time}`

  return dayjs(dateTime).format('hh:mm a')
}
const next_gate_available = computed(() => {
  const currentIndex = store.gates.indexOf(my_gate.value)
  return currentIndex < store.gates.length - 1 // Check if there's a next gate
})
const prev_gate_available = computed(() => {
  const currentIndex = store.gates.indexOf(my_gate.value)
  return currentIndex > 0 // Check if there's a previous gate
})
const next_gate = () => {
  const currentIndex = store.gates.indexOf(my_gate.value)
  if (currentIndex < store.gates.length - 1) {
    store.selected_gate = store.gates[currentIndex + 1]
  }
}

const prev_gate = () => {
  const currentIndex = store.gates.indexOf(my_gate.value)
  if (currentIndex > 0) {
    store.selected_gate = store.gates[currentIndex - 1]
  }
}
</script>

<style scoped>
.container {
  padding: 10px;
  width: 350px;
  background-color: #f0f0f0;
}

.section {
  border: 1px solid #b0b0b0;
  padding: 10px;
  margin-bottom: 10px;
  border-radius: 5px;
  background-color: #fff;
}
.flight_number {
  font-size: 1.5em;
  font-weight: bold;
  line-height: 1em;
}
.start_time {
  font-size: 1em;
  line-height: 1em;
}
</style>
