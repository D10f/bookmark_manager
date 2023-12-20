import { computed, ref } from "vue";
import { defineStore } from "pinia";
import { getCookie } from "@/helpers/api";

export const useCategoryStore = defineStore("category", () => {
    const categories = ref<App.Models.Category[]>([]);

    const topLevelCategories = computed(() =>
        categories.value.filter((c) => c.parent_id === null),
    );

    const categoryNames = computed(() =>
        categories.value
            .map((category) => ({
                value: category.id,
                label: categoryFQDN(category).join("/"),
            }))
            .sort((a, b) => a.label.localeCompare(b.label)),
    );

    async function createCategory(
        categoryName: string,
    ): Promise<App.Models.Category> {
        let parent_id: number | null = null;

        if (isFQDN(categoryName)) {
            const tree = categoryName.split("/").slice(0, -1);

            if (!tree.length) {
                parent_id = null;
            }

            const treeStr = tree.join("/");
            const parent = categoryNames.value.find((c) => c.label === treeStr);

            if (parent) {
                parent_id = parent?.value;
            }
        }

        const res = await fetch("/api/categories/create", {
            method: "POST",
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-XSRF-TOKEN": getCookie("XSRF-TOKEN"),
            },
            body: JSON.stringify({
                title: categoryName.split("/").slice(-1)[0],
                parent_id,
            }),
        });

        const category = await res.json();
        categories.value.push(category);
        return category;
    }

    function getCategoryTree(
        category: App.Models.Category,
    ): App.Models.Category[] {
        if (category.parent_id === null) {
            return [category];
        }

        const parent = categories.value.find(
            (c) => c.id === category.parent_id,
        );

        return [...getCategoryTree(parent!), category];
    }

    function categoryFQDN(category: App.Models.Category): string[] {
        return getCategoryTree(category).map((c) => c.title);
    }

    function isFQDN(categoryName: string) {
        const re = new RegExp(/(?<!\\)\//);
        return re.test(categoryName);
    }

    return {
        categories,
        topLevelCategories,
        categoryNames,
        createCategory,
        getCategoryTree,
        categoryFQDN,
    };
});
