<template>
  <q-page class="row">
    <div class="info">
      This page contains no real information and is not associated with any real
      company.
    </div>
  </q-page>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import ExampleComponent from 'components/ExampleComponent.vue'

defineOptions({
  name: 'IndexPage',
})
</script>

<style scoped>
.info {
  font-size: 1.5rem;
  font-weight: bold;
  text-align: center;
  margin-top: 100px;
  margin-left: 100px;
}
</style>
