<script setup lang="ts">
import AuthorFormComponent from '@/components/AuthorFormComponent.vue';
import NewsFormComponent from '@/components/NewsFormComponent.vue';
import NewsListComponent from '@/components/NewsListComponent.vue';
import RankComponent from '@/components/RankComponent.vue';
import { ref } from 'vue';

const rank = ref(null);
const news = ref(null);
const rankRefresh = () => {
  rank.value?.fetchData();
  news.value?.fetchData();
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
      <div>
        <AuthorFormComponent />
      </div>
    </div>
    <div class="w-9/12 mx-auto mt-10">
      <NewsListComponent ref="news"/>
    </div>
  </main>
</template>
