import { ref } from "vue";
import { Bookmark } from "@/models/Bookmark";
import { extractDomain } from "@/shared/helpers/urlExtractor";

export function useFavicon(bookmark: Bookmark) {
    const loading = ref(true);
    const error = ref<Error | null>(null);
    const data = ref("");

    function cleanUp() {
        console.log("cleaning up...");
        URL.revokeObjectURL(data.value);
    }

    fetch(`/api/favicon/${extractDomain(bookmark.url)}`)
        .then((response) => response.text())
        .then((buffer) => {
            data.value = buffer.startsWith("http")
                ? buffer
                : `${bookmark.url}${buffer}`;
            // const blob = new Blob([buffer]);
            // const imageUrl = URL.createObjectURL(blob);
            // data.value = imageUrl;
        })
        .catch((e) => (error.value = e))
        .finally(() => (loading.value = false));

    return { loading, error, data, cleanUp };
}
