<template>
  <q-dialog v-model="show">
    <q-card>
      <div class="row justify-center">
        <div class="text-h6 q-ml-sm">
          Preflight Check {{ store.selected_airline.abbreviation }} Gate
          {{ store.selected_gate.gate_number }}
        </div>
        <q-space></q-space>
        <q-btn flat round icon="mdi-close" @click="show = false" />
      </div>
      <SinglePreflightCheck />
    </q-card>
  </q-dialog>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import SinglePreflightCheck from './SinglePreflightCheck.vue'
import { useAppState } from '../stores/appState'
const store = useAppState()
const show = ref(true)
</script>
