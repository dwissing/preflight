<template>
  <div :class="get_row_class()">
    <div class="row align-center">
      <div class="number">{{ gate.gate_number }}</div>
      <div class="">
        <div class="">
          {{ formatTime(gate.start_time) }}
        </div>
        <div class="row icons align-center justify-around">
          <q-icon
            size="20px"
            name="mdi-microphone"
            :class="get_audio_class()"
          />
          <q-icon size="20px" name="mdi-video" :class="get_video_class()" />
          <q-icon
            size="20px"
            name="mdi-airplane"
            :class="get_vehicle_class()"
          />
          <q-icon size="20px" name="mdi-vhs" :class="get_dvr_class()" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, PropType, onMounted } from 'vue'
import dayjs from 'dayjs'
import axios from 'axios'
import { Gate } from '../types/gate.interface'
import { GateCheck } from '../types/gate_check.interface'
import { Airline } from '../types/airline.interface'
import { GateClerk } from '../types/gate_clerk.interface'
// import { Terminal } from '../types/terminal.interface'
const props = defineProps({
  passed_gate: {
    type: Object as PropType<Gate>,
    required: true,
  },
  airline: {
    type: Object as PropType<Airline>,
    required: true,
  },
  gate_number: {
    type: Number,
    required: true,
  },
})
const gate_check = ref({} as GateCheck)
const gate_clerk = ref({} as GateClerk)
const gate = ref(props.passed_gate)

onMounted(() => {
  get_gate_check()
  get_gate_clerk()
})

function formatTime(time: string) {
  // Handle cases where time might be null or undefined
  if (!time) return ''

  // Create a full date string for today with the time
  const today = dayjs().format('YYYY-MM-DD')
  const dateTime = `${today} ${time}`

  return dayjs(dateTime).format('hh:mm a')
}

function get_audio_class() {
  if (gate_check.value.audio_status == 'good') {
    return 'good'
  } else if (gate_check.value.audio_status == 'bad') {
    return 'bad'
  } else {
    return 'unknown'
  }
}

function get_video_class() {
  if (gate_check.value.video_status == 'good') {
    return 'good'
  } else if (gate_check.value.video_status == 'bad') {
    return 'bad'
  } else {
    return 'unknown'
  }
}

function get_vehicle_class() {
  if (gate_check.value.first_flight_verified == true) {
    return 'good'
  } else if (gate_check.value.first_flight_verified == false) {
    return 'unknown'
  } else {
    return 'unknown'
  }
}

function get_dvr_class() {
  if (gate_check.value.dvr_status == 'good') {
    return 'good'
  } else if (gate_check.value.dvr_status == 'bad') {
    return 'bad'
  } else {
    return 'unknown'
  }
}

function get_row_class() {
  if (
    gate_check.value.audio_status == 'good' &&
    gate_check.value.video_status == 'good' &&
    gate_check.value.first_flight_verified == true
  ) {
    return 'gate-good gate-card'
  } else {
    return 'gate-bad gate-card'
  }
}

async function get_gate_check() {
  try {
    const response = await axios.post(
      `${process.env.VITE_API_URL}get_gate_check.php`,
      {
        airline_id: props.airline.id,
        gate_number: props.gate_number,
        gate_id: props.passed_gate.id,
      }
    )
    gate_check.value = response.data
    if (response.data == 'No gate check found') {
      create_gate_check()
    }
    console.log(gate_check.value)
  } catch (error) {
    console.error(error)
  }
}
async function create_gate_check() {
  try {
    const response = await axios.post(
      `${process.env.VITE_API_URL}create_gate_check.php`,
      {
        airline_id: props.airline.id,
        gate_number: props.gate_number,
        gate_id: props.passed_gate.id,
      }
    )
    console.log(response.data)
    gate_check.value = response.data
  } catch (error) {
    console.error(error)
  }
}
async function get_gate_clerk() {
  try {
    const response = await axios.post(
      `${process.env.VITE_API_URL}get_gate_clerk.php`,
      {
        gate_id: props.passed_gate.id,
      }
    )
    gate_clerk.value = response.data
    console.log(response.data)
  } catch (error) {
    console.error(error)
  }
}
</script>

<style scoped>
.gate-card {
  width: 192px;
  max-width: 192px;
  border: 1px solid #ccc;
  border-radius: 5px;
  line-height: 0.9em;
  padding: 3px 2px 3px 2px;
}
.bad {
  color: red;
}
.good {
  color: green;
}
.unknown {
  color: #acacac;
}
.gate-good {
  background-color: #bcffbc;
  border-color: #5eae58;
}
.gate-bad {
  background-color: #fedda8;
  border-color: #ff9900;
}
.icons {
  background-color: #fff;
  border-radius: 5px;
  padding: 2px;
}
.number {
  font-size: 1.2em;
  font-weight: bold;
  width: 25px;
  text-align: center;
  padding-left: 2px;
  padding-top: 14px;
}
</style>
