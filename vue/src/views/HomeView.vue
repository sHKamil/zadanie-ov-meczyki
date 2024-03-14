<script setup lang="ts">
import NewsFormComponent from '@/components/NewsFormComponent.vue';
import NewsListComponent from '@/components/NewsListComponent.vue';
import RankComponent from '@/components/RankComponent.vue';
import { ref } from 'vue';

const rank = ref(null);
const rankRefresh = () => {
  rank.value?.fetchData();
};

</script>

<template>
  <main class="p-5">
    <div class="p-5 flex justify-evenly">
      <div>
        <RankComponent ref="rank" />
      </div>
      <div>
        <NewsFormComponent @refresh="rankRefresh"/>
      </div>

    </div>
    <div class="w-9/12 mx-auto mt-10">
      <NewsListComponent />
    </div>
  </main>
</template>
