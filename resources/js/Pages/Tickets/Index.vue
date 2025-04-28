<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Tickets</h1>

    <!-- Create Ticket Button (only for normal users) -->
    <div class="flex justify-end mb-6" v-if="!isAdmin">
      <Link
        href="/tickets/create"
        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"
      >
        Create Ticket
      </Link>
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
          <tr v-for="ticket in tickets" :key="ticket.id" class="border-b">
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


// Get user roles from shared props
const page = usePage();

const isAdmin = page.props.auth.user.roles.includes('admin');

defineProps({
  tickets: Array
});
</script>
