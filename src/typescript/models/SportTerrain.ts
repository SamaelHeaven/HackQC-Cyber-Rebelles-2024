export interface SportTerrain {
    terrain: string;
    id: string;
    type: string;
    flooring: string | null;
    city: string;
    address: string | null;
    parc: string | null;
    creation_date: Date | null;
    modification_date: Date | null;
    longitude: string;
    latitude: string;
    nb_events: string;
}