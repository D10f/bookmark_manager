declare namespace App.Inertia {
    export type Middleware = {
        auth: {
            user: Pick<App.Models.User, "id" | "name">;
        } | null;
        profile_url: string;
        new_bookmark: number | null;
    };
}
