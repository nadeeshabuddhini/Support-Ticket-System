<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Create Ticket</h1>

    <form @submit.prevent="submit">
      <div class="mb-4">
        <label class="block mb-2 font-semibold">Subject</label>
        <input v-model="form.subject" type="text" class="w-full border rounded p-2" />
        <div v-if="form.errors.subject" class="text-red-500 text-sm">{{ form.errors.subject }}</div>
      </div>

      <div class="mb-4">
        <label class="block mb-2 font-semibold">Description</label>
        <textarea v-model="form.description" class="w-full border rounded p-2"></textarea>
        <div v-if="form.errors.description" class="text-red-500 text-sm">{{ form.errors.description }}</div>
      </div>

      <div class="mb-4">
        <label class="block mb-2 font-semibold">Category</label>
        <input v-model="form.category" type="text" class="w-full border rounded p-2" />
        <div v-if="form.errors.category" class="text-red-500 text-sm">{{ form.errors.category }}</div>
      </div>

      <div class="mb-4">
        <label class="block mb-2 font-semibold">Priority</label>
        <select v-model="form.priority" class="w-full border rounded p-2">
          <option value="">Select Priority</option>
          <option value="Low">Low</option>
          <option value="Medium">Medium</option>
          <option value="High">High</option>
        </select>
        <div v-if="form.errors.priority" class="text-red-500 text-sm">{{ form.errors.priority }}</div>
      </div>

      <button
        type="submit"
        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"
        :disabled="form.processing"
      >
        Submit
      </button>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  subject: '',
  description: '',
  category: '',
  priority: '',
});

function submit() {
  form.post(route('tickets.store'), {
    onSuccess: () => form.reset(),
  });
}
</script>
