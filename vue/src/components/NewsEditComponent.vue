<script setup lang="ts">
import {
  Drawer,
  DrawerClose,
  DrawerContent,
  DrawerDescription,
  DrawerFooter,
  DrawerHeader,
  DrawerTitle,
  DrawerTrigger,
} from '@/components/ui/drawer'
import type { NewsWithAuthorsType } from '@/utils/types/NewsWithAuthorsType';
import { Button } from './ui/button';
import { useToast } from './ui/toast';
import { toTypedSchema } from '@vee-validate/zod';
import * as z from 'zod'
import { useForm } from 'vee-validate';
import { useEditNews } from '@/composable/useEditNews';
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from './ui/form';
import { Input } from './ui/input';
import { Textarea } from './ui/textarea';

const emit = defineEmits(['refreshList']);

const props = defineProps<{
    article: NewsWithAuthorsType
}>();
const { toast } = useToast();

const formSchema = toTypedSchema(z.object({
  title: z.string().min(2).max(50),
  content: z.string().min(2).max(3500),
}))

const { handleSubmit, setValues, values  } = useForm({
  validationSchema: formSchema,
})

const onSubmit =  handleSubmit(async (values) => {
  await useEditNews(values);
  emit('refreshList')
  toast({
    title: 'Article changed:',
    description: 'Title: ' + values.title
  })
})

</script>

<template>
  <Drawer>
    <DrawerTrigger><slot></slot></DrawerTrigger>
    <DrawerContent>
      <DrawerHeader>
        <DrawerTitle>Edit {{ article.title }} article</DrawerTitle>
        <DrawerDescription>This action cannot be undone.</DrawerDescription>
      </DrawerHeader>
      <form class="w-4/12 space-y-6 mx-auto" @submit.prevent="onSubmit">
        <FormField class="transition-all" v-slot="{ componentField }" name="title">
            <FormItem>
            <FormLabel class="transition-all">Title</FormLabel>
            <FormControl class="transition-all">
              <Input :default-value="article.title" class="transition-all" type="text" placeholder="Title" v-bind="componentField" />
            </FormControl>
            <FormDescription />
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="content">
            <FormItem>
            <FormLabel>Content</FormLabel>
            <FormControl>
              <Textarea placeholder="Content" :default-value="article.content" v-bind="componentField" > </Textarea>
            </FormControl>
            <FormDescription />
            <FormMessage />
          </FormItem>
        </FormField>
      <DrawerFooter>
        <Button type="submit" class="w-fit mx-auto">Submit</Button>
        <DrawerClose>
          <Button variant="outline">
            Cancel
          </Button>
        </DrawerClose>
      </DrawerFooter>
      </form>
    </DrawerContent>
  </Drawer>
</template>
