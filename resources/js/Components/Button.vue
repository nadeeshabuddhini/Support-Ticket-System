<template>
 <Link :href="href" :method="method" as="button"  class="px-4 md:px-6 py-2 font-semibold bg-blue-600 text-white rounded hover:bg-blue-700">{{value}}</Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    value: {
        type: String,
        default: null,
    },
    href: String,
    method: {
        type: String,
        default: 'get',
    },
});
</script>