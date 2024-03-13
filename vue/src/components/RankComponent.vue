<script setup lang="ts">
import { useRankAuthors } from '@/composable/useRankAuthors';
import Card from './ui/card/Card.vue';
import CardContent from './ui/card/CardContent.vue';
import CardDescription from './ui/card/CardDescription.vue';
import CardHeader from './ui/card/CardHeader.vue';
import CardTitle from './ui/card/CardTitle.vue';


const authors = useRankAuthors(3);




</script>

<template>
  <main>
    <Card class="w-fit rounded-2xl p-2">
        <CardHeader>
        <CardTitle>Weekly Rank</CardTitle>
        <CardDescription>Top 3 writers in this week</CardDescription>
        </CardHeader>
        <CardContent v-for="author in authors.authors.data.value">
          <hr>
            <div class="w-full flex justify-between">
              <div class="w-fit">
                {{ author.name }}
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
