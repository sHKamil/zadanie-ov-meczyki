<script setup lang="ts">
import { watch, ref } from 'vue'
import { useForm } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import { cn } from '@/lib/utils'
import Input from './ui/input/Input.vue';
import Textarea from './ui/textarea/Textarea.vue';
import Button from './ui/button/Button.vue';
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from './ui/form';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from './ui/card';
import { useToast } from '@/components/ui/toast/use-toast'
import { useAuthors } from '@/composable/useAuthors';
import { Popover, PopoverContent, PopoverTrigger } from './ui/popover';
import { Command, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList } from './ui/command';
import { Check, ChevronsUpDown } from 'lucide-vue-next';
import { useNewNews } from '@/composable/useNewNews'

const emit = defineEmits(['refresh']);
const authors = useAuthors();
const { toast } = useToast();
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
  title: z.string().min(2).max(50),
  content: z.string().min(2).max(3500),
  author: z.number({
  required_error: 'Please select a author.',
  })
}))

const { handleSubmit, setValues, values  } = useForm({
  validationSchema: formSchema,
})

const onSubmit =  handleSubmit(async (values) => {
  await useNewNews(values);
  emit('refresh')
  toast({
    title: 'Article added:',
    description: 'Title: ' + values.title
  })
})

watch(value, setPlaceholder);
</script>

<template>
  <main>
    <Card class="w-fit rounded-2xl p-2">
        <CardHeader>
        <CardTitle>Add new article</CardTitle>
        <CardDescription>Top 3 writers in this week</CardDescription>
        </CardHeader>
        <CardContent class="flex flex-col gap-4">
          <form class="w-full space-y-6" @submit="onSubmit">

            <FormField v-slot="{ componentField }" name="title">
                <FormItem>
                <FormLabel>Title</FormLabel>
                <FormControl>
                  <Input type="text" placeholder="Title" v-bind="componentField" />
                </FormControl>
                <FormDescription />
                <FormMessage />
              </FormItem>
            </FormField>

            <FormField v-slot="{ componentField }" name="content">
                <FormItem>
                <FormLabel>Content</FormLabel>
                <FormControl>
                  <Textarea placeholder="Content" v-bind="componentField" > </Textarea>
                </FormControl>
                <FormDescription />
                <FormMessage />
              </FormItem>
            </FormField>

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
                    <PopoverContent class="w-[200px] p-0">
                      <Command>
                        <CommandInput class="h-9" placeholder="Search author..." />
                        <CommandEmpty>No author found.</CommandEmpty>
                        <CommandList>
                          <CommandGroup>
                            <CommandItem
                              v-for="author in authors.authors.data.value"
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

            <Button type="submit">
              Submit
            </Button>
          </form>
        </CardContent>
    </Card>
    
  </main>
</template>
