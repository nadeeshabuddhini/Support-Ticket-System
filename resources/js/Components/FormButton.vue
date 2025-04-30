<template>
  <button
    :type="type"
    class="bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700 transition duration-200"
    :disabled="disabled"
  >
    <slot />
  </button>
</template>

<script setup>
defineProps({
  type: {
    type: String,
    default: 'button',
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  type: { type: String, default: 'submit' },
});
</script>
