import { ref } from "vue";
import { defineStore } from "pinia";
import { midString } from "@/helpers/lexicographic";
import { getCookie } from "@/helpers/api";
import { useCategoryStore } from "./category";

export const useDragStore = defineStore("drag", () => {
    const item = ref<App.Models.Category | App.Models.Bookmark | null>(null);
    const categoryIndex = ref(-1);
    const categoryCardId = ref(-1);
    const categoryItems = ref<
        (App.Models.Category | App.Models.Bookmark)[] | null
    >(null);
    const droppedCategory = ref<App.Models.Category | null>(null);
    // const previousCategory = ref<number | null>(null);

    const categoryStore = useCategoryStore();

    function commit() {
        if (
            !item.value ||
            categoryIndex.value < 0 ||
            categoryCardId.value < 0 ||
            !categoryItems.value
        )
            return;

        // const prev = categoryItems.value![categoryIndex.value - 1]
        //     ? categoryItems.value![categoryIndex.value - 1].order
        //     : "";

        // const next = categoryItems.value![categoryIndex.value]
        //     ? categoryItems.value![categoryIndex.value].order
        //     : "";

        // console.log(
        //     categoryIndex.value,
        //     "[" + categoryItems.value!.map((c) => c.order).join(", ") + "]",
        //     prev,
        //     next,
        // );

        // const order = midString(prev, next);

        const order = getIndex(categoryItems.value, categoryIndex.value);

        if (item.value!.hasOwnProperty("category_id")) {
            (item.value as App.Models.Bookmark).category_id =
                categoryCardId.value;
        } else {
            (item.value as App.Models.Category).parent_id =
                categoryCardId.value;
        }

        const url = item.value!.hasOwnProperty("parent_id")
            ? `/api/categories/update/${item.value!.id}`
            : `/api/bookmarks/update/${item.value!.id}`;

        fetch(url, {
            method: "PUT",
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-XSRF-TOKEN": getCookie("XSRF-TOKEN"),
            },
            body: JSON.stringify({
                parent_id: categoryCardId.value,
                order,
            }),
        });
    }

    function getIndex(
        items: (App.Models.Bookmark | App.Models.Category)[],
        idx: number,
    ) {
        const prev = items[idx - 1] ? items[idx - 1].order : "";

        const next = items[idx - 1] ? items[idx - 1].order : "";

        return midString(prev, next);
    }

    function reset() {
        item.value = null;
        categoryIndex.value = -1;
        categoryCardId.value = -1;
        categoryItems.value = null;
        droppedCategory.value = null;
        // previousCategory.value = null;
    }

    return {
        item,
        categoryIndex,
        categoryCardId,
        categoryItems,
        droppedCategory,
        getIndex,
        commit,
        reset,
    };
});
