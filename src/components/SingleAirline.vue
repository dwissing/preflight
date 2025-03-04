<template>
  <div>
    <h1>{{ props.airline }}</h1>
  </div>
</template>

<script setup lang="ts">
import { useAppState } from 'src/stores/appState';

const store = useAppState();

const props = defineProps<{
  airline: string;
}>();
</script>

<style scoped></style>
