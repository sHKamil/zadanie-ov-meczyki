<script setup lang="ts">
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion'
import { GetBackendUrl } from '@/utils/GetBackendUrl';
import type { NewsWithAuthorsType } from '@/utils/types/NewsWithAuthorsType';
import { ref } from 'vue';
import { Badge } from './ui/badge';
import { Button } from './ui/button';
import NewsEditComponent from './NewsEditComponent.vue';
import NewsAuthorAddComponent from './NewsAuthorAddComponent.vue';

const defaultValue = '0';

const articles = ref<NewsWithAuthorsType[] | null>(null);
const url = GetBackendUrl();

async function fetchData() {
  articles.value = null;
  const res = await fetch(
    url + '/news'
  )
  articles.value = await res.json();
}

fetchData()

defineExpose({
  fetchData,
});

</script>

<template>
  <Accordion type="single" class="w-full" collapsible :default-value="defaultValue">
    <AccordionItem v-for="article in articles" :key="article.id" :value="article.id.toString()">
      <AccordionTrigger class="text-xl">{{ article.title }}</AccordionTrigger>
      <AccordionContent>
        <div>
          {{ article.content }}
        </div>
        <div class="flex gap-3">
          <NewsEditComponent @refreshList="fetchData" :article="article"> <Button class="my-4">EDIT</Button></NewsEditComponent>
          <NewsAuthorAddComponent @refreshList="fetchData" :article="article"> <Button class="my-4">ADD NEW AUTHOR</Button></NewsAuthorAddComponent>
        </div>
        <div v-if="article.authors.length > 0" class="mt-5">
          <span class="text-2xl">Authors:</span>
          <span class="flex flex-col" v-for="author in article.authors">
            <div class="my-2 flex flex-row justify-between items-center w-1/6 min-w-48">
              <Badge class="h-fit text-sm">{{ author.name }}</Badge> <Button variant="destructive">DELETE</Button>
            </div>
          </span>
        </div>
      </AccordionContent>
    </AccordionItem>
  </Accordion>
</template>