<template>
  <q-card class="container">
    <div class="section">
      <div class="row align-center">
        <q-btn
          icon="mdi-microphone-plus"
          :outline="gate_check.audio_status != 'good'"
          :disable="not_running"
          color="positive"
          @click="sound_check_good"
        ></q-btn>
        <div class="row align-center">
          <div class="col q-px-sm q-pt-xs" style="line-height: 1em">
            <div class="">Sound</div>
            <div class="">check</div>
          </div>
          <div class="q-pt-sm q-mr-md">
            <q-icon size="20px" name="mdi-information-outline">
              <q-tooltip>
                Speak "Check 1,2,3" into the microphone.<br />
                Voice recognition will mark the audio as good.
              </q-tooltip>
            </q-icon>
          </div>
        </div>
        <q-btn
          icon="mdi-microphone-off"
          :outline="gate_check.audio_status != 'bad'"
          color="negative"
          @click="sound_check_bad"
        ></q-btn>
        <q-btn
          class="q-ml-md"
          icon="mdi-cancel"
          :outline="!not_running"
          color="grey"
          @click="set_not_running"
        >
          <div
            style="
              font-size: 0.8em;
              text-transform: none;
              width: 30px;
              line-height: 1em;
            "
          >
            Not running
          </div>
        </q-btn>
      </div>
    </div>
    <div class="section">
      <div class="row align-center">
        <q-btn
          icon="mdi-video-plus"
          :outline="gate_check.video_status != 'good'"
          color="positive"
          @click="video_check_good"
          :disable="not_running"
        ></q-btn>
        <div class="row align-center">
          <div class="col q-px-sm q-pt-xs" style="line-height: 1em">
            <div class="">Video</div>
            <div class="">check</div>
          </div>
          <div class="q-pt-sm q-mr-md">
            <q-icon size="20px" name="mdi-information-outline">
              <q-tooltip>
                <div class="" style="width: 200px">
                  Click the "Good" button to mark the video as good and capture
                  a thumbnail of the video
                </div>
              </q-tooltip>
            </q-icon>
          </div>
        </div>
        <q-btn
          icon="mdi-video-off"
          :outline="gate_check.video_status != 'bad'"
          color="negative"
          @click="video_check_bad"
          :disable="not_running"
        ></q-btn>
        <div class="video_preview">
          <q-img src="jetbridge.gif" />
        </div>
      </div>
    </div>
    <div class="section">
      <div class="row align-center">
        <q-btn
          icon="mdi-airplane-check"
          :outline="gate_check.first_flight_verified != 'good'"
          color="positive"
          @click="flight_check_good"
          :disable="not_running"
        ></q-btn>
        <div class="row align-center">
          <div class="col q-px-sm q-pt-xs" style="line-height: 1em">
            <div class="">First</div>
            <div class="">flight</div>
          </div>
          <div class="q-pt-sm q-mr-md">
            <q-icon size="20px" name="mdi-information-outline">
              <q-tooltip> Verify the vehicle image is correct. </q-tooltip>
            </q-icon>
          </div>
        </div>
        <q-btn
          icon="mdi-airplane-alert"
          :outline="gate_check.first_flight_verified != 'bad'"
          color="negative"
          @click="flight_check_bad"
          :disable="not_running"
        ></q-btn>
        <div class="flight_preview">
          <q-img :src="plane_image" />
        </div>
      </div>
    </div>
  </q-card>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import type { GateCheck } from '../types/gate_check.interface'
import axios from 'axios'
import { useAppState } from '../stores/appState'
const store = useAppState()
// const props = defineProps({
//   gate: {
//     type: Object as PropType<Gate>,
//     default: () => ({}),
//   },
// })
onMounted(() => {
  get_gate_check()
})
const gate_check = ref({} as GateCheck)

async function get_gate_check() {
  try {
    const response = await axios.post(
      `${import.meta.env.VITE_API_URL}get_gate_check.php`,
      {
        airline_id: store.selected_airline.id,
        gate_number: store.selected_gate.gate_number,
        gate_id: store.selected_gate.id,
      }
    )
    console.log(response.data)
    gate_check.value = response.data
  } catch (error) {
    console.error('Error fetching gate check:', error)
  }
}
const not_running = ref(false)
async function set_not_running() {
  not_running.value = !not_running.value
  if (not_running.value) {
    gate_check.value.audio_status = 'not_running'
  } else {
    gate_check.value.audio_status = 'unknown'
  }
  await update_gate_check()
}
const plane_image = computed(() => {
  //between 1 and 8
  const random_number = Math.floor(Math.random() * 8) + 1
  return `plane${random_number}.jpg`
})

function sound_check_good() {
  if (gate_check.value.audio_status === 'good') {
    gate_check.value.audio_status = 'unknown'
  } else {
    gate_check.value.audio_status = 'good'
  }
  update_gate_check()
}

function sound_check_bad() {
  if (gate_check.value.audio_status === 'bad') {
    gate_check.value.audio_status = 'unknown'
  } else {
    gate_check.value.audio_status = 'bad'
  }
  update_gate_check()
}

function video_check_good() {
  if (gate_check.value.video_status === 'good') {
    gate_check.value.video_status = 'unknown'
  } else {
    gate_check.value.video_status = 'good'
  }
  update_gate_check()
}

function video_check_bad() {
  if (gate_check.value.video_status === 'bad') {
    gate_check.value.video_status = 'unknown'
  } else {
    gate_check.value.video_status = 'bad'
  }
  update_gate_check()
}

function flight_check_good() {
  if (gate_check.value.first_flight_verified === 'good') {
    gate_check.value.first_flight_verified = 'unknown'
  } else {
    gate_check.value.first_flight_verified = 'good'
  }
  update_gate_check()
}

function flight_check_bad() {
  if (gate_check.value.first_flight_verified === 'bad') {
    gate_check.value.first_flight_verified = 'unknown'
  } else {
    gate_check.value.first_flight_verified = 'bad'
  }
  update_gate_check()
}

async function update_gate_check() {
  try {
    const response = await axios.post(
      `${import.meta.env.VITE_API_URL}update_gate_check.php`,
      {
        gate_id: store.selected_gate.id,
        gate_check: gate_check.value,
      }
    )
    console.log(response.data)
  } catch (error) {
    console.error('Error updating gate check:', error)
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
