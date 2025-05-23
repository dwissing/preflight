<template>
  <div :class="get_row_class()">
    <div class="row align-center" @dblclick="open_preflight_check">
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
      <div class="clerk">
        <div class="">{{ gate_clerk.name }}</div>
        <div class="">{{ gate_clerk.phone }}</div>
      </div>
    </div>
    <PreflightCheckModal
      v-if="show_preflight_check"
      @hide="show_preflight_check = false"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, PropType, onMounted } from 'vue'
import dayjs from 'dayjs'
import axios from 'axios'
// import { useRouter } from 'vue-router'
import { useAppState } from '../stores/appState'
import PreflightCheckModal from './PreflightCheckModal.vue'
import { Gate } from '../types/gate.interface'
import { GateCheck } from '../types/gate_check.interface'
import { Airline } from '../types/airline.interface'
import { GateClerk } from '../types/gate_clerk.interface'
// const router = useRouter()
const store = useAppState()
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
const show_preflight_check = ref(false)
onMounted(() => {
  get_gate_check()
  get_gate_clerk()
})

function open_preflight_check() {
  store.selected_gate = gate.value
  show_preflight_check.value = true
  // router.push('/preflight-check')
}

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
  if (gate_check.value.first_flight_verified == 'good') {
    return 'good'
  } else if (gate_check.value.first_flight_verified == 'bad') {
    return 'unknown'
  } else {
    return 'unknown'
  }
}

function get_dvr_class() {
  if (gate_check.value.audio_status == 'good') {
    return 'good'
  } else if (gate_check.value.audio_status == 'bad') {
    return 'bad'
  } else {
    return 'unknown'
  }
}

function get_row_class() {
  if (
    gate_check.value.audio_status == 'good' &&
    gate_check.value.video_status == 'good' &&
    gate_check.value.first_flight_verified == 'good'
  ) {
    return 'gate-good gate-card'
  } else if (
    gate_check.value.audio_status == 'bad' ||
    gate_check.value.video_status == 'bad' ||
    gate_check.value.first_flight_verified == 'bad'
  ) {
    return 'gate-bad gate-card'
  } else if (gate_check.value.audio_status == 'not_running') {
    return 'not_running gate-card'
  } else {
    return 'gate-unknown gate-card'
  }
}

async function get_gate_check() {
  try {
    const response = await axios.post(
      `${import.meta.env.VITE_API_URL}get_gate_check.php`,
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
      `${import.meta.env.VITE_API_URL}create_gate_check.php`,
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
      `${import.meta.env.VITE_API_URL}get_gate_clerk.php`,
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
  width: 200px;
  max-width: 200px;
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
.gate-unknown {
  background-color: #fedda8;
  border-color: #ff9900;
}
.gate-bad {
  background-color: #ffb3b3;
  border-color: #ff0000;
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
.clerk {
  font-size: 0.8em;
  line-height: 0.9em;
  width: 80px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.not_running {
  color: #7a7a7a;
  background-color: #f0f0f0;
  border-color: #acacac;
}
</style>
