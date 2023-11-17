export type Bookmark = {
    id: number;
    name: string;
    url: string;
    category: string;
    edit_url: string;
    is_new: boolean;
};

export type BookmarkCategoryType = {
    order: number;
    collapsed: boolean;
    data: Bookmark[];
};
