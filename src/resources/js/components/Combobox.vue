<template>
    <Combobox :modelValue="modelValue" @update:modelValue="handleUpdate">
        <ComboboxLabel v-if="label">{{ label }}</ComboboxLabel>
        <div class="relative mt-1">
            <div
                class="relative w-full cursor-default overflow-hidden rounded-sm bg-white text-left shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75 focus-visible:ring-offset-2 focus-visible:ring-offset-teal-300 sm:text-sm"
            >
                <ComboboxInput
                    class="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 text-gray-900 focus:ring-0"
                    :displayValue="(option: any) => option"
                    @change="query = $event.target.value"
                />
                <ComboboxButton
                    class="absolute inset-y-0 right-0 flex items-center pr-2"
                >
                    <IconChevron
                        class="fill-gray-400 w-5 h-5"
                        aria-hidden="true"
                    />
                </ComboboxButton>
            </div>
        </div>

        <TransitionRoot
            leave="transition ease-in duration-100"
            leaveFrom="opacity-100"
            leaveTo="opacity-0"
            @after-leave="query = ''"
        >
            <ComboboxOptions
                class="absolute mt-1 max-h-60 overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm"
            >
                <ComboboxOption
                    v-if="queryOption && !filteredOptions.length"
                    as="ul"
                    :value="queryOption"
                    v-slot="{ active }"
                >
                    <li
                        class="relative cursor-default select-none py-2 pl-10 pr-4"
                        :class="{
                            'bg-orange-400 text-white': active,
                            'text-gray-900': !active,
                        }"
                    >
                        <span class="block truncate">
                            New category: "{{ queryOption.label }}"
                        </span>
                        <span
                            class="absolute inset-y-0 left-0 flex items-center pl-3"
                            :class="{
                                'text-white': active,
                                'text-teal-600': !active,
                            }"
                        >
                            <IconPlus
                                class="h-5 w-5 text-amber-600"
                                aria-hidden="true"
                            />
                        </span>
                    </li>
                </ComboboxOption>

                <ComboboxOption
                    v-for="option in filteredOptions"
                    as="template"
                    :key="option.value"
                    :value="option"
                    v-slot="{ selected, active }"
                >
                    <li
                        class="relative cursor-default select-none py-2 pl-10 pr-4"
                        :class="{
                            'bg-orange-400 text-white': active,
                            'text-gray-900': !active,
                        }"
                    >
                        <span
                            class="block truncate"
                            :class="{
                                'font-medium': selected,
                                'font-normal': !selected,
                            }"
                        >
                            {{ option.label }}
                        </span>
                        <span
                            v-if="selected"
                            class="absolute inset-y-0 left-0 flex items-center pl-3"
                            :class="{
                                'text-white': active,
                                'text-teal-600': !active,
                            }"
                        >
                            <IconCheck
                                class="h-5 w-5 text-amber-600"
                                aria-hidden="true"
                            />
                        </span>
                    </li>
                </ComboboxOption>
            </ComboboxOptions>
        </TransitionRoot>
    </Combobox>
</template>

<script setup lang="ts">
import { ref, computed } from "vue";
import {
    Combobox,
    ComboboxInput,
    ComboboxLabel,
    ComboboxButton,
    ComboboxOptions,
    ComboboxOption,
    TransitionRoot,
} from "@headlessui/vue";
import IconChevron from "@/components/icons/IconChevron.vue";
import IconCheck from "@/components/icons/IconCheck.vue";
import IconPlus from "@/components/icons/IconPlus.vue";

type ComboboxOption = {
    value: number | string;
    label: string;
};

type ComboboxProps = {
    modelValue?: string;
    options?: ComboboxOption[];
    label?: string;
};

const props = withDefaults(defineProps<ComboboxProps>(), {
    options: () => [],
});

const emit = defineEmits<{
    "update:modelValue": [value: string];
}>();

const query = ref("");

const queryOption = computed(() => {
    return query.value === ""
        ? null
        : {
              value: -1,
              label: query.value,
          };
});

const filteredOptions = computed(() =>
    query.value === ""
        ? props.options
        : props.options.filter((option) =>
              option.label
                  .toLowerCase()
                  .replace(/\s+/g, "")
                  .includes(query.value.toLowerCase().replace(/\s+/g, "")),
          ),
);

function handleUpdate(selection: any) {
    emit("update:modelValue", selection.label);
}
</script>
