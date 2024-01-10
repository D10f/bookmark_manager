declare namespace App.Models {
    export interface Bookmark {
        id: number;
        name: string;
        url: string;
        order: string;
        category_id: number;
        edit_url?: string;
        is_new?: boolean;
    }

    export interface Category {
        id: number;
        title: string;
        order: string;
        parent_id: number | null;
        bookmarks: App.Models.Bookmark[];
        edit_url?: string;
    }

    export type User = {
        id: number;
        name: string | null;
        email: string;
    };

    export interface Profile {
        user: App.Models.User;
        categories: App.Models.Category[];
        bookamrks: App.Models.Bookmark[];
    }
}
