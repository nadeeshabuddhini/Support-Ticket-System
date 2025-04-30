<template>
  <div class="min-h-screen bg-gradient-to-r from-purple-500 to-indigo-500 flex items-center justify-center px-4 py-10">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl p-8 space-y-8">

      <!-- Ticket Info -->
      <div>
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Ticket Details</h1>
        <div class="space-y-4">
          <h2 class="text-xl font-semibold text-purple-700">{{ ticket.subject }}</h2>
          <p class="text-gray-700"><strong>Category:</strong> {{ ticket.category }}</p>
          <p class="text-gray-700"><strong>Priority: </strong> 
          <span
            :class="{
              'text-red-600 bg-red-100 px-4 py-1 rounded': ticket.priority === 'High',
              'text-orange-600 bg-orange-100 px-4 py-1 rounded': ticket.priority === 'Medium',
              'text-green-600 bg-green-100 px-4 py-1 rounded': ticket.priority === 'Low'
            }"
          >
            {{ ticket.priority }}
          </span>
          </p>
          <form @submit.prevent="updateStatus" class="flex flex-col sm:flex-row sm:items-center sm:gap-4 gap-2">
            <label class="text-gray-700 font-semibold whitespace-nowrap">Status:</label>
            <select v-model="statusForm.status" class="border rounded px-8 py-2 focus:ring-2 focus:ring-purple-500">
              <option value="Open">Open</option>
              <option value="In Progress">In Progress</option>
              <option value="Resolved">Resolved</option>
            </select>
      
            <FormButton :disabled="statusForm.processing">
                Update Status
            </FormButton>
            <div v-if="showStatusMessage" class="text-green-600 text-sm mt-2">
                Status updated successfully!
            </div>
          </form>
          <div>
            <p class="text-gray-700 font-semibold mt-4">Description:</p>
            <p class="text-gray-600">{{ ticket.description }}</p>
          </div>
        </div>
      </div>


      <!-- Comments -->
      <div class="bg-gray-50 rounded p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Comments</h2>

        <div v-if="ticket.comments.length === 0" class="text-gray-500">
          No comments yet.
        </div>

        <div v-else class="space-y-4">
          <div
            v-for="comment in ticket.comments"
            :key="comment.id"
            class="bg-white border border-gray-200 p-4 rounded shadow-sm"
          >
            <p class="text-gray-700">{{ comment.message }}</p>
            <div class="text-sm text-gray-500 mt-2">
              By: {{ comment.user.name }} | {{ new Date(comment.created_at).toLocaleString() }}
            </div>
          </div>
        </div>
      </div>

      <!-- Add Comment -->
      <div class="bg-gray-50 rounded p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Add a Comment</h2>

        <form @submit.prevent="submit" class="space-y-4">
          <textarea
            v-model="form.message"
            class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-purple-500"
            rows="4"
            placeholder="Type your comment..."
          ></textarea>
          <div v-if="form.errors.message" class="text-red-500 text-sm">{{ form.errors.message }}</div>

          <FormButton :disabled="form.processing">
            Submit Comment
          </FormButton>
        </form>
      </div>

      <div class="flex justify-end mb-4">
        <Link
          :href="route('tickets.index')"
          class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center"
        >
          ← Go Back
        </Link>
      </div>

    </div>
  </div>
</template>


<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import FormButton from '@/Components/FormButton.vue';


const showStatusMessage = ref(false);

const props = defineProps({
  ticket: Object,
});

// Form for adding comments
const form = useForm({
  message: '',
});

// Form for updating status
const statusForm = useForm({
  status: props.ticket.status, 
});


function submit() {
  form.post(route('tickets.addComment', props.ticket.id), {
    preserveScroll: true,     
    preserveState: true,      
    only: ['ticket', 'success'],  
    onSuccess: () => {
      form.reset(); 
    },
  });
}


// Update Ticket Status
function updateStatus() {
  statusForm.put(route('tickets.updateStatus', props.ticket.id), {
    preserveScroll: true,     
    preserveState: true,
    onSuccess: () => {
      showStatusMessage.value = true;
      setTimeout(() => (showStatusMessage.value = false), 3000); 
      router.reload({ only: ['ticket'] });
    },
  });
}
</script>
