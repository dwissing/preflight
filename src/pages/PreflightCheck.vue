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
        <q-btn icon="mdi-arrow-up" @click="next_gate" />
        <q-btn icon="mdi-arrow-down" @click="prev_gate" />
      </div>
    </div>
    <div class="section">
      <q-btn
        icon="mdi-microphone-plus"
        :outline="!sound_check || sound_check == undefined"
        color="positive"
        @click="sound_check_good"
      ></q-btn>
      Sound check
      <q-btn
        icon="mdi-microphone-off"
        :outline="sound_check == true || sound_check == undefined"
        color="negative"
        @click="sound_check_bad"
      ></q-btn>
    </div>
    <div class="section">
      <q-btn
        icon="mdi-video-plus"
        :outline="!video_check || video_check == undefined"
        color="positive"
        @click="video_check_good"
      ></q-btn>
      Video check
      <q-btn
        icon="mdi-video-off"
        :outline="video_check == true || video_check == undefined"
        color="negative"
        @click="video_check_bad"
      ></q-btn>
      <div class="video_preview">
        <q-img src="jetbridge.gif" />
      </div>
    </div>
    <div class="section">
      <q-btn
        icon="mdi-airplane-check"
        :outline="!flight_check || flight_check == undefined"
        color="positive"
        @click="flight_check_good"
      ></q-btn>
      First flight
      <q-btn
        icon="mdi-airplane-alert"
        :outline="flight_check == true || flight_check == undefined"
        color="negative"
        @click="flight_check_bad"
      ></q-btn>
      <div class="flight_preview">
        <q-img :src="plane_image" />
      </div>
    </div>
  </q-card>
</template>

<script setup lang="ts">
import { ref, onMounted, computed, watch } from 'vue'
import type { GateCheck } from '../types/gate_check.interface'
import { useAppState } from '../stores/appState'
import dayjs from 'dayjs'
const store = useAppState()
const props = defineProps({
  gate_check: {
    type: Object as PropType<GateCheck>,
    default: () => ({}),
  },
})

onMounted(() => {
  store.load_gates()
})
const my_airline = computed(() => store.selected_airline)
const my_gate = computed(() => store.selected_gate)
const sound_check = ref(props.gate_check.audio_status)
const video_check = ref(props.gate_check.video_status)
const flight_check = ref(props.gate_check.dvr_status)
const plane_image = ref('plane1.jpg')
watch(my_gate, () => {
  create_random_plane_image()
})
function formatTime(time: string) {
  // Handle cases where time might be null or undefined
  if (!time) return ''

  // Create a full date string for today with the time
  const today = dayjs().format('YYYY-MM-DD')
  const dateTime = `${today} ${time}`

  return dayjs(dateTime).format('hh:mm a')
}
function create_random_plane_image() {
  //between 1 and 8
  const random_number = Math.floor(Math.random() * 8) + 1
  plane_image.value = `plane${random_number}.jpg`
}
const next_gate = () => {
  store.selected_gate = store.gates[store.gates.indexOf(my_gate.value) + 1]
}

const prev_gate = () => {
  store.selected_gate = store.gates[store.gates.indexOf(my_gate.value) - 1]
}

const sound_check_good = () => {
  if (sound_check.value === true) {
    sound_check.value = undefined
  } else {
    sound_check.value = true
  }
}

const sound_check_bad = () => {
  if (sound_check.value === false) {
    sound_check.value = undefined
  } else {
    sound_check.value = false
  }
}

const video_check_good = () => {
  if (video_check.value === true) {
    video_check.value = undefined
  } else {
    video_check.value = true
  }
}

const video_check_bad = () => {
  if (video_check.value === false) {
    video_check.value = undefined
  } else {
    video_check.value = false
  }
}

const flight_check_good = () => {
  if (flight_check.value === true) {
    flight_check.value = undefined
  } else {
    flight_check.value = true
  }
}

const flight_check_bad = () => {
  if (flight_check.value === false) {
    flight_check.value = undefined
  } else {
    flight_check.value = false
  }
}
</script>

<style scoped>
.container {
  padding: 10px;
  width: 350px;
  background-color: #f0f0f0;
}
.video_preview {
  width: 200px;
  height: 200px;
  object-fit: cover;
}
.flight_preview {
  width: 200px;
  height: 200px;
  object-fit: cover;
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
