<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Card from "@/Components/Card.vue";

const page = usePage();
const user = computed(() => page.props.auth.user);

</script>
<template>
    <Card>
        <div class="flex items-center gap-4">
            <img src="" alt="profile picture" class="rounded-full w-9 h-9" />
            <div class="flex flex-col">
                <span>{{ user.name }}</span>
                <span class="text-xs text-gray-400">10m ago</span>
            </div>
        </div>
    </Card>
</template>
