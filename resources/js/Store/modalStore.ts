import { ref, computed } from "vue";
import { defineStore } from "pinia";

export const useModalStore = defineStore("modals", {
    state: () => {
        return {
            modal: [
                {
                    name: "postModal",
                    isOpen: false,
                },
            ]
        }
    },
    getters: {
        getModalIndexByName: (state) => (modalName) => state.modal.findIndex(modalItem => modalItem.name === modalName),
        getModalByName: (state) => (modalName) => state.modal.find(modalItem => modalItem.name === modalName),
    },
    actions: {
        toggleModal(modalName, isOpen) {
            const selectedModalIndex = this.getModalIndexByName(modalName);
            this.modal[selectedModalIndex] = {
                ...this.modal[selectedModalIndex],
                isOpen: isOpen,
            };
        }
    }
});
