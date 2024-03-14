<script setup lang="ts">
import AuthorsListComponent from '@/components/AuthorsListComponent.vue';
import { Button } from '@/components/ui/button';



</script>

<template>
  <main class="p-5">
    <div class="p-5 flex justify-evenly items-center">
      <div class="text-5xl">
        Authors
      </div>
      <div>

      </div>
      <div>
        <RouterLink to="/">
          <Button class="text-2xl" variant="outline">
            Back
          </Button>
        </RouterLink>
      </div>
    </div>
    <div class="w-9/12 mx-auto mt-10">
        <AuthorsListComponent />
    </div>
  </main>
</template>
