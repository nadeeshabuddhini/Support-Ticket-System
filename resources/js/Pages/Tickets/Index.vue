<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Tickets</h1>
    <div class="flex justify-between items-center mb-6">
  <div class="text-lg font-semibold text-gray-700">
    Welcome, {{ page.props.auth.user.name }}
  </div>
  <Link
    href="/logout"
    method="post"
    as="button"
    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded"
  >
    Logout
  </Link>
</div>

    <!-- Create Ticket Button (only for normal users) -->
    <div class="flex justify-end mb-6" v-if="!isAdmin">
      <Link
        href="/tickets/create"
        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"
      >
        Create Ticket
      </Link>
    </div>

     <!-- Filters -->
    <div class="flex gap-4 mb-6">
      <!-- Status Filter -->
      <div>
        <label for="status" class="block text-sm font-medium text-gray-700">Filter by Status</label>
        <select
          id="status"
          v-model="filters.status"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
        >
          <option value="">All</option>
          <option value="Open">Open</option>
          <option value="In Progress">In Progress</option>
          <option value="Resolved">Resolved</option>
        </select>
      </div>

      <!-- Priority Filter -->
      <div>
        <label for="priority" class="block text-sm font-medium text-gray-700">Filter by Priority</label>
        <select
          id="priority"
          v-model="filters.priority"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
        >
          <option value="">All</option>
          <option value="Low">Low</option>
          <option value="Medium">Medium</option>
          <option value="High">High</option>
        </select>
      </div>
    </div>

    <!-- Ticket List -->
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white rounded-lg shadow">
        <thead class="bg-gray-100">
          <tr>
            <th class="py-3 px-4 text-left">Subject</th>
            <th class="py-3 px-4 text-left">Category</th>
            <th class="py-3 px-4 text-left">Priority</th>
            <th class="py-3 px-4 text-left">Status</th>
            <th class="py-3 px-4 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="ticket in filteredTickets" :key="ticket.id" class="border-b">
            <td class="py-3 px-4">{{ ticket.subject }}</td>
            <td class="py-3 px-4">{{ ticket.category }}</td>
            <td class="py-3 px-4">{{ ticket.priority }}</td>
            <td class="py-3 px-4">
              <span
                :class="{
                  'text-green-600': ticket.status === 'Resolved',
                  'text-yellow-600': ticket.status === 'In Progress',
                  'text-red-600': ticket.status === 'Open'
                }"
              >
                {{ ticket.status }}
              </span>
            </td>
            <td class="py-3 px-4">
              <Link
                :href="route('tickets.show', ticket.id)"
                class="text-indigo-600 hover:underline"
              >
                View
              </Link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { reactive, computed } from 'vue';


// Get user roles from shared props
const page = usePage();

const isAdmin = page.props.auth.user.roles.includes('admin');

const props = defineProps({
  tickets: Array, // Correctly define tickets as an array
});
// Filters
const filters = reactive({
  status: '',
  priority: '',
});

// Computed property to filter tickets
const filteredTickets = computed(() => {
  return props.tickets.filter((ticket) => {
    const matchesStatus = !filters.status || ticket.status === filters.status;
    const matchesPriority = !filters.priority || ticket.priority === filters.priority;
    return matchesStatus && matchesPriority;
  });
});
</script>
