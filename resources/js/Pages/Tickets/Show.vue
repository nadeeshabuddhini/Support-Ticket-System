<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Ticket Details</h1>

    <div class="bg-white rounded shadow p-6 mb-8">
      <h2 class="text-xl font-semibold mb-2">{{ ticket.subject }}</h2>
      <p class="text-gray-700 mb-2"><strong>Category:</strong> {{ ticket.category }}</p>
      <p class="text-gray-700 mb-2"><strong>Priority:</strong> {{ ticket.priority }}</p>

      <!-- Status Dropdown (Admin + User both) -->
      <div class="mt-4">
        <form @submit.prevent="updateStatus">
          <label class="block mb-2 font-semibold">Status:</label>
          <select v-model="statusForm.status" class="w-full border rounded p-2 mb-4">
            <option value="Open">Open</option>
            <option value="In Progress">In Progress</option>
            <option value="Resolved">Resolved</option>
          </select>

          <button
            type="submit"
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
            :disabled="statusForm.processing"
          >
            Update Status
          </button>
        </form>
      </div>

      <p class="text-gray-700 mb-2 mt-4"><strong>Description:</strong></p>
      <p class="text-gray-600">{{ ticket.description }}</p>
    </div>

    <!-- Comments Section -->
    <div class="bg-white rounded shadow p-6 mb-8">
      <h2 class="text-xl font-semibold mb-4">Comments</h2>

      <div v-if="ticket.comments.length === 0" class="text-gray-500">
        No comments yet.
      </div>

      <div v-else class="space-y-4">
        <div v-for="comment in ticket.comments" :key="comment.id" class="border p-4 rounded">
          <p class="text-gray-700">{{ comment.message }}</p>
          <div class="text-sm text-gray-500 mt-2">
            By: {{ comment.user.name }} | {{ new Date(comment.created_at).toLocaleString() }}
          </div>
        </div>
      </div>
    </div>

    <!-- Add Comment Form -->
    <div class="bg-white rounded shadow p-6">
      <h2 class="text-xl font-semibold mb-4">Add a Comment</h2>

      <form @submit.prevent="submit">
        <div class="mb-4">
          <textarea v-model="form.message" class="w-full border rounded p-2" rows="4" placeholder="Type your comment..."></textarea>
          <div v-if="form.errors.message" class="text-red-500 text-sm">{{ form.errors.message }}</div>
        </div>

        <button
          type="submit"
          class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"
          :disabled="form.processing"
        >
          Submit Comment
        </button>
      </form>
    </div>

  </div>
</template>

<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const props = defineProps({
  ticket: Object,
});

// Form for adding comments
const form = useForm({
  message: '',
});

// Form for updating status
const statusForm = useForm({
  status: props.ticket.status, // Set initial status
});

// Submit Comment
function submit() {
  form.post(route('tickets.addComment', props.ticket.id), {
    onSuccess: () => {
      form.reset();
      router.reload({ only: ['ticket'] });
    },
  });
}

// Update Ticket Status
function updateStatus() {
  statusForm.put(route('tickets.updateStatus', props.ticket.id), {
    onSuccess: () => {
      alert('Status updated successfully!'); // <-- show alert
      router.reload({ only: ['ticket'] });    // reload ticket to update view
    },
  });
}
</script>
