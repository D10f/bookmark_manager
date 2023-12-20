declare namespace App.Models {
    export interface Bookmark {
        id: number;
        name: string;
        url: string;
        order: number;
        category_id: number;
        edit_url?: string;
        is_new?: boolean;
    }

    export interface Category {
        id: number;
        title: string;
        order: number;
        parent_id: number | null;
        bookmarks: App.Models.Bookmark[];
        edit_url?: string;
    }

    export interface User {
        id: number;
        name: string | null;
        email: string;
    }
}
