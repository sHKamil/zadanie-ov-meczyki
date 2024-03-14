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
import { cn } from '@/lib/utils'
import { Button } from './ui/button';
import { useToast } from './ui/toast';
import { toTypedSchema } from '@vee-validate/zod';
import * as z from 'zod'
import { useForm } from 'vee-validate';
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from './ui/form';
import { useAddAuthorToNews } from '@/composable/useAddAuthorToNews';
import { ref, watch } from 'vue';
import { useAuthors } from '@/composable/useAuthors';
import { Popover, PopoverContent, PopoverTrigger } from './ui/popover';
import { Check, ChevronsUpDown } from 'lucide-vue-next';
import { Command, CommandGroup, CommandItem, CommandList } from './ui/command';

const emit = defineEmits(['refreshList']);

const props = defineProps<{
    article: NewsWithAuthorsType
}>();

const { toast } = useToast();
const authors = useAuthors();
const availableAuthors = ref();
const open = ref(false);
const value = ref<number>();
const placeholder = ref("Select author...");

function setPlaceholder() {
  if(authors.authors.data!==null && value.value) {
    let tempholder = authors.authors.data.value?.find(author => {
      if(author.id === value.value) {
        return author.name;
      }
    });   
    if (tempholder && typeof(tempholder.name) === 'string') {
      placeholder.value = tempholder.name;
    }
  }
}

const formSchema = toTypedSchema(z.object({
  author: z.number({
    required_error: 'Please select a author.',
  })
}))

const { handleSubmit, setValues, values  } = useForm({
  validationSchema: formSchema,
})

const onSubmit =  handleSubmit(async (values) => { 
  await useAddAuthorToNews(props.article.id, values.author);
  emit('refreshList')
  toast({
    title: 'Author added'
  })
})

const cutActualAuthors = () => {
  availableAuthors.value = authors.authors.data.value?.filter(author => !props.article.authors.some(actualAuthor => author.id === actualAuthor.id));
}

watch(authors.authors.data, cutActualAuthors);
watch(value, setPlaceholder);
</script>

<template>
  <Drawer>
    <DrawerTrigger><slot></slot></DrawerTrigger>
    <DrawerContent>
      <DrawerHeader class="mx-auto">
        <DrawerTitle>Add new author</DrawerTitle>
        <DrawerDescription>to {{ article.title }} article</DrawerDescription>
      </DrawerHeader>
      <form class="w-4/12 mx-auto my-16 space-y-6 " @submit.prevent="onSubmit">
        <FormField name="author">
                <FormItem>
                <FormLabel>Author</FormLabel>
                  <Popover v-model:open="open">
                    <PopoverTrigger as-child>
                      <FormControl>
                        <Button
                          variant="outline"
                          role="combobox"                          
                          :aria-expanded="open"
                          class="w-full justify-between"
                        >
                          {{ placeholder }}
                          <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                        </Button>
                      </FormControl>
                    </PopoverTrigger>
                    <PopoverContent class="w-4/12 mx-auto p-0">
                      <Command>
                        <CommandList>
                          <CommandGroup class="max-h-32 overflow-y-scroll">
                            <CommandItem
                              v-for="author in availableAuthors"
                              :key="author.id"
                              :value="author.id"
                              @select="(ev) => {
                                setValues({
                                  author: author.id,
                                });
                                if (typeof ev.detail.value === 'number') {
                                  value = ev.detail.value
                                }
                                open = false;
                              }"
                            >
                              {{ author.name }}
                              <Check
                                :class="cn(
                                  'ml-auto h-4 w-4',
                                  value === author.id ? 'opacity-100' : 'opacity-0',
                                )"
                              />
                            </CommandItem>
                          </CommandGroup>
                        </CommandList>
                      </Command>
                    </PopoverContent>
                  </Popover>
                <FormDescription />
                <FormMessage />
              </FormItem>
            </FormField>
      <DrawerFooter>
        <DrawerClose>
          <Button type="submit" class="w-fit mx-auto">Submit</Button>
          <Button variant="outline">
            Cancel
          </Button>
        </DrawerClose>
      </DrawerFooter>
      </form>
    </DrawerContent>
  </Drawer>
</template>
