export interface Permission {
    id: number;
    name: string;
    slug: string;
    created_at: string;
    updated_at: string;
}
export interface Role {
    id: number;
    name: string;
    slug: string;
    created_at: string;
    updated_at: string;
    permissions: Permission[];
}
