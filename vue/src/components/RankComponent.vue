<script setup lang="ts">
import Card from './ui/card/Card.vue';
import CardContent from './ui/card/CardContent.vue';
import CardDescription from './ui/card/CardDescription.vue';
import CardHeader from './ui/card/CardHeader.vue';
import CardTitle from './ui/card/CardTitle.vue';
import type { AuthorInRank } from '@/utils/types/AuthorInRankType';
import { ref } from 'vue';
import { GetBackendUrl } from '@/utils/GetBackendUrl';

let position = 1;
const rank = ref<AuthorInRank[] | null>(null);
const url = GetBackendUrl();

async function fetchData(top: number = 3) {
  rank.value = null;
  position = 1;
  const res = await fetch(
    url + '/author/top/' + top
  )
  rank.value = await res.json();
}

fetchData(3)

defineExpose({
  fetchData,
});
</script>

<template>
  <main>
    <Card class="w-fit rounded-2xl p-2">
        <CardHeader>
        <CardTitle>Weekly Rank</CardTitle>
        <CardDescription>Top 3 writers in this week</CardDescription>
        </CardHeader>
        <CardContent v-if="!rank">
          <hr>
            <div class="w-full flex justify-between">
              <div class="w-fit">
                Loading...
              </div>
            </div>
          <hr>
        </CardContent>
        <CardContent v-for="author in rank">
          <hr>
            <div class="w-full flex justify-between">
              <div class="w-fit">
                {{position++}}. {{ author.name }}
              </div>
              <div class="w-fit">
                {{ author.news_count }}
              </div>
            </div>
          <hr>
        </CardContent>
    </Card>
  </main>
</template>
