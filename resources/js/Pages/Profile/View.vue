<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ViewUserProfile from "./Partials/ViewUserProfile.vue";
</script>
<template>
    <Head title="Profile" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>
        <ViewUserProfile />
    </AuthenticatedLayout>
</template>
