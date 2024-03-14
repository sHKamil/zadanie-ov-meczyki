<script setup lang="ts">
import { useForm } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import Input from './ui/input/Input.vue';
import Button from './ui/button/Button.vue';
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from './ui/form';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from './ui/card';
import { useToast } from '@/components/ui/toast/use-toast'
import { useNewAuthor } from '@/composable/useNewAuthor'

const { toast } = useToast();

const formSchema = toTypedSchema(z.object({
  name: z.string().min(2).max(50),
}))

const { handleSubmit } = useForm({
  validationSchema: formSchema,
})

const onSubmit =  handleSubmit(async (values) => {
  await useNewAuthor(values.name);
  toast({
    title: 'Author added:',
    description: 'Author: ' + values.name
  })
})

</script>

<template>
  <main>
    <Card class="w-fit min-w-96 rounded-2xl p-2">
        <CardHeader>
        <CardTitle>Add new author</CardTitle>
        <CardDescription>Register new author</CardDescription>
        </CardHeader>
        <CardContent class="flex flex-col gap-4">
          <form class="w-full space-y-6" @submit.prevent="onSubmit">

            <FormField v-slot="{ componentField }" name="name">
                <FormItem>
                <FormLabel >Author</FormLabel>
                <FormControl >
                  <Input type="text" placeholder="Name" v-bind="componentField" />
                </FormControl>
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
