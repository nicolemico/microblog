<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { useModalStore } from "@/Store/modalStore";
import { storeToRefs } from "pinia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PostList from "@/Components/Post/PostList.vue";
import PostModal from "@/Modals/PostModal.vue";
import Card from "@/Components/Card.vue";

const page = usePage();
const user = computed(() => page.props.auth.user);
const modalStore = useModalStore();
const { getModalByName } = storeToRefs(modalStore);
console.log(computed(() => page.props).value)

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-12 max-w-4xl mx-auto sm:px-6 lg:px-8">
            <Card>
                <div class="flex gap-4">
                    <img src="" alt="profile picture" class="w-9 h-9 rounded-full" />
                    <SecondaryButton @click="modalStore.toggleModal('postModal', true)">What's on your mind, {{ user.name
                    }}?
                    </SecondaryButton>
                </div>
            </Card>
            <PostList />
        </div>
        <PostModal />
    </AuthenticatedLayout>
</template>
