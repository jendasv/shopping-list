<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <div class="min-h-screen flex justify-center <!--bg-stone-100-->">
    <main class="paper w-full max-w-xl min-h-screen p-8 shadow-xl relative">
      <RouterView />
    </main>
  </div>
</template>

<style scoped lang="scss">

.paper {
  background: #fff9d6; /* nažloutlý papír */

  border-radius: 4px;

  /* jemná textura papíru */
  background-image:
    radial-gradient(rgba(0,0,0,0.03) 1px, transparent 1px);

  background-size: 4px 4px;

  /* jemný stín */
  box-shadow:
    0 8px 20px rgba(0,0,0,0.15),
    0 2px 4px rgba(0,0,0,0.08);
}
</style>
