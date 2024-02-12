<script setup lang="ts">
import FileUpload from '@/Components/FileUpload.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import { useModalStore } from '@/Store/modalStore';
import { XMarkIcon } from '@heroicons/vue/24/solid';
import { useForm, usePage } from '@inertiajs/vue3';
import { storeToRefs } from 'pinia';
import { onUnmounted } from 'vue';
import { computed, ref } from 'vue';
import Swal from 'sweetalert2';

const page = usePage();
const modalStore = useModalStore();
const { getModalByName } = storeToRefs(modalStore);
const postModal = computed(() => getModalByName.value('postModal'));

const user = computed(() => page.props.auth.user);
const errors = computed(() => page.props.errors);

const form = useForm({
    'postContent': '',
    'postImage': null,
    'type': 1,
});

const imageSrcs = computed(() => form.postImage ? Array.from(form.postImage).map((file: Blob) => URL.createObjectURL(file)) : []);

function handleFileUpload(fileList: FileList) {
    form.postImage = fileList;
}

function cleanUpSrc() {
    imageSrcs.value.forEach((src => {
        URL.revokeObjectURL(src);
    }))
}

function handleRemoveImage(index: number) {
    const postImage = form.postImage;
    postImage.splice(index, 1);
}

function closePostModal() {
    cleanUpSrc();
    form.reset();
    modalStore.toggleModal('postModal', false);
}

function submitPost() {
    form.processing = true;
    form.post(route('post.store'), {
        onSuccess: () => {
            Swal.fire({
                text: 'Post create successful',
                icon: 'success',
            });
            form.reset();
            modalStore.toggleModal('postModal', false);
        },
        onError: () => {
            Swal.fire({
                text: 'Failed to create post',
                icon: 'error',
            });
        }
    });
}

function handlePostContentChange(value: string) {
    form.postContent = value;
}

onUnmounted(() => {
    cleanUpSrc();
})

</script>
<template>
    <Modal :show="postModal.isOpen" @close="closePostModal" title="Create Post">
        <form @submit.prevent="submitPost">
            <div class="flex flex-col gap-2">
                <div class="flex">
                    <img src="" class="h-6 w-6 rounded-full" />
                    <span class="bold grow">{{ user.name }}</span>
                </div>
                <TextAreaInput @update:model-value="handlePostContentChange" :model-value="form.postContent"
                    :placeholder="`What's on your mind, ${user.name}?`" :rows="3"
                    :additionalClass="(form.isDirty && form.postContent.trim() === '') || (errors.postContent !== undefined && form.postContent.trim() === '') ? 'border-red-500' : ''" />
                <div class="flex flex-row gap-2">
                    <div v-for="(src, index) in imageSrcs" class="relative group">
                        <img :src="src" class="w-32 h-32 object-cover" />
                        <XMarkIcon
                            class="h-5 w-5 bg-white hidden absolute top-0 right-0 hover:text-red-500 cursor-pointer group-hover:block"
                            @click="handleRemoveImage(index)" />
                    </div>
                </div>
                <div class="border p-2 rounded-md flex items-center">
                    <span class="grow">Add to your post</span>
                    <FileUpload @update:model-value="handleFileUpload" />
                </div>
                <div class="flex justify-end gap-3">
                    <SecondaryButton @click="closePostModal">Cancel</SecondaryButton>
                    <PrimaryButton type="submit" :disabled="form.postContent.length === 0">
                        Post
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>
