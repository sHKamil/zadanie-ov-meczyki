<script setup lang="ts">
import NewsFormComponent from '@/components/NewsFormComponent.vue';
import RankComponent from '@/components/RankComponent.vue';
import { ref } from 'vue';

const rank = ref(null);
const rankRefresh = () => {
  rank.value?.fetchData();
};

</script>

<template>
  <main>
    <div class="p-5 flex justify-evenly">
      <div>
        <RankComponent ref="rank" />
      </div>
      <div>
        <NewsFormComponent @refresh="rankRefresh"/>
      </div>

    </div>
    <div>
      
    </div>
  </main>
</template>
