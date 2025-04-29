<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navbar -->
  <!-- Tickets Navbar (Matches Home Page Style) -->
<nav class="flex flex-col sm:flex-row justify-between items-center p-4 md:p-6 shadow mb-6 bg-gradient-to-r from-blue-600 via-blue-200 to-purple-600 text-white">
  <div class="text-lg sm:text-xl font-bold">Support Tickets</div>
  <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4 mt-2 sm:mt-0">
    <span class="text-sm sm:text-base font-medium">Welcome, {{ page.props.auth.user.name }}</span>
    <Link
      href="/logout"
      method="post"
      as="button"
      class="px-4 py-2 font-semibold bg-blue-600 text-white rounded hover:bg-blue-700 text-sm"
    >
      Logout
    </Link>
  </div>
</nav>


    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
      <!-- Create Ticket Button -->
      <div class="flex justify-end mb-4" v-if="!isAdmin">
        <Link
          href="/tickets/create"
          class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded text-sm"
        >
          + Create Ticket
        </Link>
      </div>

      <!-- Filters -->
      <div class="bg-white shadow rounded-md p-4 mb-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
          <select
            id="status"
            v-model="filters.status"
            class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
          >
            <option value="">All</option>
            <option value="Open">Open</option>
            <option value="In Progress">In Progress</option>
            <option value="Resolved">Resolved</option>
          </select>
        </div>
        <div>
          <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
          <select
            id="priority"
            v-model="filters.priority"
            class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
          >
            <option value="">All</option>
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
          </select>
        </div>
      </div>

      <!-- Table (Responsive) -->
      <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 sm:px-6 py-3 text-left font-medium text-gray-700">Subject</th>
              <th class="px-4 sm:px-6 py-3 text-left font-medium text-gray-700">Category</th>
              <th class="px-4 sm:px-6 py-3 text-left font-medium text-gray-700">Priority</th>
              <th class="px-4 sm:px-6 py-3 text-left font-medium text-gray-700">Status</th>
              <th class="px-4 sm:px-6 py-3 text-left font-medium text-gray-700">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 bg-white">
            <tr
              v-for="ticket in filteredTickets"
              :key="ticket.id"
              class="hover:bg-gray-50 transition"
            >
              <td class="px-4 sm:px-6 py-3 text-gray-800">{{ ticket.subject }}</td>
              <td class="px-4 sm:px-6 py-3 text-gray-600">{{ ticket.category }}</td>
              <td class="px-4 sm:px-6 py-3">
                <span
                  :class="{
                    'text-red-600 bg-red-100': ticket.priority === 'High',
                    'text-yellow-600 bg-yellow-100': ticket.priority === 'Medium',
                    'text-green-600 bg-green-100': ticket.priority === 'Low'
                  }"
                  class="px-2 py-0.5 rounded-full text-xs font-semibold"
                >
                  {{ ticket.priority }}
                </span>
              </td>
              <td class="px-4 sm:px-6 py-3">
                <span
                  :class="{
                    'text-green-700 bg-green-100': ticket.status === 'Resolved',
                    'text-yellow-700 bg-yellow-100': ticket.status === 'In Progress',
                    'text-red-700 bg-red-100': ticket.status === 'Open'
                  }"
                  class="px-2 py-0.5 rounded-full text-xs font-semibold"
                >
                  {{ ticket.status }}
                </span>
              </td>
              <td class="px-4 sm:px-6 py-3">
                <Link
                  :href="route('tickets.show', ticket.id)"
                  class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-xs"
                >
                  View
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>



<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { reactive, computed } from 'vue';


// Get user roles from shared props
const page = usePage();

const isAdmin = computed(() => {
  return page.props.auth.user.roles.includes('admin');
});
console.log('User roles:', page.props.auth.user.roles);
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
