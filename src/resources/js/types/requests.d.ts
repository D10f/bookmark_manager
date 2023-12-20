declare namespace App.Requests {
    export type CreateBookmark = Pick<
        App.Models.Bookmark,
        "name" | "url" | "category_id"
    >;

    export type UpdateBookmark = Pick<App.Models.Bookmark, "id"> &
        Partial<CreateBookmark & "order">;

    export type CreateCategory = Pick<
        App.Models.Category,
        "title" | "parent_id"
    >;

    export type UpdateCategory = Pick<App.Models.Category, "id"> &
        Partial<CreateCategory & "order">;
}
