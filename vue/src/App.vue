<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <main class="bg-background min-h-dvh">
    <header>
      <div class="wrapper">
        <nav>
          <RouterLink to="/">Home</RouterLink>
        </nav>
      </div>
    </header>

    <RouterView />
  </main>
</template>

<style scoped>

</style>
