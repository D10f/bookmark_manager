import { computed, ref } from "vue";
import { defineStore } from "pinia";
import { Category } from "@/types/category";

export const useCategoryStore = defineStore("category", () => {
    const categories = ref<Category[]>([]);

    const topLevelCategories = computed(() =>
        categories.value.filter((c) => c.parent_id === null),
    );

    function loadCategories(newCategories: Category[]) {
        categories.value = newCategories;
    }

    function addCategory(category: Category) {
        categories.value.push(category);
    }

    function getSubcategories(category: Category) {
        return categories.value.filter((c) => c.parent_id === category.id);
    }

    function getCategoryTree(category: Category): Category[] {
        if (category.parent_id === null) {
            return [category];
        }

        const parent = categories.value.find(
            (c) => c.id === category.parent_id,
        );

        return [...getCategoryTree(parent!), category];
    }

    function categoryFQDN(category: Category): string[] {
        const tree = getCategoryTree(category);
        return tree.map((category) => category.title);
    }

    return {
        categories,
        topLevelCategories,
        loadCategories,
        addCategory,
        getSubcategories,
        getCategoryTree,
        categoryFQDN,
    };
});
