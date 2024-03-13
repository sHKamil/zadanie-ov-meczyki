<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import Toaster from '@/components/ui/toast/Toaster.vue'
</script>

<template>
  <main class="">
    <header>
      <!-- <div class="wrapper">
        <nav>
          <RouterLink to="/">Home</RouterLink>
        </nav>
      </div> -->
    </header>

    <RouterView />
    <Toaster />
  </main>
</template>

<style scoped>

</style>
