<template>
  <q-card class="my-card">
    <q-card-section class="q-pa-xs">
      <div class="row align-center">
        <div class="q-my-none text-bold q-pt-xs" style="width: 40px">
          {{ props.airline.abbreviation }}
        </div>
        <div
          class="q-mb-none"
          style="
            width: 120px;
            height: 30px;
            line-height: 1.1em;
            font-size: 0.9em;
          "
        >
          {{ props.airline.name }}
        </div>
        <q-btn flat round icon="mdi-refresh" @click="reset" />
      </div>
      <div class="gate" v-for="gate in gates" :key="gate.id">
        <SingleGate
          :passed_gate="gate"
          :airline="props.airline"
          :gate_number="Number(gate.gate_number)"
        />
      </div>
    </q-card-section>
  </q-card>
</template>

<script setup lang="ts">
import { ref, onMounted, PropType } from 'vue'
import axios from 'axios'

import SingleGate from './SingleGate.vue'
import { Gate } from '../types/gate.interface'
import { Airline } from '../types/airline.interface'
// import { Terminal } from '../types/terminal.interface'

// const terminals = ref<Terminal[]>([])
const gates = ref<Gate[]>([])
const props = defineProps({
  airline: {
    type: Object as PropType<Airline>,
    required: true,
  },
})

onMounted(() => {
  get_gates()
})

// async function getTerminals() {
//   try {
//     const response = await fetch(
//       `${import.meta.env.VITE_API_URL}load_terminals.php`,
//       {
//         method: 'POST',
//         body: JSON.stringify({ airline_id: props.airline.id }),
//       }
//     )
//     const data = await response.json()
//     terminals.value = data
//   } catch (error) {
//     console.error(error)
//   }
// }
async function get_gates() {
  try {
    const response = await axios.post(
      `${import.meta.env.VITE_API_URL}load_gates.php`,
      {
        airline_id: props.airline.id,
      }
    )
    console.log(response.data)
    gates.value = response.data
  } catch (error) {
    console.error(error)
  }
}
async function reset() {
  try {
    const response = await axios.post(
      `${import.meta.env.VITE_API_URL}reset.php`,
      { airline_id: props.airline.id }
    )
    console.log(response)
  } catch (error) {
    console.error(error)
  }
}
</script>

<style scoped>
.my-card {
  width: 220px;
  max-width: 220px;
  padding: 0px;
  background-color: #ffffff;
}
</style>
