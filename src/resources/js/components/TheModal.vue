<script setup lang="ts">
defineProps<{
    show: boolean;
}>();
defineEmits<{
    closeModal: [];
}>();
</script>

<template>
    <Transition enter-from-class="opacity-0 scale-125" enter-to-class="opacity-1 scale-100"
        enter-active-class="transition duration-300" leave-active-class="transition duration-200"
        leave-from-class="opacity-1" leave-to-class="opacity-0">
        <aside v-show="show" class="flex justify-center items-center fixed inset-0 bg-slate-800/80 backdrop-blur-sm z-50">
            <div class="bg-slate-700 text-white p-4 border border-white rounded-md w-[90%] max-w-[500px]">
                <header class="flex justify-between items-center text-2xl mb-2">
                    <slot name="header" />
                    <button class="scale-125 hover:text-amber-400 focus:text-amber-400" @click="$emit('closeModal')">
                        &times;
                    </button>
                </header>
                <slot />
                <footer class="mt-2 pt-2 border-t border-t-slate-500">
                    <slot name="footer" />
                </footer>
            </div>
        </aside>
    </Transition>
</template>
