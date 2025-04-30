<template>
  <div class="min-h-screen flex flex-col">
    <!-- Navbar -->
    <Navbar>
      <Button :value="'Login'" :href="route('login')"/>
      <Button :value="'Register'" :href="route('register')"/>
    </Navbar>
   

    <!-- Content Area -->
    <div class="flex flex-col md:flex-row flex-1">
      <!-- Left side: Image -->
      <div
        class="w-full md:w-1/2 h-64 md:h-auto bg-cover bg-center"
        :style="{ backgroundImage: 'url(/assets/home-bg.jpg)' }">
      </div>

      <!-- Right side: Text Content -->
      <div class="w-full md:w-1/2 flex flex-col justify-center p-6 md:px-12">
        <h1 class="font-bold text-3xl md:text-5xl mb-6 text-purple-500">
          Welcome to the Customer Support Ticketing System
        </h1>
        <p class="text-lg md:text-xl mb-4 text-black text-center md:text-left">
          This is a Customer Support Ticketing System where you can create and manage tickets.
        </p>
        <p class="text-lg md:text-xl text-black text-center md:text-left">
          Please log in to access your tickets.
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import Navbar from '@/Components/Navbar.vue';
</script>

<style scoped>

</style>
