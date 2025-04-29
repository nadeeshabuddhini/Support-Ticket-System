<template>
  <div class="min-h-screen flex flex-col">
    <!-- Navbar (full width) -->
    <nav class="flex justify-end p-6 space-x-4 shadow mb-6 bg-red-300">
      <Link :href="route('login')" class="px-4 py-2 font-semibold text-blue-600 hover:text-blue-800">Login</Link>
      <Link :href="route('register')" class="px-4 py-2 font-semibold bg-blue-600 text-white rounded hover:bg-blue-700">Register</Link>

    </nav>

    <!-- Content Area -->
    <div class="flex flex-1">
      <!-- Left side: Image -->
      <div
        class="w-1/2 bg-cover bg-center"
        :style="{ backgroundImage: 'url(/assets/home-bg.jpg)' }"
      ></div>

      <!-- Right side: Text Content -->
      <div class="w-1/2 flex flex-col justify-center px-12">
        <h1 class="font-bold mb-6 text-gray-800" style="color: #9370db; font-size: 42px;">Welcome to the Ticketing System</h1>
        <p class="text-xl mb-4 text-gray-600">This is a simple ticketing system where you can create and manage tickets.</p>
        <p class="text-xl mb-4 text-gray-600">Please log in to access your tickets.</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<style scoped>
/* no extra css */
</style>
