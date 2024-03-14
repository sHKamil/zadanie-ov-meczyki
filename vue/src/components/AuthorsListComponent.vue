<script setup lang="ts">
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion'
import { GetBackendUrl } from '@/utils/GetBackendUrl';
import { ref } from 'vue';
import { Button } from './ui/button';
import { Skeleton } from './ui/skeleton';
import type { AuthorWtihArticlesType } from '@/utils/types/AuthorWtihArticlesType';
import { useRemoveAuthor } from '@/composable/useRemoveAuthor';

const defaultValue = '0';

const authors = ref<AuthorWtihArticlesType[] | null>(null);
const url = GetBackendUrl();

async function removeAuthor (author_id: number) {
  await useRemoveAuthor(author_id);
  fetchData();
}

async function fetchData() {
  authors.value = null;
  const res = await fetch(
    url + '/authors'
  )
  authors.value = await res.json();
}

fetchData()

defineExpose({
  fetchData,
});

</script>

<template>
  <Accordion type="single" class="w-full overflow-x-hidden" collapsible :default-value="defaultValue">
    <AccordionItem v-if="authors" v-for="author in authors" :key="author.id" :value="author.id.toString()">
      <AccordionTrigger class="text-xl">{{ author.name }}</AccordionTrigger>
      <AccordionContent>
        <Button @click="removeAuthor(author.id)" variant="destructive">Remove author</Button>
        <br><span class="text-lg mt-4 block">Articles:</span>
          <Accordion type="single" class="w-4/6 overflow-x-hidden" collapsible :default-value="defaultValue">          
            <AccordionItem v-for="article in author.articles" :key="article.id" :value="article.id.toString()">
              <AccordionTrigger class="text-sm">
                <div class="w-full flex justify-between mx-2">
                  <div>Title: {{ article.title }}</div>
                  <div>Date: {{ article.create_date.date.split(" ")[0] }}</div>
                </div>
              </AccordionTrigger>
              <AccordionContent class="mx-4 text-xs">
                  {{ article.content }}
              </AccordionContent>
            </AccordionItem>
          </Accordion>
      </AccordionContent>

    </AccordionItem>
      <div v-else class="flex items-center space-x-4 w-full">
        <div class="space-y-6 w-full">
          <Skeleton class="h-14 w-full" />
          <Skeleton class="h-14 w-full" />
          <Skeleton class="h-14 w-full" />
          <Skeleton class="h-14 w-full" />
        </div>
      </div>
  </Accordion>
</template>
