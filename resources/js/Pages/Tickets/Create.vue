<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-purple-500 to-indigo-500">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col md:flex-row w-full max-w-5xl">
      
      <!-- Left side: Image -->
      <div
        class="w-full md:w-1/2 h-64 md:h-auto bg-cover bg-center"
        :style="{ backgroundImage: 'url(/assets/create_page_bg.jpg)' }"
      ></div>

      <!-- Right side: Form -->
      <div class="w-full md:w-1/2 p-8">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Create Ticket</h1>

        <form @submit.prevent="submit">
          <div class="mb-4">
            <label class="block mb-2 font-semibold text-gray-700">Subject</label>
            <input v-model="form.subject" type="text" class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-purple-500" />
            <div v-if="form.errors.subject" class="text-red-500 text-sm mt-1">{{ form.errors.subject }}</div>
          </div>

          <div class="mb-4">
            <label class="block mb-2 font-semibold text-gray-700">Description</label>
            <textarea v-model="form.description" class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-purple-500"></textarea>
            <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</div>
          </div>

          <div class="mb-4">
            <label class="block mb-2 font-semibold text-gray-700">Category</label>
            <input v-model="form.category" type="text" class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-purple-500" />
            <div v-if="form.errors.category" class="text-red-500 text-sm mt-1">{{ form.errors.category }}</div>
          </div>

          <div class="mb-6">
            <label class="block mb-2 font-semibold text-gray-700">Priority</label>
            <select v-model="form.priority" class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-purple-500">
              <option value="">Select Priority</option>
              <option value="Low">Low</option>
              <option value="Medium">Medium</option>
              <option value="High">High</option>
            </select>
            <div v-if="form.errors.priority" class="text-red-500 text-sm mt-1">{{ form.errors.priority }}</div>
          </div>

          <div class="flex justify-between">
            <button
              type="button"
              class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400"
              @click="form.reset()"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700"
              :disabled="form.processing"
            >
              Submit
            </button>
          </div>
        </form>
      </div>

    </div>
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
